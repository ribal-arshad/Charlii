@extends('layouts.master')

@section('title', 'Chapter Card Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Chapter Card Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$card?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Color</label>
                                <div class="color-input">
                                    {!! $card->color->color ? '<span class="color-block"><span style="background-color: ' . $card->color->color_code . '"></span>' . $card->color->color . '</span>' : '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Series</label>
                                <input type="text" class="form-control" value="{{ $card->series ? $card->series->series_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Book</label>
                                <input type="text" class="form-control" value="{{ $card->book ? $card->book->book_name : '' }}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Outline</label>
                                <input type="text" class="form-control" value="{{ $card->outline ? $card->outline->outline_name : '' }}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Chapter</label>
                                <input type="text" class="form-control" value="{{ $card->chapter ? $card->chapter->chapter_name : '' }}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Chapter Card Name</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$card?->card_title}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Chapter Card Description</label>
                                <textarea class="form-control" name="card_description" cols="3" rows="3" readonly>{{ $card->card_description ?? 'No Description'}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$card->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.cards')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
