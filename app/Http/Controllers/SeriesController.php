<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesStoreRequest;
use App\Http\Requests\SeriesUpdateRequest;
use App\Interfaces\SeriesRepositoryInterface;
use App\Models\Book;
use App\Models\Color;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    private SeriesRepositoryInterface $seriesRepository;

    public function __construct(SeriesRepositoryInterface $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->seriesRepository->getDataTable();
        }

        return view('series.index');
    }

    public function addSeries()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('series.add', compact( 'colors', 'users'));
    }

    public function addSeriesData(SeriesStoreRequest $request)
    {
        return $this->seriesRepository->createSeries($request);
    }

    public function updateSeries($seriesId)
    {
        $series = Series::findorfail($seriesId);

        if (!empty($series)) {
            $books = Book::where('user_id', $series->user_id)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $selectedBooks = $series->books->pluck('id')->toArray();

            return view('series.update', compact('series', 'selectedBooks', 'books', 'colors', 'users'));
        }

        abort(404);
    }

    public function updateSeriesData($seriesId, SeriesUpdateRequest $request)
    {
        return $this->seriesRepository->updateSeries($seriesId, $request);
    }

    public function getSeriesDetail($seriesId)
    {
        $series = $this->seriesRepository->getSeriesById($seriesId);

        return view('series.detail', compact('series'));
    }

    public function changeSeriesStatus($seriesId)
    {
        return $this->seriesRepository->changeStatus($seriesId);
    }

    public function deleteColor($seriesId)
    {
        return $this->seriesRepository->deleteSeries($seriesId);
    }

    public function getUserBooks(Request $request)
    {
        $userId = $request->input('user_id');
        $books = Book::where('status', 1)->where('user_id', $userId)->get();

        $options = '';
        foreach ($books as $item) {
            $options .= '<option value="' . $item->id . '">' . ($item->book_name) . '</option>';
        }

        return response()->json(['options' => $options]);
    }
}
