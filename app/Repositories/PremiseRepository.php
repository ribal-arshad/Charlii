<?php

namespace App\Repositories;

use App\Interfaces\PremiseRepositoryInterface;
use App\Models\Premise;
use Yajra\DataTables\Facades\DataTables;

class PremiseRepository implements PremiseRepositoryInterface
{
    public function getAllPremises()
    {
        return Premise::get();
    }

    public function getPremiseById($premiseId)
    {
        return Premise::findOrFail($premiseId);
    }

    public function deletePremise($premiseId)
    {
        $premise = $this->getPremiseById($premiseId);
        if (!empty($premise)) {
            $premise->delete();

            return redirect()->back()->with('success_msg', 'Premises successfully deleted.');
        }

        abort(404);
    }

    public function createPremise($premiseDetails)
    {
        $premise = Premise::create([
            'user_id' => $premiseDetails->user_id,
            'color_id' => $premiseDetails->color_id,
            'series_id' => $premiseDetails->series_id,
            'book_id' => $premiseDetails->book_id,
            'premise_name' => $premiseDetails->premise_name,
            'description' => $premiseDetails->description,
            'status' => $premiseDetails->status,
        ]);

        return redirect()->route('manage.premises')->with('success_msg', 'Premises successfully added.');
    }

    public function updatePremise($premiseId, $premiseDetails)
    {
        $premise = Premise::findOrFail($premiseId);

        if(!empty($premise)){
            $premise->update([
                'user_id' => $premiseDetails['user_id'],
                'color_id' => $premiseDetails['color_id'],
                'series_id' => $premiseDetails['series_id'],
                'book_id' => $premiseDetails['book_id'],
                'premise_name' => $premiseDetails['premise_name'],
                'description' => $premiseDetails['description'],
                'status' => $premiseDetails['status'],
            ]);

            return redirect()->route('manage.premises')->with('success_msg', 'Premises successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Premises not found.');
    }

    public function getDataTable(){

        $query = Premise::query();

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

                if (auth()->user()->can('premise.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('premise.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('premise.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('premise.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('premise.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('premise.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('premise.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('premise.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($premiseId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $premise = $this->getPremiseById($premiseId);

        if (!empty($premise)) {
            $premise->update([
                'status' => !$premise->status
            ]);
            $msg = "Premises status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
