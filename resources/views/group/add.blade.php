@extends('layouts.master')

@section('title', 'Add Group')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add Group</h5>
                    <div class="card-body">
                        <form action="{{route('group.add.data')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('partials.alert')
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">User Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="user_id" id="user_id" class="form-select">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Group Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="group_name" value="{{old('group_name')}}" placeholder="Enter group name"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Members</label>
                                    <select class="form-control" name="members[]" multiple>
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
                                    <input type="file" class="form-control" id="group_icon" name="group_icon" value="" />
                                    <img class="mt-3" id="group_icon_preview" src="" height="250px" width="250px" style="display: none;" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.groups')}}" class="btn btn-danger redirect-btn">Back</a>
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
        $(document).ready(function() {
            $('select.select2').select2();

            function getMembers() {
                $.ajax({
                    url: '{{ route('active.users') }}',
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        let defaultOption = '<option value="">Select Members</option>';
                        let optionsHtml = response.options.map(function(option) {
                            return '<option value="' + option.id + '">' + option.name + '</option>';
                        }).join('');
                        $('select[name="members[]"]').html(defaultOption + optionsHtml);
                        $('select[name="members[]"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
            getMembers();

            $('#select-all').on('click', function() {
                $('select[name="members[]"] option').prop('selected', true);
                $('select[name="members[]"]').trigger('change');
            });

            $('#deselect-all').on('click', function() {
                $('select[name="members[]"] option').prop('selected', false);
                $('select[name="members[]"]').trigger('change');
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#group_icon_preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#group_icon").change(function(){
            readURL(this);
        });
    </script>
@endpush
