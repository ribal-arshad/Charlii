@extends('layouts.master')

@section('title', 'Update Series')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update Series</h5>
                    <div class="card-body">
                        <form action="{{route('series.update.data', $series->id)}}" method="POST">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $series->user_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Color
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    {!! colorDropDown($colors, old('color_id', $series->color_id)) !!}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Series Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="series_name" value="{{old('series_name', $series->series_name)}}" placeholder="Enter series name"/>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Series Description
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <textarea class="form-control" name="series_description" placeholder="Enter series_description" cols="3" rows="3">{{ old('series_description', $series->series_description) }}</textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Is finished?
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="is_finished" id="is_finished" class="form-select">
                                        <option value="1" @selected(old('is_finished', $series->is_finished) == 1)>Yes</option>
                                        <option value="0" @selected(old('is_finished', $series->is_finished) == 0)>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Status
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" @selected(old('status', $series->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $series->status) == 0)>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Books</label>
                                    <select class="form-control" name="books[]" multiple id="books_select">
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}"
                                                {{ in_array($book->id, $selectedBooks) ? 'selected' : '' }}>
                                                {{ $book->book_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary btn-xs" id="select-all">Select All</button>
                                        <button type="button" class="btn btn-danger btn-xs" id="deselect-all">Deselect All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{route('manage.series')}}" class="btn btn-danger redirect-btn">Back</a>
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
                    url: '{{ route('user.books') }}',
                    method: 'GET',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {
                        let defaultOption = '<option value="">Select Book</option>';

                        $('select[name="books[]"]').html(defaultOption + response.options);
                        $('select[name="books[]"]').select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $('select[name="books[]"]').select2();

            $('#select-all').on('click', function() {
                $('select[name="books[]"] option').prop('selected', true);
                $('select[name="books[]"]').trigger('change');
            });

            $('#deselect-all').on('click', function() {
                $('select[name="books[]"] option').prop('selected', false);
                $('select[name="books[]"]').trigger('change');
            });
        });
    </script>
@endpush
