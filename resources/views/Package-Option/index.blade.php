@extends('layouts.master')

@section('title', 'Package Option List')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h4 class="float-start">Package Option List</h4>
                <a href="{{route('Package.option.add')}}" class="btn btn-primary float-end redirect-btn">Add +</a>
            </div>
            <div class="card-datatable text-nowrap">
                <div class="row">
                    <div class="col-md-12">
                        @include('partials.alert')
                    </div>
                </div>
                <table id="Roles" class="table table-bordered table-responsive"></table>
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
            $('#Roles').DataTable({
                "processing": true,
                "serverSide": true,
                'iDisplayLength':50,
                "orderMulti": true,
                "scrollX": true,
                "ajax": "{{ route('Package.option') }}",
                "columns": [
                    { "data" : "id","title" : "id", "orderable": true, "searchable": true },
                    { "data" : "option_name", "title" : "Option Name", "orderable": true, "searchable": true },
                    // { "data" : "created_at", "title" : "permission", "orderable": false, "searchable": false },
                    { "data" : "action","title" : "Action", "orderable": false, "searchable": false, "width": "190px" }
                ]
            });
        });

        function changeStatus(route) {
            axios.get(route).then(function (response) {
                swal({
                    title: response.data.msg,
                    icon: "success",
                    closeOnClickOutside: false
                }).then((successBtn) => {
                    if (successBtn) {
                        $('#locations').DataTable().ajax.reload();
                    }
                });
            }).catch(function (error) {
                swal({
                    title: error.response.data.msg,
                    icon: "error",
                    dangerMode: true,
                    closeOnClickOutside: false
                });
            });
        }

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
