<?php

namespace App\Repositories;

use App\Interfaces\PackageOptionRepositoryInterface;
use App\Models\PackageOption;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class PackageOptionRepository implements PackageOptionRepositoryInterface
{
    public function getDataTable()
    {
        $query = PackageOption::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        $w->orWhere('option_name', 'LIKE', "%$search%")
                            ->orWhere('id', 'LIKE', "%$search%");

                        if(strtolower($search) === "unverified"){
                            $w->orWhere('is_verified', 0);
                        }elseif(strtolower($search) === "verified"){
                            $w->orWhere('is_active', 1);
                        }

                    });
                }
            })
            ->editColumn('is_verified', function ($obj){
                return !empty($obj->is_verified)?"Verified":"unverified";
            })
            ->editColumn('is_active', function ($obj) {
                $isChecked = "";
                if(!empty($obj->is_active)){
                    $isChecked = "checked";
                }

                $switchBtn = '<label class="switch switch-success">
                                        <input type="checkbox" class="switch-input" '.$isChecked.' onclick="changeStatus(`'.route('user.change.status', $obj->id).'`)" />
                                        <span class="switch-toggle-slider">
                                          <span class="switch-on">
                                            <i class="bx bx-check"></i>
                                          </span>
                                          <span class="switch-off">
                                            <i class="bx bx-x"></i>
                                          </span>
                                        </span>
                                    </label>';

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<a class="btn btn-xs btn-primary redirect-btn" href="' . route('Package.option.detail', $obj->id) . '">Show</a>
                            <a class="btn btn-xs btn-primary redirect-btn" href="' . route('Package.option.update', $obj->id) . '">Update</a>';

                return $buttons . '  <button class="btn btn-xs btn-danger redirect-btn" onclick="deleteData(`'. route('Package.option.delete', $obj->id).'`)">Delete</button>';
            })->rawColumns(['is_active', 'action'])->make(true);
    }
    public function createId($request)
    {
        $validator = Validator::make($request->all(), [
            'option_name' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        PackageOption::create([
            'option_name'=>$request->input('option_name')
        ]);

        return redirect()->route('Package.option')->with('success.created successfully');

    }
    public function updateRole($id)
    {
        $id =PackageOption::where('id',$id)->first();

        if(!empty($id)){

            $id['option_name'] = \request()->option_name;
        }

        $id->fill(\request()->post())->save();
        \request()->validate([
            'option_name' => 'required'
        ]);

        return redirect()->route('Package.option')->with('success','updated successfully.');


    }
    public function delete($id)
    {
        $permission = PackageOption::findOrFail($id);

        $permission->delete();

    }

}
