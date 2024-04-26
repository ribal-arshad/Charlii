@extends('layouts.master')

@section('title', 'Add Timeline Event Type')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add Timeline Event Type</h5>
                    <div class="card-body">
                        <form action="{{route('timeline.event.type.add.data')}}" method="POST">
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
                                    <label class="form-label">Color
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    {!! colorDropDown($colors, old("color_id")) !!}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Series</label>
                                    <select class="form-control" name="series_id" id="series">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Books</label>
                                    <select class="form-control" name="book_id" id="books">
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Timeline</label>
                                    <select class="form-control" name="timeline_id" id="timelines">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Event type
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="event_type" value="{{old('event_type')}}" placeholder="Enter event type"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.timeline.event.types')}}" class="btn btn-danger redirect-btn">Back</a>
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

            $('select[name="user_id"]').change(function() {
                let userId = $(this).val();

                $.ajax({
                    url: '{{ route('user.series') }}',
                    method: 'GET',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Series</option>';

                        $('select[name="series_id"]').html(defaultOption + response.options);
                        $('select[name="series_id"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $('select[name="series_id"]').select2();

            $('select[name="series_id"]').change(function() {
                let seriesId = $(this).val();

                $.ajax({
                    url: '{{ route('book.series') }}',
                    method: 'GET',
                    data: {
                        series_id: seriesId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Book</option>';

                        let optionsHtml = '';
                        response.options.forEach(function(option) {
                            optionsHtml += '<option value="' + option.id + '">' + option.book_name + '</option>';
                        });
                        $('select[name="book_id"]').html(defaultOption + optionsHtml);
                        $('select[name="book_id"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('select[name="book_id"]').change(function() {
                let bookId = $(this).val();

                $.ajax({
                    url: '{{ route('timeline.book') }}',
                    method: 'GET',
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Timeline</option>';

                        let optionsHtml = '';
                        response.options.forEach(function(option) {
                            optionsHtml += '<option value="' + option.id + '">' + option.name + '</option>';
                        });
                        $('select[name="timeline_id"]').html(defaultOption + optionsHtml);
                        $('select[name="timeline_id"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

