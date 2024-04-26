<?php

namespace App\Http\Controllers;

use App\Imports\CouponImport;
use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;
use App\Models\CouponImportLog;
use App\Models\package;
use App\Models\PackageOption;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends Controller
{
    private CouponRepositoryInterface $repository;

    public function __construct(CouponRepositoryInterface $couponsRepository)
    {
        $this->CouponRepository = $couponsRepository;
    }
    public function index()
    {
        if (request()->ajax()) {
            return $this->CouponRepository->getDataTable();
        }
        return view('Coupons.index');
    }
    public function addCoupon()
    {
        $packages = package::all();

        return view('Coupons.add',compact('packages'));
    }
    public function addCouponData(Request $request)
    {
        return $this->CouponRepository->createId($request);
    }
    public function updateCoupon($id)
    {
        $packages = Package::all();
        $coupon = Coupon::find($id);
        return view('Coupons.update',compact('coupon','packages'));
    }
    public function updateCouponData($id)
    {
        return $this->CouponRepository->updateRole($id);
    }
    public function couponDelete($id)
    {
        $this->CouponRepository->delete($id);

        return redirect()->route('coupon')->with('success', 'Permission deleted successfully.');

    }
    public function changeCouponStatus($id)
    {
        return $this->CouponRepository->changeStatus($id);
    }
    public function getCouponDetail($id)
    {
        $coupon = $this->CouponRepository->getId($id);
            return view('Coupons.show',['coupon'=>$coupon]);
    }



}
