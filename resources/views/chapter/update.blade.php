@extends('layouts.master')

@section('title', 'Update Chapter')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update Chapter</h5>
                    <div class="card-body">
                        <form action="{{route('chapter.update.data', $chapter->id)}}" method="POST">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $chapter->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Color
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    {!! colorDropDown($colors, old('color_id', $chapter->color_id)) !!}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Series</label>
                                    <select class="form-control" name="series_id" id="series">
                                        @foreach ($series as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id, $selectedSeries ? 'selected' : '' }}>
                                                {{ $item->series_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Book</label>
                                    <select class="form-control" name="book_id" id="books">
                                        @foreach ($books as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id, $selectedBook ? 'selected' : '' }}>
                                                {{ $item->book_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Outline</label>
                                    <select class="form-control" name="outline_id" id="outlines">
                                        @foreach ($outlines as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id, $selectedOutline ? 'selected' : '' }}>
                                                {{ $item->outline_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Chapter Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="chapter_name" value="{{old('chapter_name', $chapter->chapter_name)}}" placeholder="Enter chapter name"/>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" @selected(old('status', $chapter->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $chapter->status) == 0)>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.chapters')}}" class="btn btn-danger redirect-btn">Back</a>
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
                    url: '{{ route('outline.book') }}',
                    method: 'GET',
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Outline</option>';

                        let optionsHtml = '';
                        response.options.forEach(function(option) {
                            optionsHtml += '<option value="' + option.id + '">' + option.outline_name + '</option>';
                        });
                        $('select[name="outline_id"]').html(defaultOption + optionsHtml);
                        $('select[name="outline_id"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
