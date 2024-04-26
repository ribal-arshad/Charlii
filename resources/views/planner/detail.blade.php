@extends('layouts.master')

@section('title', 'Plot Planner Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Plot Planner Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$planner?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <div class="color-input">
                                    {!! $planner->color->color ? '<span class="color-block"><span style="background-color: ' . $planner->color->color_code . '"></span>' . $planner->color->color . '</span>' : '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Series</label>
                                <input type="text" class="form-control" value="{{ $planner->series ? $planner->series->series_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Book</label>
                                <input type="text" class="form-control" value="{{ $planner->book ? $planner->book->book_name : '' }}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Plot Planner Title</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$planner?->plot_planner_title}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Plot Planner Description</label>
                                <textarea class="form-control" name="description" cols="3" rows="3" readonly>{{ $planner->description ?? 'No Description'}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$planner->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.planners')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
