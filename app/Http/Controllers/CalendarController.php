<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarStoreRequest;
use App\Http\Requests\CalendarUpdateRequest;
use App\Interfaces\CalendarRepositoryInterface;
use App\Models\Calendar;
use App\Models\Color;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    private CalendarRepositoryInterface $calendarRepository;

    public function __construct(CalendarRepositoryInterface $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->calendarRepository->getDataTable();
        }

        return view('calendar.index');
    }

    public function addCalendar()
    {
        $users = User::where('status', 1)->where('id', '!=', 1)->get();
        $colors = Color::where('status', 1)->get();

        return view('calendar.add', compact('users', 'colors'));
    }

    public function addCalendarData(CalendarStoreRequest $request)
    {
        return $this->calendarRepository->createCalendar($request);
    }

    public function updateCalendar($calendarId)
    {
        $calendar = Calendar::findOrFail($calendarId);
        $users = User::where('status', 1)->where('id', '!=', 1)->get();
        $colors = Color::where('status', 1)->get();

        if (!empty($calendar)) {
            return view('calendar.update', compact('calendar', 'users', 'colors'));
        }

        abort(404);
    }

    public function updateCalendarData($calendarId, CalendarUpdateRequest $request)
    {
        return $this->calendarRepository->updateCalendar($calendarId, $request);
    }

    public function calendarDetail($calendarId)
    {
        $calendar = $this->calendarRepository->getCalendarById($calendarId);

        return view('calendar.detail', compact('calendar'));
    }

    public function deleteCalendar($calendarId)
    {
        return $this->calendarRepository->deleteCalendar($calendarId);
    }
}
