<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Premise;
use App\Models\Series;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $totalUsers = User::where('id', '!=', 1)->count();
        $totalSeries = Series::all()->count();
        $totalBooks = Book::all()->count();
        $totalPremises = Premise::all()->count();

        return view('dashboard', compact('totalUsers', 'totalSeries', 'totalBooks', 'totalPremises'));
    }
}
