@extends('layouts.master')

@section('title', 'Color Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Color Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <input type="text" class="form-control" value="{{$color?->color}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color Code</label>
                                <div class="color-input">
                                    <span class="color-block"><span style="background-color: {{$color ? $color->color_code : '#ffffff'}}"></span>{{ $color->color_code }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Foreground Color</label>
                                <div class="color-input">
                                    <span class="color-block"><span style="background-color: {{$color ? $color->foreground_color : '#ffffff'}}"></span>{{ $color->foreground_color }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$color->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.colors')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
