@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-4 col-sm-6">
        <div class="card text-white bg-primary text-center">
        <a class="nav-box" href="{{route('pim.employees.index')}}">
            <div class="card-body">
                <blockquote class="card-bodyquote">
            <h2>{{trans('app.pim.employees.main')}}</h2>
                </blockquote>
            </div>
        </a>
    </div>
    </div>

    <div class="col-md-4 col-sm-6">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('pim.candidates.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.pim.candidates.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


    <div class="col-md-4 col-sm-6">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('admin.visitor.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.visitor.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>
</div>



@endsection
@section('additionalCSS')
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection