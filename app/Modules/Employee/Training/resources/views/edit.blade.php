@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.time.time_logs.edit_details')}}</div>
            {!! Form::model($training, ['method' => 'PUT', 'route' => ['admin.training.update', $training->id], 'class' => 'form-horizontal', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])  !!}
                @include('employee.training::_form', ['submitName' => trans('app.submit')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection