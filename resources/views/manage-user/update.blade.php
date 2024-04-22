@extends('layouts.master')

@section('title', 'Update User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update User</h5>
                    <div class="card-body">
                        <form action="{{route('user.update.data', $user->id)}}" method="POST">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{old('username', $user->username)}}" placeholder="Enter username"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email', $user->email)}}" placeholder="Enter email"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Password (Min. 8 characters)</label>
                                    <input type="password" class="form-control" name="password" value="" placeholder="Enter password"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.users')}}" class="btn btn-danger redirect-btn">Back</a>
                                    <button type="submit" class="btn btn-primary" onclick="showLoader()">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
