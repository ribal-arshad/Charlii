@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('partials.alert')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-user fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Total Users</span>
                                <h2 class="mb-0">12313</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bxs-calendar fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Total Task</span>
                                <h2 class="mb-0">123123</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-calendar-x fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Pending Task</span>
                                <h2 class="mb-0">321312</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-calendar-check fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Completed Task</span>
                                <h2 class="mb-0">332</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
