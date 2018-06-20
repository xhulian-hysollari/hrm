@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.pim.employees.edit_details')}}
                <a href="{{route('pim.employees.resend_password', $employee->id)}}" class="btn btn-default pull-right">{{trans('app.pim.employees.resend_password')}}</a>
            </div>
            {!! Form::model($employee, ['method' => 'PUT', 'route' => ['pim.employees.update', $employee->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                @include('pim::employees._form', ['submitName' => trans('app.submit')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.pim.employees.additional')}}</div>
            <div class="clearfix row">
                <div class="col-md-4 col-sm-6">
                    <div class="card text-white bg-primary text-center">
                        <a class="nav-box" href="{{route('pim.employees.social_media.index', $employee->id)}}">
                            <div class="card-body">
                                <blockquote class="card-bodyquote">
                                    <h2>{{trans('app.pim.employees.external_accounts.main')}}</h2>
                                </blockquote>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card text-white bg-primary text-center">
                        <a class="nav-box" href="{{route('pim.employees.contact_details.index', $employee->id)}}">
                            <div class="card-body">
                                <blockquote class="card-bodyquote">
                                    <h2>{{trans('app.pim.employees.contact_details.main')}}</h2>
                                </blockquote>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                                <div class="card text-white bg-primary text-center">
                                    <a class="nav-box" href="{{route('pim.employees.qualifications.index', $employee->id)}}">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <h2>{{trans('app.pim.employees.qualifications.main')}}</h2>
                                            </blockquote>
                                        </div>
                                    </a>
                                </div>
                            </div>
                <div class="col-md-4 col-sm-6">
                                <div class="card text-white bg-primary text-center">
                                    <a class="nav-box" href="{{route('pim.employees.salaries.index', $employee->id)}}">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <h2>{{trans('app.pim.employees.salaries.main')}}</h2>
                                            </blockquote>
                                        </div>
                                    </a>
                                </div>
                            </div>

                <div class="col-md-4 col-sm-6">
                                    <div class="card text-white bg-primary text-center">
                                        <a class="nav-box" href="{{route('pim.employees.documents.index', $employee->id)}}">
                                            <div class="card-body">
                                                <blockquote class="card-bodyquote">
                                                    <h2>{{trans('app.pim.employees.documents.main')}}</h2>
                                                </blockquote>
                                            </div>
                                        </a>
                                    </div>
                                </div>
            </div>
        </div>
    </div>
</div>
@endsection