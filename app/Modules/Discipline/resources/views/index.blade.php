@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <div class="card-body">
                    <a class="nav-box" href="{{route('discipline.disciplinary_cases.index')}}">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.discipline.disciplinary_cases.main')}}</h2>
                        </blockquote>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionalCSS')
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection