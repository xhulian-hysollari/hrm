<div class="form-group">
    {!! Form::label('name', trans('app.settings.currency.code').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('currency_code', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', trans('app.settings.currency.display').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('currency_display', null, ['class' => 'form-control']) !!}
    </div>
</div>
@include('errors._form-errors')
<hr>
<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{route('settings.currency.index')}}" class="btn btn-default">{{trans('app.cancel')}}</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>