<?php

namespace App\Repositories;

use App\Interfaces\PackageRepositoryInterface;
use App\Models\Package;
use App\Models\PackageOption;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PackageRepository implements PackageRepositoryInterface
{
    public function getDataTable()
    {
        $query = Package::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('option_name', 'LIKE', "%$search%")
                            ->orWhere('id', 'LIKE', "%$search%");

                        if (strtolower($search) === "unverified") {
                            $w->orWhere('is_verified', 0);
                        } elseif (strtolower($search) === "verified") {
                            $w->orWhere('is_active', 1);
                        }

                    });
                }
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('role.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('package.status', $obj->id) . '`)" />
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
                $buttons = '<a class="btn btn-xs btn-primary redirect-btn" href="' . route('package.detail', $obj->id) . '">Show</a>
                            <a class="btn btn-xs btn-primary redirect-btn" href="' . route('package.update', $obj->id) . '">Update</a>';

                return $buttons . '  <button class="btn btn-xs btn-danger redirect-btn" onclick="deleteData(`' . route('package.delete', $obj->id) . '`)">Delete</button>';
            })->rawColumns(['status', 'action'])->make(true);
    }

    public function createId($request)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required',
            'description' => 'required',
            'price_monthly' => 'required|numeric|max:9999999999.99',
            'yearly_discount' => 'required|numeric|max:9999.99',
            'price_yearly' => 'required|numeric|max:9999999999.99',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Package::create([
            'package_name' => $request->input('package_name'),
            'description' => $request->input('description'),
            'price_monthly' => $request->input('price_monthly'),
            'yearly_discount' => $request->input('yearly_discount'),
            'price_yearly' => $request->input('price_yearly'),
            'color_id' => $request->input('color_id'),

        ]);

        return redirect()->route('package')->with('success.created successfully');

    }
    public function getid($id)
    {
       return Package::findOrFail($id);
    }

    public function updateRole($id)
    {
        $id = Package::where('id', $id)->first();

        if (!empty($id)) {

            $id['package_name'] = \request()->package_name;
        }

        $id->fill(\request()->post())->save();
        \request()->validate([
            'package_name' => 'required'
        ]);

        return redirect()->route('package')->with('success', 'updated successfully.');


    }

    public function delete($id)
    {
        $permission = Package::findOrFail($id);

        $permission->delete();

    }
    public function changeStatus($id)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $id = $this->getId($id);

        if (!empty($id)) {
            $id->update([
                'status' => !$id->status
            ]);
            $msg = "Coupon status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }

}
