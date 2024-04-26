<?php

namespace App\Repositories;

use App\Interfaces\TimelineRepositoryInterface;
use App\Models\Timeline;
use Yajra\DataTables\Facades\DataTables;

class TimelineRepository implements TimelineRepositoryInterface
{
    public function getAllTimelines()
    {
        return Timeline::get();
    }

    public function getTimelineById($timelineId)
    {
        return Timeline::findOrFail($timelineId);
    }

    public function deleteTimeline($timelineId)
    {
        $timeline = $this->getTimelineById($timelineId);
        if (!empty($timeline)) {
            $timeline->delete();

            return redirect()->back()->with('success_msg', 'Timeline successfully deleted.');
        }

        abort(404);
    }

    public function createTimeline($timelineDetails)
    {
        $timeline = Timeline::create([
            'user_id' => $timelineDetails->user_id,
            'color_id' => $timelineDetails->color_id,
            'series_id' => $timelineDetails->series_id,
            'book_id' => $timelineDetails->book_id,
            'name' => $timelineDetails->name,
            'description' => $timelineDetails->description,
            'status' => $timelineDetails->status,
        ]);

        return redirect()->route('manage.timelines')->with('success_msg', 'Timeline successfully added.');
    }

    public function updateTimeline($timelineId, $timelineDetails)
    {
        $timeline = Timeline::findOrFail($timelineId);

        if(!empty($timeline)){
            $timeline->update([
                'user_id' => $timelineDetails['user_id'],
                'color_id' => $timelineDetails['color_id'],
                'series_id' => $timelineDetails['series_id'],
                'book_id' => $timelineDetails['book_id'],
                'name' => $timelineDetails['name'],
                'description' => $timelineDetails['description'],
                'status' => $timelineDetails['status'],
            ]);

            return redirect()->route('manage.timelines')->with('success_msg', 'Timeline successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Timeline not found.');
    }

    public function getDataTable(){

        $query = Timeline::query();

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
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('timeline.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('timeline.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('timeline.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('timeline.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('timeline.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('timeline.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('timeline.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('timeline.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($timelineId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $timeline = $this->getTimelineById($timelineId);

        if (!empty($timeline)) {
            $timeline->update([
                'status' => !$timeline->status
            ]);
            $msg = "Timeline status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
