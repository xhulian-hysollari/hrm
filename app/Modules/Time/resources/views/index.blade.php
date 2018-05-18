@extends('layouts.main')
@section('content')
<div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('time.clients.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.time.clients.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>

    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('time.projects.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.time.projects.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('time.time_logs.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.time.time_logs.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


</div>

@endsection