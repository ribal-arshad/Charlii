<?php

namespace App\Repositories;

use App\Interfaces\SeriesRepositoryInterface;
use App\Models\Series;
use Yajra\DataTables\Facades\DataTables;

class SeriesRepository implements SeriesRepositoryInterface
{
    public function getAllSeries()
    {
        return Series::get();
    }

    public function getSeriesById($seriesId)
    {
        return Series::findOrFail($seriesId);
    }

    public function deleteSeries($seriesId)
    {
        $series = $this->getSeriesById($seriesId);
        if (!empty($series)) {
            $series->delete();

            return redirect()->back()->with('success_msg', 'Series successfully deleted.');
        }

        abort(404);
    }

    public function createSeries($seriesDetails)
    {
        $series = Series::create([
            'user_id' => $seriesDetails->user_id,
            'color_id' => $seriesDetails->color_id,
            'image_id' => $seriesDetails->image_id,
            'series_name' => $seriesDetails->series_name,
            'series_description' => $seriesDetails->series_description,
            'is_finished' => $seriesDetails->is_finished,
            'status' => $seriesDetails->status,
        ]);
        $series->books()->sync($seriesDetails->input('books', []));

        return redirect()->route('manage.series')->with('success_msg', 'Series successfully added.');
    }

    public function updateSeries($seriesId, $seriesDetails)
    {
        $series = Series::findOrFail($seriesId);

        if(!empty($series)){
            $series->update([
                'user_id' => $seriesDetails->user_id,
                'color_id' => $seriesDetails['color_id'],
                'image_id' => $seriesDetails['image_id'],
                'series_name' => $seriesDetails['series_name'],
                'series_description' => $seriesDetails['series_description'],
                'is_finished' => $seriesDetails['is_finished'],
                'status' => $seriesDetails['status'],
            ]);
            $series->books()->sync($seriesDetails->input('books', []));

            return redirect()->route('manage.series')->with('success_msg', 'Series successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Series not found.');
    }

    public function getDataTable(){

        $query = Series::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        if(strtolower($search) === "active"){
                            $w->orWhere('status', 1);
                        }elseif(strtolower($search) === "inactive"){
                            $w->orWhere('status', 0);
                        }
                    });
                }
            })
            ->addColumn('user_name', function ($obj) {
                return $obj->user->name;
            })
            ->editColumn('book', function ($obj) {
                $labels = [];
                foreach ($obj->books as $book) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $book->book_name);
                }

                return implode(', ', $labels);
            })
            ->editColumn('is_finished', function ($obj) {
                return $obj->is_finished === 1 ? 'Yes' : 'No';
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('series.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('series.change.status', $obj->id) . '`)" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                              </span>
                                              <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                              </span>
                                            </span>
                                        </label>';
                } else {
                    $switchBtn = $obj->status === 1 ? 'Active' : 'Inactive';
                }

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('series.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('series.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('series.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('series.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('series.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('series.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book', 'is_finished', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($seriesId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $series = $this->getSeriesById($seriesId);

        if (!empty($series)) {
            $series->update([
                'status' => !$series->status
            ]);
            $msg = "Series status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
