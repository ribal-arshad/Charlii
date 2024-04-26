@extends('layouts.master')

@section('title', 'Show Package Options')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Show Package Options</h5>
                    <div class="card-body">
                            @csrf
                            @include('partials.alert')
                            <div class="row">
                                <div class="col-md-9 mb-9">
                                    <label class="form-label">Id</label>
                                    <input class="form-control" name="id" value="{{old('id',$permission->id)}}" placeholder="id"/>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Title</label>
                                    <input class="form-control" name="option_name" value="{{old('option_name',$permission->option_name)}}" placeholder="title"/>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
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
