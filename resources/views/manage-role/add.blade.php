@extends('layouts.master')

@section('title', 'Add Role')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add Role</h5>
                    <div class="card-body">
                        <form action="{{ route('role.add.data') }}" method="POST">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label">Name
                                        <i class="fa fa-asterisk small-font text-danger" aria-hidden="true"></i>
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Enter name" />
                                </div>
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
                            <div class="row gy-4 mt-3">
                                <!-- Accordion Header Color -->
                                <div class="col-md-12">
                                    <label class="fw-semibold">Permissions</label>
                                    <div class="accordion mt-3 accordion-header-primary" id="accordionStyle1">
                                        <div class="row">
                                            @foreach ($permissions as $key => $permission)
                                                <div class="col-md-4 mb-1">
                                                    <div class="accordion-item card">
                                                        <h2 class="accordion-header">
                                                            <button type="button"
                                                                class="accordion-button collapsed shadow-sm"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#accordionStyle-{{ $loop->index }}"
                                                                aria-expanded="false">
                                                                {{ ucfirst($key) }}
                                                            </button>
                                                        </h2>

                                                        <div id="accordionStyle-{{ $loop->index }}"
                                                            class="accordion-collapse collapse">
                                                            <div class="accordion-body">
                                                                <div class="demo-inline-spacing mt-3 parent-div">
                                                                    <div class="list-group">
                                                                        <label class="list-group-item">
                                                                            <input class="form-check-input me-2 check-all"
                                                                                type="checkbox"> All
                                                                        </label>
                                                                        @foreach ($permission as $key1 => $p)
                                                                            <label class="list-group-item">
                                                                                <input class="form-check-input me-2"
                                                                                    name="permissions[]" type="checkbox"
                                                                                    value="{{ $p }}">{{ $p }}
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--/ Accordion Header Color -->
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{ route('manage.roles') }}" class="btn btn-danger redirect-btn">Back</a>
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
        $(document).on('click', '.check-all', function() {
            const element = $(this);
            const parent = element.closest(".parent-div");
            parent.find("input").prop("checked", element.prop('checked'))
        });
        $(document).on('click', 'input[type="checkbox"]', function() {
            const element = $(this);
            const parent = element.closest(".parent-div");
            if (!element.hasClass('check-all')) {
                const total_elements = element.closest(".parent-div").find("input[type='checkbox']");
                const total_count = total_elements.length - 1;
                let checked_count = 0;

                total_elements.each(function() {
                    if (!$(this).hasClass("check-all") && $(this).is(":checked"))
                        checked_count++;
                })
                if (total_count === checked_count) {
                    parent.find("input.check-all").prop('checked', true)
                } else {
                    parent.find("input.check-all").prop('checked', false)
                }
            }
        });
    </script>
@endpush
