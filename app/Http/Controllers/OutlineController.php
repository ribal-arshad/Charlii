<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutlineStoreRequest;
use App\Http\Requests\OutlineUpdateRequest;
use App\Interfaces\OutlineRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Outline;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class OutlineController extends Controller
{
    private OutlineRepositoryInterface $outlineRepository;

    public function __construct(OutlineRepositoryInterface $outlineRepository)
    {
        $this->outlineRepository = $outlineRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->outlineRepository->getDataTable();
        }

        return view('outline.index');
    }

    public function addOutline()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('outline.add', compact( 'colors', 'users'));
    }

    public function addOutlineData(OutlineStoreRequest $request)
    {
        return $this->outlineRepository->createOutline($request);
    }

    public function updateOutline($outlineId)
    {
        $outline = Outline::findorfail($outlineId);

        if (!empty($outline)) {
            $series = Series::where('user_id', $outline->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $outline->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $outline->series ? $outline->series->id : '';
            $selectedBook = $outline->book ? $outline->book->id : '';

            return view('outline.update', compact('outline', 'series', 'books', 'selectedSeries', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updateOutlineData($outlineId, OutlineUpdateRequest $request)
    {
        return $this->outlineRepository->updateOutline($outlineId, $request);
    }

    public function getOutlineDetail($outlineId)
    {
        $outline = $this->outlineRepository->getOutlineById($outlineId);

        return view('outline.detail', compact('outline'));
    }

    public function changeOutlineStatus($outlineId)
    {
        return $this->outlineRepository->changeStatus($outlineId);
    }

    public function deleteOutline($outlineId)
    {
        return $this->outlineRepository->deleteOutline($outlineId);
    }

    public function getOutlineByBook(Request $request)
    {
        $bookId = $request->input('book_id');
        $outline = Outline::where('book_id', $bookId)->where('status', 1)->get();

        return response()->json(['options' => $outline]);
    }
}
