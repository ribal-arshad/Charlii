<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTypeStoreRequest;
use App\Http\Requests\EventTypeUpdateRequest;
use App\Interfaces\TimelineEventTypesRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Series;
use App\Models\Timeline;
use App\Models\TimelineEventType;
use App\Models\User;
use Illuminate\Http\Request;

class TimelineEventTypeController extends Controller
{
    private TimelineEventTypesRepositoryInterface $eventTypeRepository;

    public function __construct(TimelineEventTypesRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->eventTypeRepository->getDataTable();
        }

        return view('timeline-event-type.index');
    }

    public function addEventType()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('timeline-event-type.add', compact( 'colors', 'users'));
    }

    public function addEventTypeData(EventTypeStoreRequest $request)
    {
        return $this->eventTypeRepository->createEventType($request);
    }

    public function updateEventType($eventTypeId)
    {
        $eventType = TimelineEventType::findorfail($eventTypeId);

        if (!empty($eventType)) {
            $series = Series::where('user_id', $eventType->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $eventType->series_id)->where('status', 1)->get();
            $timelines = Timeline::where('book_id', $eventType->book_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $eventType->series ? $eventType->series->id : '';
            $selectedBook = $eventType->book ? $eventType->book->id : '';
            $selectedTimeline = $eventType->timeline ? $eventType->timeline->id : '';

            return view('timeline-event-type.update', compact('eventType', 'series', 'books', 'timelines', 'selectedSeries', 'colors', 'users', 'selectedBook', 'selectedTimeline'));
        }

        abort(404);
    }

    public function updateEventTypeData($eventTypeId, EventTypeUpdateRequest $request)
    {
        return $this->eventTypeRepository->updateEventType($eventTypeId, $request);
    }

    public function getEventTypeDetail($eventTypeId)
    {
        $eventType = $this->eventTypeRepository->getEventTypeById($eventTypeId);

        return view('timeline-event-type.detail', compact('eventType'));
    }

    public function changeEventTypeStatus($eventTypeId)
    {
        return $this->eventTypeRepository->changeStatus($eventTypeId);
    }

    public function deleteEventType($eventTypeId)
    {
        return $this->eventTypeRepository->deleteEventType($eventTypeId);
    }
}
