<?php

namespace App\Repositories;

use App\Interfaces\TimelineEventTypesRepositoryInterface;
use App\Models\TimelineEventType;
use Yajra\DataTables\Facades\DataTables;

class TimelineEventTypesRepository implements TimelineEventTypesRepositoryInterface
{
    public function getAllEventTypes()
    {
        return TimelineEventType::get();
    }

    public function getEventTypeById($eventTypeId)
    {
        return TimelineEventType::findOrFail($eventTypeId);
    }

    public function deleteEventType($eventTypeId)
    {
        $eventType = $this->getEventTypeById($eventTypeId);
        if (!empty($eventType)) {
            $eventType->delete();

            return redirect()->back()->with('success_msg', 'Timeline Event Type successfully deleted.');
        }

        abort(404);
    }

    public function createEventType($eventTypeDetails)
    {
        $eventType = TimelineEventType::create([
            'user_id' => $eventTypeDetails->user_id,
            'color_id' => $eventTypeDetails->color_id,
            'series_id' => $eventTypeDetails->series_id,
            'book_id' => $eventTypeDetails->book_id,
            'timeline_id' => $eventTypeDetails->timeline_id,
            'event_type' => $eventTypeDetails->event_type,
            'status' => $eventTypeDetails->status,
        ]);

        return redirect()->route('manage.timeline.event.types')->with('success_msg', 'Timeline Event Type successfully added.');
    }

    public function updateEventType($eventTypeId, $eventTypeDetails)
    {
        $eventType = TimelineEventType::findOrFail($eventTypeId);

        if(!empty($eventType)) {
            $eventType->update([
                'user_id' => $eventTypeDetails['user_id'],
                'color_id' => $eventTypeDetails['color_id'],
                'series_id' => $eventTypeDetails['series_id'],
                'book_id' => $eventTypeDetails['book_id'],
                'timeline_id' => $eventTypeDetails['timeline_id'],
                'event_type' => $eventTypeDetails['event_type'],
                'status' => $eventTypeDetails['status'],
            ]);

            return redirect()->route('manage.timeline.event.types')->with('success_msg', 'Timeline Event Type successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Timeline Event Type not found.');
    }

    public function getDataTable(){

        $query = TimelineEventType::query();

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
            ->addColumn('timeline_name', function ($obj) {
                return $obj->timeline ? $obj->timeline->name : '';
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('timeline.event.type.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('timeline.event.type.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('timeline.event.type.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('timeline.event.type.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('timeline.event.type.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('timeline.event.type.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('timeline.event.type.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('timeline.event.type.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'timeline_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($eventTypeId)
    {
        $msg = 'Something went wrong.';
        $code = 400;

        $eventType = $this->getEventTypeById($eventTypeId);
        if (!empty($eventType)) {
            $eventType->update([
                'status' => !$eventType->status
            ]);
            $msg = "Timeline event type status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
