<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimelineStoreRequest;
use App\Http\Requests\TimelineUpdateRequest;
use App\Interfaces\TimelineRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Series;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    private TimelineRepositoryInterface $timelineRepository;

    public function __construct(TimelineRepositoryInterface $timelineRepository)
    {
        $this->timelineRepository = $timelineRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->timelineRepository->getDataTable();
        }

        return view('timeline.index');
    }

    public function addTimeline()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('timeline.add', compact( 'colors', 'users'));
    }

    public function addTimelineData(TimelineStoreRequest $request)
    {
        return $this->timelineRepository->createTimeline($request);
    }

    public function updateTimeline($timelineId)
    {
        $timeline = Timeline::findorfail($timelineId);

        if (!empty($timeline)) {
            $series = Series::where('user_id', $timeline->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $timeline->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $timeline->series ? $timeline->series->id : '';
            $selectedBook = $timeline->book ? $timeline->book->id : '';

            return view('timeline.update', compact('timeline', 'series', 'books', 'selectedSeries', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updateTimelineData($timelineId, TimelineUpdateRequest $request)
    {
        return $this->timelineRepository->updateTimeline($timelineId, $request);
    }

    public function getTimelineDetail($timelineId)
    {
        $timeline = $this->timelineRepository->getTimelineById($timelineId);

        return view('timeline.detail', compact('timeline'));
    }

    public function changeTimelineStatus($timelineId)
    {
        return $this->timelineRepository->changeStatus($timelineId);
    }

    public function deleteTimeline($timelineId)
    {
        return $this->timelineRepository->deleteTimeline($timelineId);
    }

    public function getTimelineByBook(Request $request)
    {
        $bookId = $request->input('book_id');
        $timeline = Timeline::where('book_id', $bookId)->where('status', 1)->get();

        return response()->json(['options' => $timeline]);
    }
}
