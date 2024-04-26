<?php

namespace App\Http\Controllers;

use App\Http\Requests\PremiseStoreRequest;
use App\Http\Requests\PremiseUpdateRequest;
use App\Interfaces\BrainStormRepositoryInterface;
use App\Interfaces\PremiseRepositoryInterface;
use App\Models\Book;
use App\Models\Brainstorm;
use App\Models\Color;
use App\Models\Premise;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class BrainStormController extends Controller
{
    private BrainStormRepositoryInterface $premiseRepository;

    public function __construct(BrainStormRepositoryInterface $premiseRepository)
    {
        $this->BrainStormRepository = $premiseRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->BrainStormRepository->getDataTable();
        }

        return view('brain-storm.index');
    }

    public function addBrainStorm()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('brain-storm.add', compact( 'colors', 'users'));
    }

    public function addBrainStormData(Request $request)
    {
        return $this->BrainStormRepository->createBrainStorm($request);
    }

    public function updateBrainStorm($brainId)
    {
        $premise = Brainstorm::findorfail($brainId);

        if (!empty($premise)) {
            $series = Series::where('user_id', $premise->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $premise->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedBook = $premise->book ? $premise->book->id : '';

            return view('brain-storm.update', compact('premise', 'series', 'books', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updateBrainStormData($brainId, Request $request)
    {
        return $this->BrainStormRepository->updateBrain($brainId, $request);
    }

    public function getBrainStormDetail($brainId)
    {
        $premise = $this->BrainStormRepository->getBrainById($brainId);

        return view('brain-storm.detail', compact('premise'));
    }

    public function changeBrainStormStatus($brainId)
    {
        return $this->BrainStormRepository->changeStatus($brainId);
    }

    public function deleteBrainStorm($brainId)
    {
        return $this->BrainStormRepository->deleteBrain($brainId);
    }
}
