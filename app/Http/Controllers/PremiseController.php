<?php

namespace App\Http\Controllers;

use App\Http\Requests\PremiseStoreRequest;
use App\Http\Requests\PremiseUpdateRequest;
use App\Interfaces\PremiseRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Premise;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class PremiseController extends Controller
{
    private PremiseRepositoryInterface $premiseRepository;

    public function __construct(PremiseRepositoryInterface $premiseRepository)
    {
        $this->premiseRepository = $premiseRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->premiseRepository->getDataTable();
        }

        return view('premise.index');
    }

    public function addPremise()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('premise.add', compact( 'colors', 'users'));
    }

    public function addPremiseData(PremiseStoreRequest $request)
    {
        return $this->premiseRepository->createPremise($request);
    }

    public function updatePremise($premiseId)
    {
        $premise = Premise::findorfail($premiseId);

        if (!empty($premise)) {
            $series = Series::where('user_id', $premise->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $premise->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedSeries = $premise->series ? $premise->series->id : '';
            $selectedBook = $premise->book ? $premise->book->id : '';

            return view('premise.update', compact('premise', 'series', 'books', 'selectedSeries', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updatePremiseData($premiseId, PremiseUpdateRequest $request)
    {
        return $this->premiseRepository->updatePremise($premiseId, $request);
    }

    public function getPremiseDetail($premiseId)
    {
        $premise = $this->premiseRepository->getPremiseById($premiseId);

        return view('premise.detail', compact('premise'));
    }

    public function changePremiseStatus($premiseId)
    {
        return $this->premiseRepository->changeStatus($premiseId);
    }

    public function deletePremise($premiseId)
    {
        return $this->premiseRepository->deletePremise($premiseId);
    }
}
