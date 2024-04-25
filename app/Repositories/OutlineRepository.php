<?php

namespace App\Repositories;

use App\Interfaces\OutlineRepositoryInterface;
use App\Models\Outline;
use Yajra\DataTables\Facades\DataTables;

class OutlineRepository implements OutlineRepositoryInterface
{
    public function getAllOutlines()
    {
        return Outline::get();
    }

    public function getOutlineById($outlineId)
    {
        return Outline::findOrFail($outlineId);
    }

    public function deleteOutline($outlineId)
    {
        $outline = $this->getOutlineById($outlineId);
        if (!empty($outline)) {
            $outline->delete();

            return redirect()->back()->with('success_msg', 'Outline successfully deleted.');
        }

        abort(404);
    }

    public function createOutline($outlineDetails)
    {
        $outline = Outline::create([
            'user_id' => $outlineDetails->user_id,
            'color_id' => $outlineDetails->color_id,
            'series_id' => $outlineDetails->series_id,
            'book_id' => $outlineDetails->book_id,
            'outline_name' => $outlineDetails->outline_name,
            'outline_title' => $outlineDetails->outline_title,
            'description' => $outlineDetails->description,
            'status' => $outlineDetails->status,
        ]);

        return redirect()->route('manage.outlines')->with('success_msg', 'Outline successfully added.');
    }

    public function updateOutline($outlineId, $outlineDetails)
    {
        $outline = Outline::findOrFail($outlineId);

        if(!empty($outline)){
            $outline->update([
                'user_id' => $outlineDetails['user_id'],
                'color_id' => $outlineDetails['color_id'],
                'series_id' => $outlineDetails['series_id'],
                'book_id' => $outlineDetails['book_id'],
                'outline_name' => $outlineDetails['outline_name'],
                'outline_title' => $outlineDetails['outline_title'],
                'description' => $outlineDetails['description'],
                'status' => $outlineDetails['status'],
            ]);

            return redirect()->route('manage.outlines')->with('success_msg', 'Outline successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Outline not found.');
    }

    public function getDataTable(){

        $query = Outline::query();

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

                if (auth()->user()->can('outline.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('outline.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('outline.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('outline.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('outline.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('outline.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('outline.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('outline.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($outlineId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $outline = $this->getOutlineById($outlineId);

        if (!empty($outline)) {
            $outline->update([
                'status' => !$outline->status
            ]);
            $msg = "Outline status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
