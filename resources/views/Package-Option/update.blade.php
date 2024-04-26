@extends('layouts.master')

@section('title', 'Edit Package Option')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Edit Package Option</h5>
                    <div class="card-body">
                        <form action="{{route('Package.option.update.data',$permission->id)}}" method="post">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-9">
                                    <label class="form-label">Option Name</label>
                                    <input type="text" class="form-control" name="option_name" value="{{old('option_name',$permission->option_name)}}"  placeholder=""/>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" >SAVE</button>
                                    <a href="{{route('Package.option')}}" class="btn btn-danger redirect-btn">Back TO List</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
