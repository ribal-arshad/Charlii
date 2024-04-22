@extends('layouts.master')

@section('title', 'Add User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add User</h5>
                    <div class="card-body">
                        <form action="{{route('user.add.data')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter name"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Email
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Enter email"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Password (Min. 8 characters)
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="password" class="form-control" name="password" value="" placeholder="Enter password"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Role
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row profile_image_parent mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Profile Picture
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                           value="" />
                                    <img class="mt-3" id="profile_image_preview" src="" height="250px" width="250px" style="display: none;" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.users')}}" class="btn btn-danger redirect-btn">Back</a>
                                    <button type="submit" class="btn btn-primary" onclick="showLoader()">Add</button>
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
                    $('#profile_image_preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile_picture").change(function(){
            readURL(this);
        });
    </script>
@endpush
