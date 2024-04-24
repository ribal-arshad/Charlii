<?php

namespace App\Repositories;

use App\Interfaces\CalendarRepositoryInterface;
use App\Models\Calendar;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CalendarRepository implements CalendarRepositoryInterface
{
    public function getAllCalendars()
    {
        return Calendar::get();
    }

    public function getCalendarById($calendarId)
    {
        return Calendar::findOrFail($calendarId);
    }

    public function deleteCalendar($calendarId)
    {
        $calendar = $this->getCalendarById($calendarId);
        if (!empty($calendar)) {
            $calendar->delete();

            return redirect()->back()->with('success_msg', 'Calendar successfully deleted.');
        }

        abort(404);
    }

    public function createCalendar($calendarDetails)
    {
        $color = Calendar::create([
            'title' => $calendarDetails->title,
            'description' => $calendarDetails->description,
            'event_date' => $calendarDetails->event_date,
            'start_time' => $calendarDetails->start_time,
            'end_time' => $calendarDetails->end_time,
            'user_id' => $calendarDetails->user_id,
            'color_id' => $calendarDetails->color_id,
        ]);

        return redirect()->route('manage.calendars')->with('success_msg', 'Calendar successfully added.');
    }

    public function updateCalendar($calendarId, $calendarDetails)
    {
        $calendar = Calendar::findOrFail($calendarId);

        if(!empty($calendar)){
            $calendar->update([
                'title' => $calendarDetails['title'],
                'description' => $calendarDetails['description'],
                'event_date' => $calendarDetails['event_date'],
                'start_time' => $calendarDetails['start_time'],
                'end_time' => $calendarDetails['end_time'],
                'user_id' => $calendarDetails['user_id'],
                'color_id' => $calendarDetails['color_id'],
            ]);

            return redirect()->route('manage.calendars')->with('success_msg', 'Calendar successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Calendar not found.');
    }

    public function getDataTable(){
        $query = Calendar::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function ($query) use ($search) {
                        $query->whereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })->orWhereTime('start_time', '=', $search)
                            ->orWhereTime('end_time', '=', $search)
                            ->orWhereHas('color', function ($query) use ($search) {
                                $query->where('color', 'like', "%{$search}%");
                            });
                    });
                }
            })
            ->editColumn('user_name', function ($obj) {
                return $obj->user ? $obj->user->name : "";
            })
            ->editColumn('start_time', function ($obj) {
                return (new Carbon($obj->start_time))->format('h:i A');
            })
            ->editColumn('end_time', function ($obj) {
                return (new Carbon($obj->end_time))->format('h:i A');
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('calendar.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('calendar.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('calendar.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('calendar.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('calendar.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('calendar.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['user_name', 'start_time', 'end_time', 'color', 'action'])
            ->make(true);
    }
}
