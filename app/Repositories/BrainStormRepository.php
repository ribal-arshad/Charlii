<?php

namespace App\Repositories;

use App\Interfaces\BrainStormRepositoryInterface;
use App\Models\Brainstorm;
use App\Models\Premise;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BrainStormRepository implements BrainStormRepositoryInterface
{
    public function getAllPremises()
    {
        return Premise::get();
    }

    public function getBrainById($brainId)
    {
        return Brainstorm::findOrFail($brainId);
    }

    public function deleteBrain($brainId)
    {
        $premise = $this->getBrainById($brainId);
        if (!empty($premise)) {
            $premise->delete();

            return redirect()->back()->with('success_msg', 'Premises successfully deleted.');
        }

        abort(404);
    }

    public function createBrainStorm($request)
    {
        $request->validate([
            'user_id' => 'required',
            'color_id' => 'required',
            'series_id' => 'required',
            'book_id' => 'required',
            'brainstorm_name' => 'required',
            'transcript' => 'required',

        ]);


        if ($request->hasFile('audio_file')) {
            $fileName = time() . '.' . $request->audio_file->getClientOriginalExtension();
            $request->audio_file->storeAs('uploads', $fileName);
        }


        $brainstorm = Brainstorm::create([
            'user_id' => $request->user_id,
            'color_id' => $request->color_id,
            'series_id' => $request->series_id,
            'book_id' => $request->book_id,
            'brainstorm_name' => $request->brainstorm_name,
            'description' => $request->description,
            'status' => $request->status,
            'transcript' => $request->transcript,
//            'audio_file_path' => isset($fileName) ? $fileName : null,
        ]);
        return redirect()->route('brain-storm')->with('success_msg', 'Premises successfully added.');

    }

    public function updateBrain($brainId, $request)
    {
        $premise = Brainstorm::findOrFail($brainId);

        if(!empty($premise)){
            $premise->update([
                'user_id' => $request['user_id'],
                'color_id' => $request['color_id'],
                'series_id' => $request['series_id'],
                'book_id' => $request['book_id'],
                'brainstorm_name' => $request['brainstorm_name'],
                'description' => $request['description'],
                'status' => $request['status'],
            ]);

            return redirect()->route('brain-storm')->with('success_msg', 'Premises successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Premises not found.');
    }

    public function getDataTable(){

        $query = Brainstorm::query();

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

                if (auth()->user()->can('brain-storm.status')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('brain-storm.change.status', $obj->id) . '`)" />
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
                if(auth()->user()->can('brain-storm.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('brain-storm.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('brain-storm.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('brain-storm.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('brain-storm.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" onclick="deleteData(`' . route('brain-storm.delete', $obj->id) . '`)">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['user_name', 'series_name', 'book_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($brainId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $premise = $this->getBrainById($brainId);

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
