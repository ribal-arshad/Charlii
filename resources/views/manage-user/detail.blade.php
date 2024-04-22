@extends('layouts.master')

@section('title', 'User Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">User Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{$user->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{$user->email}}" disabled/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Email Verified At</label>
                                <input type="text" class="form-control" value="{{$user->email_verified_at ? $user->email_verified_at->format('m-d-Y') : 'Not Verified'}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Role</label>
                                <input type="tel" class="form-control" value="{{ isset($user->roles[0]) ? $user->roles[0]?->name : 'NA' }}" readonly />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$user->status === 1 ? "Active" : 'Not Active'}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Profile Image</label>
                                <br>
                                <img src="{{ !empty($user->getFirstMediaUrl('user_profile_image')) ? $user->getFirstMediaUrl('user_profile_image') : asset('assets/img/profiles/default.png') }}" width="250" height="250" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.users')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
