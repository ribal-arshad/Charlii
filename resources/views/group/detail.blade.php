@extends('layouts.master')

@section('title', 'Group Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Group Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{$group?->user?->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Group Name</label>
                                <div class="color-input">
                                    <input type="text" class="form-control" value="{{$group?->group_name}}" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Members</label>
                                @foreach($group->members as $key => $members)
                                    <span class="label label-info">{{ $members->name }}</span>
                                @endforeach
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Group Icon</label>
                                <br>
                                <img src="{{ !empty($group->getFirstMediaUrl('group_icons')) ? $group->getFirstMediaUrl('group_icons') : asset('assets/img/profiles/default.png') }}" width="250" height="250" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.groups')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
