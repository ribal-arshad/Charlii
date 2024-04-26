<?php

namespace App\Http\Controllers;

use App\Interfaces\PackageOptionRepositoryInterface;
use App\Models\PackageOption;
use App\Repositories\PackageOptionRepository;
use Illuminate\Http\Request;

class PackageOptionController extends Controller
{
    private PackageOptionRepositoryInterface $repository;

    public function __construct(PackageOptionRepositoryInterface $packageOptionRepositryRepository)
    {
        $this->PackageOptionRepository = $packageOptionRepositryRepository;
    }
    public function index()
    {
        if (request()->ajax()) {
            return $this->PackageOptionRepository->getDataTable();
        }
        return view('Package-Option.index');
    }
    public function addPackage()
    {

        return view('Package-Option.add');
    }
    public function addPackageData(Request $request)
    {
        return $this->PackageOptionRepository->createId($request);
    }
    public function getPackageDetail($id)
    {
        $permission = PackageOption::find($id);

        return view('Package-Option.show',compact('permission'));

    }
    public function updatePackage($id)
    {
        $permission = PackageOption::find($id);
        return view('Package-Option.update',compact('permission'));
    }
    public function updatePackageData($id)
    {
        return $this->PackageOptionRepository->updateRole($id);
    }
    public function changeCouponDelete($id)
    {
        $this->PackageOptionRepository->delete($id);

        return redirect()->route('coupon')->with('success', 'Permission deleted successfully.');

    }

}
