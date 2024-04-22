<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CorrectiveWos;
use App\Models\Equipment;
use App\Models\PmProgress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if (Auth::user()->hasRole('Admin')){
            $users = User::where('id', '!=', Auth::id())->count();
            $completedPm = PmProgress::where('status', PmProgress::COMPLETE)->count();
            $pastDuePm = PmProgress::where('status', 'Exception')->count();
            $correctiveOpen = CorrectiveWos::where('status', CorrectiveWos::OPEN)->count();
        }else{
            $users = 0;
            $companyId = Company::where('user_id', Auth::id())->first()?->id;
            $equipmentIds = Equipment::where('company_id', $companyId)->pluck('id')->toArray();
            $completedPm = PmProgress::where('status', PmProgress::COMPLETE)->whereIn('equipment_id', $equipmentIds)->count();
            $pastDuePm = PmProgress::where('status', 'Complete','Exception')->count();
            $correctiveOpen = CorrectiveWos::where('company_id', $companyId)->where('status', CorrectiveWos::OPEN)->count();
        }

        return view('dashboard', compact('users', 'completedPm', 'pastDuePm', 'correctiveOpen'));
    }
}
