<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlotPlannerStoreRequest;
use App\Http\Requests\PlotPlannerUpdateRequest;
use App\Interfaces\PlotPlannerRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\PlotPlanner;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class PlotPlannerController extends Controller
{
    private PlotPlannerRepositoryInterface $plotPlannerRepository;

    public function __construct(PlotPlannerRepositoryInterface $plotPlannerRepository)
    {
        $this->plotPlannerRepository = $plotPlannerRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->plotPlannerRepository->getDataTable();
        }

        return view('planner.index');
    }

    public function addPlotPlanner()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('planner.add', compact( 'colors', 'users'));
    }

    public function addPlotPlannerData(PlotPlannerStoreRequest $request)
    {
        return $this->plotPlannerRepository->createPlotPlanner($request);
    }

    public function updatePlotPlanner($plannerId)
    {
        $planner = PlotPlanner::findorfail($plannerId);

        if (!empty($planner)) {
            $series = Series::where('user_id', $planner->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $planner->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $planner->series ? $planner->series->id : '';
            $selectedBook = $planner->book ? $planner->book->id : '';

            return view('planner.update', compact('planner', 'series', 'books', 'selectedSeries', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updatePlotPlannerData($plannerId, PlotPlannerUpdateRequest $request)
    {
        return $this->plotPlannerRepository->updatePlotPlanner($plannerId, $request);
    }

    public function getPlotPlannerDetail($plannerId)
    {
        $planner = $this->plotPlannerRepository->getPlotPlannerById($plannerId);

        return view('planner.detail', compact('planner'));
    }

    public function changePlotPlannerStatus($plannerId)
    {
        return $this->plotPlannerRepository->changeStatus($plannerId);
    }

    public function deletePlotPlanner($plannerId)
    {
        return $this->plotPlannerRepository->deletePlotPlanner($plannerId);
    }
}
