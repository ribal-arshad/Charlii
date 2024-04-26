@extends('layouts.master')

@section('title', 'Package List')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Packages</h5>
                <div class="card-body">
                    <form action="{{route('package.add.data')}}" method="POST" id="package">
                            @csrf
                            @include('partials.alert')
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Package Name</label>
                                <input type="text" class="form-control" name="package_name" placeholder="Package Option"/>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Description</label>
                                <textarea type="text" class="form-control" name="description" placeholder="Description"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="required" for="coupon_code">Color</label>
                                <select class="form-control select2" id="search_id" tabindex="1" name="color_id">
                                    @foreach ($color as $colors)
                                        <option value="{{ $colors->id }}">{{ $colors->color }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Price Monthly</label>
                                <input class="form-control {{ $errors->has('price_monthly') ? 'is-invalid' : '' }}" required type="number" aria-valuemax="15,2" name="price_monthly" id="price_monthly" value="{{ old('price_monthly', '') }}" step="0.01">
                            </div>
                            <div class="col-4">
                                <label class="form-label">Yearly Discount</label>
                                <input class="form-control {{ $errors->has('yearly_discount') ? 'is-invalid' : '' }}" type="number" name="yearly_discount" id="yearly_discount" value="{{ old('yearly_discount', 0) }}" step="0.01">
                            </div><br>
                            <div class="col-4">
                                <label class="form-label">Price Yearly</label>
                                <input class="form-control {{ $errors->has('price_yearly') ? 'is-invalid' : '' }}" type="number" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', '') }}" step="0.01"{{ (float)old('yearly_discount', 0) > 0 ? " readonly" : "" }}>

                            </div><br>
                        </div><br>
                        <div class="col-2">
                            <button type="submit" class="btn btn-danger">save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">





</script>


