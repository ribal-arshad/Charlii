@extends('layouts.master')

@section('title', 'Manage Calendars')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="float-start">Manage Calendars</h5>
                <a href="{{route('calendar.add')}}" class="btn btn-primary float-end redirect-btn">Add +</a>
            </div>
            <div class="card-datatable text-nowrap">
                <div class="row">
                    <div class="col-md-12">
                        @include('partials.alert')
                    </div>
                </div>
                <table id="custom_datatable" class="table table-bordered table-responsive"></table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script>
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    <script>
        $(function (){
            $('#custom_datatable').DataTable({
                "processing": true,
                "serverSide": true,
                'iDisplayLength':50,
                "orderMulti": true,
                "scrollX": true,
                "ajax": "{{ route('manage.calendars') }}",
                "columns": [
                    { "data" : "user_name", "title" : "User Name", "orderable": false, "searchable": true },
                    { "data" : "title","title" : "Title", "orderable": true, "searchable": true },
                    { "data" : "event_date","title" : "Event Date", "orderable": true, "searchable": false },
                    { "data" : "start_time", "title" : "Start Time", "orderable": false, "searchable": true },
                    { "data" : "end_time", "title" : "End Time", "orderable": false, "searchable": true },
                    { "data" : "color", "title" : "Color", "orderable": false, "searchable": true },
                    { "data" : "action","title" : "Action", "orderable": false, "searchable": false, "width": "190px" }
                ],
            });
        });

        function deleteData(route) {
            swal({
                title: "Are You Sure?",
                icon: "warning",
                closeOnClickOutside: false,
                buttons:{cancel:true,confirm:"Yes, delete it!"},
                dangerMode: true
            }).then((btn) => {
                if(btn){
                    window.location.href = route;
                }
            })
        }
    </script>
@endpush
