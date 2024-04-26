@extends('layouts.master')

@section('title', 'Update Group')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update Group</h5>
                    <div class="card-body">
                        <form action="{{route('group.update.data', $group->id)}}" method="POST" enctype="multipart/form-data">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $group->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Group Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="group_name" value="{{old('group_name', $group->group_name)}}" placeholder="Enter group name"/>
                                </div>
                            </div>

                            <div class="row profile_image_parent mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Members</label>
                                    <select class="form-control" name="members[]" multiple id="members_select">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ in_array($user->id, $selectedMembers) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary btn-xs" id="select-all">Select All</button>
                                        <button type="button" class="btn btn-danger btn-xs" id="deselect-all">Deselect All</button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Group Icon
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" class="form-control" id="group_icon" name="image"
                                           value="" />
                                    <img class="mt-3" id="group_icon_preview" src="{{ !empty($group->getFirstMediaUrl('group_icons')) ? $group->getFirstMediaUrl('group_icons') : asset('assets/img/profiles/default.png') }}" height="250px" width="250px" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.groups')}}" class="btn btn-danger redirect-btn">Back</a>
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
                    $('#group_icon_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#group_icon").change(function(){
            readURL(this);
        });

        $(document).ready(function() {
            function getMembers() {
                var preSelectedMembers = {!! json_encode($selectedMembers) !!};

                $.ajax({
                    url: '{{ route('active.users') }}',
                    method: 'GET',
                    success: function(response) {
                        var defaultOption = '<option value="">Select Members</option>';
                        var optionsHtml = response.options.map(function(option) {
                            return '<option value="' + option.id + '">' + option.name + '</option>';
                        }).join('');

                        $('select[name="members[]"]').html(defaultOption + optionsHtml);

                        $('select[name="members[]"] option').each(function() {
                            if (preSelectedMembers.includes(parseInt($(this).val()))) {
                                let ss = $(this).prop('selected', true);
                            }
                        });

                        $('select[name="members[]"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            getMembers();

            $('#select-all').on('click', function() {
                $('select[name="members[]"] option').each(function(index) {
                    if (index !== 0) {
                        $(this).prop('selected', true);
                    }
                });

                $('select[name="members[]"]').trigger('change');
            });


            $('#deselect-all').on('click', function() {
                $('select[name="members[]"] option').prop('selected', false);
                $('select[name="members[]"]').trigger('change');
            });
        });

    </script>
@endpush
