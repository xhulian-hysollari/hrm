<div class="form-group">
    {!! Form::label('parent_id', trans('app.settings.forcontact.hq').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('parent_id', $forcontact, null, ['class' => 'form-control projects']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('company_name', trans('app.settings.forcontact.name').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('address', trans('app.settings.forcontact.address').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('website', trans('app.settings.forcontact.website').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('website', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('phone', trans('app.settings.forcontact.phone').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
    </div>
</div>
@include('errors._form-errors')
<hr>
<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{route('settings.companies.index')}}" class="btn btn-default">{{trans('app.cancel')}}</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>