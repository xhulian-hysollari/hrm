@extends ('layouts.main_employee')

@section('content')<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Parse Primis for IQOS</div>
            {!! Form::open(['route' => ['iqos.parse'], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {!! Form::label('attachment', trans('app.pim.employees.documents.attachment'), ['class' => 'col-sm-3']) !!}
                <div class="col-sm-6">
                    {!! Form::input('file', 'attachment', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    {!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection