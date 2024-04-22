@extends('layouts.master')

@section('title', 'Manage Account')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Manage Account</h5>
                    <div class="card-body">
                        <form action="{{route('manage.account.data')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" placeholder="Enter name"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email', $user->email)}}" placeholder="Enter email"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">New Password (Min. 8 characters)</label>
                                    <div class="input-group form-password-toggle">
                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="Enter new password"
                                            aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Confirm Password (Min. 8 characters)</label>
                                    <div class="input-group form-password-toggle">
                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password_confirmation"
                                            placeholder="Enter confirm password"
                                            aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row profile_image_parent mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                           value="" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <img id="profile_image_preview"
                                         src="{{ auth()->user()->getFirstMediaUrl('user_profile_image') ? auth()->user()->getFirstMediaUrl('user_profile_image') : asset('assets/img/profiles/default.png') }}" height="250px"
                                         width="250px" alt="profile image" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" onclick="showLoader()">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile_image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile_picture").change(function(){
            readURL(this);
        });
    </script>
@endpush
