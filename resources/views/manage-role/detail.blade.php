@extends('layouts.master')

@section('title', 'Role Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Role Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Name</label>
                                <input type="email" class="form-control" value="{{$role->name}}" disabled/>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{$role->status ? 'Active' : 'Inactive'}}" disabled/>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Basic Badges -->
                            <div class="col-lg mt-3">
                                <div class="card mb-4">
                                    <h5 class="card-header">Permissions</h5>
                                    <div class="card-body">
                                        <div class="demo-inline-spacing">
                                            @forelse($role->permissions as $permission)
                                                <span class="badge bg-primary text-lowercase">{{$permission->name}}</span>
                                            @empty
                                                <span class="badge bg-danger">No Permissions</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('manage.roles')}}" class="btn btn-danger redirect-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
