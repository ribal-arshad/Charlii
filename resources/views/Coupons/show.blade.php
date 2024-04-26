@extends('layouts.master')

@section('title', 'Show Coupons')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Show coupons</h5>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-group">

                                </div>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th>
                                            Id
                                        </th>
                                        <td>
                                            {{ $coupon->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Coupon Code
                                        </th>
                                        <td>
                                            {{ $coupon->coupon_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Package
                                        </th>
                                        <td>
                                            {{ $coupon->package->package_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Package Type
                                        </th>
                                        <td>
                                            {{$coupon->package_type}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Discount Amount
                                        </th>
                                        <td>
                                            {{ $coupon->discount_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Discount Type
                                        </th>
                                        <td>
                                           {{$coupon->discount_type}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Number Of Usage
                                        </th>
                                        <td>
                                            {{ $coupon->number_of_usage }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Date Of Expiry
                                        </th>
                                        <td>
                                            {{ $coupon->date_of_expiry }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            {{$coupon->status}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                                    <a href="{{route('coupon')}}" style="margin-left: 50px;" class="btn btn-danger">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">





</script>


