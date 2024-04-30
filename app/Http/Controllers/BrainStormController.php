<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrainstormStoreRequest;
use App\Http\Requests\BrainstormUpdateRequest;
use App\Interfaces\BrainStormRepositoryInterface;
use App\Models\Book;
use App\Models\Brainstorm;
use App\Models\Color;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class BrainStormController extends Controller
{
    private BrainStormRepositoryInterface $brainStormRepository;

    public function __construct(BrainStormRepositoryInterface $brainStormRepository)
    {
        $this->brainStormRepository = $brainStormRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->brainStormRepository->getDataTable();
        }

        return view('brain-storm.index');
    }

    public function addBrainStorm()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('brain-storm.add', compact( 'colors', 'users'));
    }

    public function addBrainStormData(BrainstormStoreRequest $request)
    {
        return $this->brainStormRepository->createBrainStorm($request);
    }

    public function updateBrainStorm($brainId)
    {
        $brainStorm = Brainstorm::findorfail($brainId);

        if (!empty($brainStorm)) {
            $series = Series::where('user_id', $brainStorm->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $brainStorm->series_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedBook = $brainStorm->book ? $brainStorm->book->id : '';

            return view('brain-storm.update', compact('brainStorm', 'series', 'books', 'colors', 'users', 'selectedBook'));
        }

        abort(404);
    }

    public function updateBrainStormData($brainId, BrainstormUpdateRequest $request)
    {
        return $this->brainStormRepository->updateBrain($brainId, $request);
    }

    public function getBrainStormDetail($brainId)
    {
        $brainStorm = $this->brainStormRepository->getBrainById($brainId);

        return view('brain-storm.detail', compact('brainStorm'));
    }

    public function changeBrainStormStatus($brainId)
    {
        return $this->brainStormRepository->changeStatus($brainId);
    }

    public function deleteBrainStorm($brainId)
    {
        return $this->brainStormRepository->deleteBrain($brainId);
    }
}
