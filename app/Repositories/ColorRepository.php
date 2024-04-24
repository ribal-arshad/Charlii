<?php

namespace App\Repositories;

use App\Interfaces\ColorRepositoryInterface;
use App\Models\Color;
use Yajra\DataTables\Facades\DataTables;

class ColorRepository implements ColorRepositoryInterface
{
    public function getAllColors()
    {
        return Color::get();
    }

    public function getColorById($colorId)
    {
        return Color::findOrFail($colorId);
    }

    public function deleteColor($colorId)
    {
        $color = $this->getColorById($colorId);
        if (!empty($color)) {
            $color->delete();

            return redirect()->back()->with('success_msg', 'Color successfully deleted.');
        }

        abort(404);
    }

    public function createColor($colorDetails)
    {
        $color = Color::create([
            'color' => $colorDetails->color,
            'color_code' => $colorDetails->color_code,
            'foreground_color' => $colorDetails->foreground_color,
            'status' => $colorDetails->status,
        ]);

        return redirect()->route('manage.colors')->with('success_msg', 'Color successfully added.');
    }

    public function updateColor($colorId, $colorDetails)
    {
        $color = Color::findOrFail($colorId);

        if(!empty($color)){
            $color->update([
                'color' => $colorDetails['color'],
                'color_code' => $colorDetails['color_code'],
                'foreground_color' => $colorDetails['foreground_color'],
                'status' => $colorDetails['status'],
            ]);

            return redirect()->route('manage.colors')->with('success_msg', 'Color successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Color not found.');
    }

    public function getDataTable(){

        $query = Color::get();

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
            ->editColumn('color_code', function ($obj) {
                return '<span class="color-block"><span style="background-color: ' . $obj->color_code . '"></span>' . $obj->color_code . '</span>';
            })
            ->editColumn('foreground_color', function ($obj) {
                return '<span class="color-block"><span style="background-color: ' . $obj->foreground_color . '"></span>' . $obj->foreground_color . '</span>';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('color.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('color.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('color.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('color.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('color.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('color.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('color.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('color.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['color_code', 'foreground_color', 'status', 'action'])->make(true);
    }

    public function changeStatus($colorId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $color = $this->getColorById($colorId);

        if (!empty($color)) {
            $color->update([
                'status' => !$color->status
            ]);
            $msg = "Color status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
