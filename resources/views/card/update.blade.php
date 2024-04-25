@extends('layouts.master')

@section('title', 'Update Chapter Card')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update Chapter Card</h5>
                    <div class="card-body">
                        <form action="{{route('card.update.data', $card->id)}}" method="POST">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $card->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Color
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    {!! colorDropDown($colors, old('color_id', $card->color_id)) !!}
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
                                    <label class="form-label">Chapter</label>
                                    <select class="form-control" name="chapter_id" id="chapters">
                                        @foreach ($chapters as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id, $selectedChapter ? 'selected' : '' }}>
                                                {{ $item->chapter_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Chapter Card Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="card_title" value="{{old('card_title', $card->card_title)}}" placeholder="Enter chapter card name"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Chapter Card Description
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <textarea class="form-control" name="card_description" placeholder="Enter card_description" cols="3" rows="3">{{ old('card_description', $card->card_description) }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" @selected(old('status', $card->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $card->status) == 0)>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.cards')}}" class="btn btn-danger redirect-btn">Back</a>
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

            $('select[name="outline_id"]').change(function() {
                let outlineId = $(this).val();

                $.ajax({
                    url: '{{ route('chapter.outline') }}',
                    method: 'GET',
                    data: {
                        outline_id: outlineId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Chapter</option>';

                        let optionsHtml = '';
                        response.options.forEach(function(option) {
                            optionsHtml += '<option value="' + option.id + '">' + option.chapter_name + '</option>';
                        });
                        $('select[name="chapter_id"]').html(defaultOption + optionsHtml);
                        $('select[name="chapter_id"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
