@extends('layouts.master')

@section('title', 'Brainstorm Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Brainstorm Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$brainStorm?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <div class="color-input">
                                    {!! $brainStorm->color->color ? '<span class="color-block"><span style="background-color: ' . $brainStorm->color->color_code . '"></span>' . $brainStorm->color->color . '</span>' : '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Series</label>
                                <input type="text" class="form-control" value="{{ $brainStorm->series ? $brainStorm->series->series_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Book</label>
                                <input type="text" class="form-control" value="{{ $brainStorm->book ? $brainStorm->book->book_name : '' }}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Brainstorm Name</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$brainStorm?->brainstorm_name}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" cols="3" rows="3" readonly>{{ $brainStorm->description ?? 'No Description'}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Audio File</label>
                                <div class="color-input">
                                    @if($brainstorm->audio_file)
                                        <audio controls><source src="{{ asset("storage/audio/" . $brainstorm->audio_file) }}" type="audio/mp3">Your browser does not support the audio element.</audio>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Transcript</label>
                                <input type="text" class="form-control" value="{{$brainStorm?->transcript}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$brainStorm->status === 1 ? "Active" : 'Not Active'}}" disabled/>
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
