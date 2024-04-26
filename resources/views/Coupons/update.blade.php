@extends('layouts.master')

@section('title', 'Coupon')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">coupons </h5>
                    <div class="card-body">
                        <form action="{{route('coupon.update.data',$coupon->id)}}" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="required" for="coupon_code">Coupon Code</label><br>
                                    <input class="form-control" type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code',$coupon->coupon_code) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="required" for="coupon_code">Package</label>
                                    <select class="form-control select2" id="search_id" tabindex="1" name="package_id">
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="col-md-4">
                                    <label class="required" for="coupon_code"> Any Package Package Type</label>
                                    <select class="form-control select2" id="search_id" tabindex="1" name="package_type">
                                        <option value="0">Select Package Type</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br><br><br><br>
                                <div class="col-4">
                                    <label class="required" for="coupon_code">Discount Amount</label><br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupCurrency">$<input class="form-check-input" type="radio" name="discount_amount" id="dollarRadio" value="{{old('discount_amount',$coupon->discount_amount)}}" checked></span>
                                        </div>
                                        <input type="number" class="form-control" name="discount_amount" value="{{old('discount_amount',$coupon->discount_amount)}}" aria-label="Amount (to the nearest dollar)" id="amountInput">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%<input class="form-check-input" type="radio" name="discount_amount" id="percentRadio" value="{{old('discount_amount',$coupon->discount_amount)}}"></span>
                                        </div>
                                    </div>
                                </div><br><br><br><br>
                                <div class="col-md-4">
                                    <label class="form-label">Number Of Usage
                                    </label>
                                    <input type="text" class="form-control" name="number_of_usage" value="{{old('number_of_usage',$coupon->number_of_usage)}}" placeholder="Enter number_of_usage"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date Of Expiry
                                    </label>
                                    <input type="date" class="form-control" name="date_of_expiry" value="{{old('date_of_expiry',$coupon->date_of_expiry)}}" placeholder="Enter number_of_usage"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="required" >Status</label>
                                    <select class="form-control select2" name="status">
                                        <option value="">---Select Status----</option>
                                        <option value="1"{{old('status', $coupon->status)==1 ? 'selected':''}}>Enable</option>
                                        <option value="0"{{old('status', $coupon->status)==0 ? 'selected':''}}>Disable</option>
                                    </select>
                                </div><br><br><br><br>

                                @csrf
                                @include('partials.alert')

                                <div class="form-group">
                                    <a href="{{route('coupon')}}" class="btn btn-danger" >back</a>

                                    <button type="submit" class="btn btn-primary">save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



