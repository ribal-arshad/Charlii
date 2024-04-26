<?php

namespace App\Repositories;

use App\Interfaces\PlotPlannerRepositoryInterface;
use App\Models\PlotPlanner;
use Yajra\DataTables\Facades\DataTables;

class PlotPlannerRepository implements PlotPlannerRepositoryInterface
{
    public function getAllPlotPlanners()
    {
        return PlotPlanner::get();
    }

    public function getPlotPlannerById($plotPlannerId)
    {
        return PlotPlanner::findOrFail($plotPlannerId);
    }

    public function deletePlotPlanner($plotPlannerId)
    {
        $plotPlanner = $this->getPlotPlannerById($plotPlannerId);
        if (!empty($plotPlanner)) {
            $plotPlanner->delete();

            return redirect()->back()->with('success_msg', 'Plot Planner successfully deleted.');
        }

        abort(404);
    }

    public function createPlotPlanner($plotPlannerDetails)
    {
        $plotPlanner = PlotPlanner::create([
            'user_id' => $plotPlannerDetails->user_id,
            'color_id' => $plotPlannerDetails->color_id,
            'series_id' => $plotPlannerDetails->series_id,
            'book_id' => $plotPlannerDetails->book_id,
            'plot_planner_title' => $plotPlannerDetails->plot_planner_title,
            'description' => $plotPlannerDetails->description,
            'status' => $plotPlannerDetails->status,
        ]);

        return redirect()->route('manage.planners')->with('success_msg', 'Plot Planner successfully added.');
    }

    public function updatePlotPlanner($plotPlannerId, $plotPlannerDetails)
    {
        $plotPlanner = PlotPlanner::findOrFail($plotPlannerId);

        if(!empty($plotPlanner)){
            $plotPlanner->update([
                'user_id' => $plotPlannerDetails['user_id'],
                'color_id' => $plotPlannerDetails['color_id'],
                'series_id' => $plotPlannerDetails['series_id'],
                'book_id' => $plotPlannerDetails['book_id'],
                'plot_planner_title' => $plotPlannerDetails['plot_planner_title'],
                'description' => $plotPlannerDetails['description'],
                'status' => $plotPlannerDetails['status'],
            ]);

            return redirect()->route('manage.planners')->with('success_msg', 'Plot Planner successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Plot Planner not found.');
    }

    public function getDataTable(){

        $query = PlotPlanner::query();

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

                if (auth()->user()->can('planner.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('planner.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('planner.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('planner.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('planner.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('planner.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('planner.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('planner.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($plotPlannerId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $plotPlanner = $this->getPlotPlannerById($plotPlannerId);

        if (!empty($plotPlanner)) {
            $plotPlanner->update([
                'status' => !$plotPlanner->status
            ]);
            $msg = "PlotPlanner status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
