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
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{$user->email}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="{{$user->username}}" disabled/>
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
