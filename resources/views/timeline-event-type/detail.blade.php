@extends('layouts.master')

@section('title', 'Timeline Event Type Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Timeline Event Type</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$eventType?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <div class="color-input">
                                    {!! $eventType->color->color ? '<span class="color-block"><span style="background-color: ' . $eventType->color->color_code . '"></span>' . $eventType->color->color . '</span>' : '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Series</label>
                                <input type="text" class="form-control" value="{{ $eventType->series ? $eventType->series->series_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Book</label>
                                <input type="text" class="form-control" value="{{ $eventType->book ? $eventType->book->book_name : '' }}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Outline</label>
                                <input type="text" class="form-control" value="{{ $eventType->timeline ? $eventType->timeline->name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Event Type</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$eventType?->event_type}}" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$eventType->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.timeline.event.types')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
