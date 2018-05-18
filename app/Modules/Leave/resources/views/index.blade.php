@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a href="{{route('leave.leave_types.index')}}" class="nav-box">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.leave.leave_types.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
        <a href="{{route('leave.employee_leaves.index')}}" class="nav-box">
            <div class="card-body">
                <blockquote class="card-bodyquote">
            <h2>{{trans('app.leave.employee_leaves.main')}}</h2>
                </blockquote>
            </div>
        </a>
    </div>
        </div>


        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a href="{{route('leave.holidays.index')}}" class="nav-box">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.leave.holidays.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
                <div class="card text-white bg-primary text-center">
                    <a href="{{route('leave.calendar.index')}}" class="nav-box">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h2>{{trans('app.leave.calendar.main')}}</h2>
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