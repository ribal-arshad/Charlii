@extends('layouts.master')

@section('title', 'Update User Gallery')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update User Gallery</h5>
                    <div class="card-body">
                        <form action="{{route('user.gallery.update.data', $image->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('partials.alert')
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">User
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="user_id" id="user_id" class="form-select">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $image->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" @selected(old('status', $image->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $image->status) == 0)>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row profile_image_parent mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Gallery Image
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" class="form-control" id="gallery_image" name="image"
                                           value="" />
                                    <img class="mt-3" id="gallery_image_preview" src="{{ !empty($image->getFirstMediaUrl('user_gallery_images')) ? $image->getFirstMediaUrl('user_gallery_images') : asset('assets/img/profiles/default.png') }}" height="250px" width="250px" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.user.gallery')}}" class="btn btn-danger redirect-btn">Back</a>
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
@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#gallery_image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gallery_image").change(function(){
            readURL(this);
        });
    </script>
@endpush
