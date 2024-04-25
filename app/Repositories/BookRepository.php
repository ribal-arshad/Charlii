<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Series;
use App\Models\Book;
use Yajra\DataTables\Facades\DataTables;

class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks()
    {
        return Book::get();
    }

    public function getBookById($bookId)
    {
        return Book::findOrFail($bookId);
    }

    public function deleteBook($bookId)
    {
        $book = $this->getBookById($bookId);
        if (!empty($book)) {
            $book->delete();

            return redirect()->back()->with('success_msg', 'Book successfully deleted.');
        }

        abort(404);
    }

    public function createBook($bookDetails)
    {
        $book = Book::create([
            'user_id' => $bookDetails->user_id,
            'color_id' => $bookDetails->color_id,
            'series_id' => $bookDetails->series_id,
            'image_id' => $bookDetails->image_id,
            'book_name' => $bookDetails->book_name,
            'book_description' => $bookDetails->book_description,
            'is_finished' => $bookDetails->is_finished,
            'status' => $bookDetails->status,
        ]);

        return redirect()->route('manage.books')->with('success_msg', 'Book successfully added.');
    }

    public function updateBook($bookId, $bookDetails)
    {
        $book = Book::findOrFail($bookId);

        if(!empty($book)){
            $book->update([
                'user_id' => $bookDetails['user_id'],
                'color_id' => $bookDetails['color_id'],
                'series_id' => $bookDetails['series_id'],
                'image_id' => $bookDetails['image_id'],
                'book_name' => $bookDetails['book_name'],
                'book_description' => $bookDetails['book_description'],
                'is_finished' => $bookDetails['is_finished'],
                'status' => $bookDetails['status'],
            ]);

            return redirect()->route('manage.books')->with('success_msg', 'Book successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Book not found.');
    }

    public function getDataTable(){

        $query = Book::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        if(strtolower($search) === "active"){
                            $w->orWhere('status', 1);
                        }elseif(strtolower($search) === "inactive"){
                            $w->orWhere('status', 0);
                        }
                    });
                }
            })
            ->addColumn('user_name', function ($obj) {
                return $obj->user->name;
            })
            ->addColumn('series_name', function ($obj) {
                return $obj->series ? $obj->series->series_name : '';
            })
            ->editColumn('is_finished', function ($obj) {
                return $obj->is_finished === 1 ? 'Yes' : 'No';
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('book.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('book.change.status', $obj->id) . '`)" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                              </span>
                                              <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                              </span>
                                            </span>
                                        </label>';
                } else {
                    $switchBtn = $obj->status === 1 ? 'Active' : 'Inactive';
                }

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('book.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('book.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('book.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('book.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('book.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('book.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'is_finished', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($bookId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $book = $this->getBookById($bookId);

        if (!empty($book)) {
            $book->update([
                'status' => !$book->status
            ]);
            $msg = "Book status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
