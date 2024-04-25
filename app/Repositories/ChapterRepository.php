<?php

namespace App\Repositories;

use App\Interfaces\ChapterRepositoryInterface;
use App\Models\Chapter;
use Yajra\DataTables\Facades\DataTables;

class ChapterRepository implements ChapterRepositoryInterface
{
    public function getAllChapters()
    {
        return Chapter::get();
    }

    public function getChapterById($chapterId)
    {
        return Chapter::findOrFail($chapterId);
    }

    public function deleteChapter($chapterId)
    {
        $chapter = $this->getChapterById($chapterId);
        if (!empty($chapter)) {
            $chapter->delete();

            return redirect()->back()->with('success_msg', 'Chapter successfully deleted.');
        }

        abort(404);
    }

    public function createChapter($chapterDetails)
    {
        $chapter = Chapter::create([
            'user_id' => $chapterDetails->user_id,
            'color_id' => $chapterDetails->color_id,
            'series_id' => $chapterDetails->series_id,
            'book_id' => $chapterDetails->book_id,
            'outline_id' => $chapterDetails->outline_id,
            'chapter_name' => $chapterDetails->chapter_name,
            'status' => $chapterDetails->status,
        ]);

        return redirect()->route('manage.chapters')->with('success_msg', 'Chapter successfully added.');
    }

    public function updateChapter($chapterId, $chapterDetails)
    {
        $chapter = Chapter::findOrFail($chapterId);

        if(!empty($chapter)){
            $chapter->update([
                'user_id' => $chapterDetails['user_id'],
                'color_id' => $chapterDetails['color_id'],
                'series_id' => $chapterDetails['series_id'],
                'book_id' => $chapterDetails['book_id'],
                'outline_id' => $chapterDetails['outline_id'],
                'chapter_name' => $chapterDetails['chapter_name'],
                'status' => $chapterDetails['status'],
            ]);

            return redirect()->route('manage.chapters')->with('success_msg', 'Chapter successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Chapter not found.');
    }

    public function getDataTable(){

        $query = Chapter::query();

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
            ->addColumn('book_name', function ($obj) {
                return $obj->book ? $obj->book->book_name : '';
            })
            ->addColumn('outline_name', function ($obj) {
                return $obj->outline ? $obj->outline->outline_name : '';
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('chapter.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('chapter.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('chapter.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('chapter.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('chapter.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('chapter.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('chapter.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('chapter.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'outline_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($chapterId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $chapter = $this->getChapterById($chapterId);

        if (!empty($chapter)) {
            $chapter->update([
                'status' => !$chapter->status
            ]);
            $msg = "Chapter status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
