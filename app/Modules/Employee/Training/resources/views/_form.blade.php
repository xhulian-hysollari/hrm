<div class="form-group">
    {!! Form::label('name', trans('app.training.name').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('attachment', trans('app.pim.employees.documents.attachment'), ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('file', 'attachment', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('location', trans('app.training.location').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('location', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('notes', trans('app.training.notes').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('users', trans('app.training.participants'), ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('users[]', $users, null, ['class' => 'form-control projects', 'multiple']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('training_date', trans('app.time.time_logs.date').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('date', 'training_date', null, ['class' => 'form-control']) !!}
    </div>
</div>
@include('errors._form-errors')
<hr>
<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{route('admin.training.index')}}" class="btn btn-default">{{trans('app.cancel')}}</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
@section('additionalCSS')
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection
@section('additionalJS')
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    $(".projects").select2();
</script>
@endsection