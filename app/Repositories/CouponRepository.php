<?php

namespace App\Repositories;

use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Codec\CodecInterface;
use Yajra\DataTables\Facades\DataTables;


class CouponRepository implements CouponRepositoryInterface
{
    public function getDataTable()
    {
        $query = Coupon::query();

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
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('coupon.status', $obj->id) . '`)" />
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
                $buttons = '<a class="btn btn-xs btn-primary redirect-btn" href="' . route('coupon.detail', $obj->id) . '">Show</a>
                            <a class="btn btn-xs btn-primary redirect-btn" href="' . route('coupon.update', $obj->id) . '">Update</a>';

                return $buttons . '  <button class="btn btn-xs btn-danger redirect-btn" onclick="deleteData(`' . route('coupon.delete', $obj->id) . '`)">Delete</button>';
            })->rawColumns(['status', 'action'])->make(true);
    }
    public function createId($request)
    {
       $validator =  Validator::make($request->all(), [
             'coupon_code' => 'required',
             'package_type' => 'required',
             'discount_amount' => 'required',
             'number_of_usage' => 'required',
             'date_of_expiry' => 'required',
             'status' => 'required',
        ]);
        if ($request->has('package_id')) {
            if (!$validator->fails()) {
                Coupon::create([
                    'coupon_code' => $request->input('coupon_code'),
                    'package_type' => $request->input('package_type'),
                    'discount_amount' => $request->input('discount_amount'),
                    'number_of_usage' => $request->input('number_of_usage'),
                    'date_of_expiry' => $request->input('date_of_expiry'),
                    'status' => $request->input('status'),
                    'package_id' => $request->input('package_id'),
                ]);
            }
        } else {
            if (!$validator->fails()) {
                Coupon::create([
                    'coupon_code' => $request->input('coupon_code'),
                    'package_type' => $request->input('package_type'),
                    'discount_amount' => $request->input('discount_amount'),
                    'number_of_usage' => $request->input('number_of_usage'),
                    'date_of_expiry' => $request->input('date_of_expiry'),
                    'status' => $request->input('status'),
                    'package_id' => null,
                ]);
            }
        }
        return redirect()->route('coupon')->with('success.created successfully');

    }
    public function updateRole($id)
    {
        $id =Coupon::where('id',$id)->first();

        if(!empty($id)){

            $id['coupon_code'] = \request()->coupon_code;
        }

        $id->fill(\request()->post())->save();
        \request()->validate([
            'coupon_code' => 'required'
        ]);

        return redirect()->route('coupon')->with('success','updated successfully.');


    }
    public function delete($id)
    {
        $permission = Coupon::findOrFail($id);

        $permission->delete();

    }
    public function getId($id)
    {
        return Coupon::findOrFail($id);
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
