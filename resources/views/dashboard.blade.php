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
                                <h2 class="mb-0">{{ $totalUsers }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-movie fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Total Series</span>
                                <h2 class="mb-0">{{ $totalSeries }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-book fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Total Books</span>
                                <h2 class="mb-0">{{ $totalBooks }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="avatar mx-auto mb-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-building-house fs-4"></i></span>
                                </div>
                                <span class="d-block text-nowrap">Total Premises</span>
                                <h2 class="mb-0">{{ $totalPremises }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
