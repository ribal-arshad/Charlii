@extends('layouts.master')

@section('title', 'Manage Groups')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="float-start">Manage Groups</h5>
                <a href="{{route('group.add')}}" class="btn btn-primary float-end redirect-btn">Add +</a>
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
                "ajax": "{{ route('manage.groups') }}",
                "columns": [
                    { "data" : "user_name","title" : "User Name", "orderable": false, "searchable": true },
                    { "data" : "group_name","title" : "Group Name", "orderable": false, "searchable": false },
                    { "data" : "members","title" : "Members", "orderable": false, "searchable": false },
                    { "data" : "group_icon","title" : "Group Icon", "orderable": false, "searchable": false },
                    { "data" : "action","title" : "Action", "orderable": false, "searchable": false, "width": "190px" }
                ]
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
