@extends('layouts.main_reception')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.visitor.add_new')}}</div>
            {!! Form::open(['route' => 'visitor.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                @include('visitor::visitor._form', ['submitName' => trans('app.submit')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection