@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.training.add_new')}}</div>
            {!! Form::open(['route' => 'admin.training.store', 'class' => 'form-horizontal' , 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                @include('employee.training::_form', ['submitName' => trans('app.submit')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection