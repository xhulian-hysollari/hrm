@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a href="{{route('recruitment.reports.index')}}" class="nav-box">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.recruitment.reports.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection