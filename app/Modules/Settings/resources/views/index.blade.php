@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.companies.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.companies.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.contract_types.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.contract_types.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.document_templates.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.document_templates.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>




    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.education_institutions.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.education_institutions.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.job_positions.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.job_positions.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.languages.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.languages.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>


    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.salary_components.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.salary_components.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>



    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.currency.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>{{trans('app.settings.currency.main')}}</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>



    <div class="col-sm-6 col-md-4">
        <div class="card text-white bg-primary text-center">
            <a class="nav-box" href="{{route('settings.forcontact.index')}}">
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <h2>ForContact</h2>
                    </blockquote>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection