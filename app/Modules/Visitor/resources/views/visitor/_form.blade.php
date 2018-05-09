<div class="form-group">
    {!! Form::label('name', trans('app.visitor.name').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('id_card', trans('app.visitor.id_card').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('id_card', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('attendee', trans('app.visitor.attendee').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('attendee', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('visit_date', trans('app.visitor.visit_date').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('datetime-local', 'visit_date', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('check_in', trans('app.visitor.check_in').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('datetime-local', 'check_in', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('check_out', trans('app.visitor.check_out').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('datetime-local', 'check_out', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('motive', trans('app.visitor.motive').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('motive', null, ['class' => 'form-control']) !!}
    </div>
</div>
@include('errors._form-errors')
<hr>
<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{route('visitor.index')}}" class="btn btn-default">{{trans('app.cancel')}}</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>