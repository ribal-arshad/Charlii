<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterStoreRequest;
use App\Http\Requests\ChapterUpdateRequest;
use App\Interfaces\ChapterRepositoryInterface;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Color;
use App\Models\Outline;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private ChapterRepositoryInterface $chapterRepository;

    public function __construct(ChapterRepositoryInterface $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->chapterRepository->getDataTable();
        }

        return view('chapter.index');
    }

    public function addChapter()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('chapter.add', compact( 'colors', 'users'));
    }

    public function addChapterData(ChapterStoreRequest $request)
    {
        return $this->chapterRepository->createChapter($request);
    }

    public function updateChapter($chapterId)
    {
        $chapter = Chapter::findorfail($chapterId);

        if (!empty($chapter)) {
            $series = Series::where('user_id', $chapter->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $chapter->series_id)->where('status', 1)->get();
            $outlines = Outline::where('book_id', $chapter->book_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $chapter->series ? $chapter->series->id : '';
            $selectedBook = $chapter->book ? $chapter->book->id : '';
            $selectedOutline = $chapter->outline ? $chapter->outline->id : '';

            return view('chapter.update', compact('chapter', 'series', 'books', 'outlines', 'selectedSeries', 'colors', 'users', 'selectedBook', 'selectedOutline'));
        }

        abort(404);
    }

    public function updateChapterData($chapterId, ChapterUpdateRequest $request)
    {
        return $this->chapterRepository->updateChapter($chapterId, $request);
    }

    public function getChapterDetail($chapterId)
    {
        $chapter = $this->chapterRepository->getChapterById($chapterId);

        return view('chapter.detail', compact('chapter'));
    }

    public function changeChapterStatus($chapterId)
    {
        return $this->chapterRepository->changeStatus($chapterId);
    }

    public function deleteChapter($chapterId)
    {
        return $this->chapterRepository->deleteChapter($chapterId);
    }

    public function getChapterByOutline(Request $request)
    {
        $outlineId = $request->input('outline_id');
        $chapter = Chapter::where('outline_id', $outlineId)->where('status', 1)->get();

        return response()->json(['options' => $chapter]);
    }
}
