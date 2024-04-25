<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->bookRepository->getDataTable();
        }

        return view('book.index');
    }

    public function addBook()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('book.add', compact( 'colors', 'users'));
    }

    public function addBookData(BookStoreRequest $request)
    {
        return $this->bookRepository->createBook($request);
    }

    public function updateBook($bookId)
    {
        $book = Book::findorfail($bookId);

        if (!empty($book)) {
            $series = Series::where('user_id', $book->user_id)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $book->series ? $book->series->id : '';

            return view('book.update', compact('book', 'series', 'selectedSeries', 'colors', 'users'));
        }

        abort(404);
    }

    public function updateBookData($bookId, BookUpdateRequest $request)
    {
        return $this->bookRepository->updateBook($bookId, $request);
    }

    public function getBookDetail($bookId)
    {
        $book = $this->bookRepository->getBookById($bookId);

        return view('book.detail', compact('book'));
    }

    public function changeBookStatus($bookId)
    {
        return $this->bookRepository->changeStatus($bookId);
    }

    public function deleteBook($bookId)
    {
        return $this->bookRepository->deleteBook($bookId);
    }

    public function getUserSeries(Request $request)
    {
        $userId = $request->input('user_id');

        $series = Series::where('status', 1)->where('user_id', $userId)->get();

        $options = '';
        foreach ($series as $item) {
            $options .= '<option value="' . $item->id . '">' . ($item->series_name) . '</option>';
        }

        return response()->json(['options' => $options]);
    }

    public function getBookBySeries(Request $request)
    {
        $seriesId = $request->input('series_id');
        $books = Book::where('series_id', $seriesId)->where('status', 1)->get();

        return response()->json(['options' => $books]);
    }
}
