@extends('layouts.master')

@section('title', 'Update Book')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update Book</h5>
                    <div class="card-body">
                        <form action="{{route('book.update.data', $book->id)}}" method="POST">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $book->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Color
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    {!! colorDropDown($colors, old('color_id', $book->color_id)) !!}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Book Title
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="book_name" value="{{old('book_name', $book->book_name)}}" placeholder="Enter book title"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Book Description
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <textarea class="form-control" name="book_description" placeholder="Enter book_description" cols="3" rows="3">{{ old('book_description', $book->book_description) }}</textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Is finished?
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="is_finished" id="is_finished" class="form-select">
                                        <option value="1" @selected(old('is_finished', $book->is_finished) == 1)>Yes</option>
                                        <option value="0" @selected(old('is_finished', $book->is_finished) == 0)>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" @selected(old('status', $book->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $book->status) == 0)>Inactive</option>
                                    </select>
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
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.books')}}" class="btn btn-danger redirect-btn">Back</a>
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
                var userId = $(this).val();

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
        });
    </script>
@endpush
