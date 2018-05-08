@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="{{route('pim.employees.create')}}" class="btn btn-primary pull-right">{{trans('app.pim.employees.add_new')}}</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.pim.employees.documents.add_new')}}</div>
            {!! Form::open(['route' => ['pim.employees.upload'], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {!! Form::label('attachment', trans('app.pim.employees.documents.attachment'), ['class' => 'col-sm-3']) !!}
                <div class="col-sm-6">
                    {!! Form::input('file', 'attachment', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <a href="{{route('pim.employees.documents.index', Route::input('employeeId'))}}" class="btn btn-default">{{trans('app.cancel')}}</a>
                    {!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.pim.employees.main')}}</div>
            <table class="table table-bordered table-hover" id="employeesTable">
                <thead>
                    <th>{{trans('app.id')}}</th>
                    <th>{{trans('app.pim.employees.first_name')}}</th>
                    <th>{{trans('app.pim.employees.last_name')}}</th>
                    <th>{{trans('app.pim.employees.email')}}</th>
                    <th></th>
                </thead>
                <tfoot>
                    <th>
                        <input type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.pim.employees.first_name')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.pim.employees.last_name')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.pim.employees.email')}}"/>
                    </th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('additionalCSS')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
@endsection
@section('additionalJS')
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        var table = $('#employeesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("pim.employees.datatable")}}',
            columns: [
                {data: 0, name: 'id'},
                {data: 1, name: 'first_name'},
                {data: 2, name: 'last_name'},
                {data: 3, name: 'email'},
                {data: 4, name: 'actions', sortable: false, searchable: false}
            ]
        });
        table.columns().every(function () {
            var that = this;
            $('input', this.footer()).on( 'keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });
</script>
@endsection