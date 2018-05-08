@extends('layouts.main_reception')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.visitor.edit_details')}}</div>
            {!! Form::model($visitor, ['method' => 'PUT', 'route' => ['visitor.update', $visitor->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                @include('visitor::visitor._form', ['submitName' => trans('app.submit')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection