@extends('layouts.master')

@section('title', 'Premise Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Premise Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$premise?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <div class="color-input">
                                    {!! $premise->color->color ? '<span class="color-block"><span style="background-color: ' . $premise->color->color_code . '"></span>' . $premise->color->color . '</span>' : '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Series</label>
                                <input type="text" class="form-control" value="{{ $premise->series ? $premise->series->series_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Book</label>
                                <input type="text" class="form-control" value="{{ $premise->book ? $premise->book->book_name : '' }}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Brain Storm Name</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$premise?->brainstorm_name}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" cols="3" rows="3" readonly>{{ $premise->description ?? 'No Description'}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$premise->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('brain-storm')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
