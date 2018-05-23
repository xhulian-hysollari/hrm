@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('dashboard.documents.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.dashboard.documents.main')}}</h2>
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