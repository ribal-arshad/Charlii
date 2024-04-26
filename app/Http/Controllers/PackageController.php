<?php

namespace App\Http\Controllers;

use App\Interfaces\PackageRepositoryInterface;
use App\Models\Color;
use App\Models\Package;
use App\Models\PackageOption;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private PackageRepositoryInterface $repository;

    public function __construct(PackageRepositoryInterface $packageOptionRepository)
    {
        $this->PackageRepository = $packageOptionRepository;
    }
    public function index()
    {
        if (request()->ajax()) {
            return $this->PackageRepository->getDataTable();
        }
        return view('package.index');
    }
    public function addPackage()
    {
        $color = Color::all();
        $packages_options = PackageOption::all();
        $packages =Package::all();
        return view('package.add',compact('color','packages_options','packages'));
    }
    public function addPackageData(Request $request)
    {
        return $this->PackageRepository->createId($request);
    }
    public function getPackageDetail($id)
    {
        $packages = $this->PackageRepository->getid($id);
        $color =Color::all();

        return view('package.show',compact('color'),['packages'=>$packages]);

    }
    public function updatePackage($id)
    {
        $packages = Package::find($id);
        $color = Color::all();
        return view('package.update',compact('packages','color'));
    }
    public function updatePackageData($id)
    {
        return $this->PackageRepository->updateRole($id);
    }
    public function PackageDelete($id)
    {
        $this->PackageRepository->delete($id);

        return redirect()->route('package')->with('success', 'Permission deleted successfully.');

    }
    public function changePackageStatus($id)
    {
        return $this->PackageRepository->changeStatus($id);
    }
}
