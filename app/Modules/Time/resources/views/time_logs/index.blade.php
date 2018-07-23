@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="{{route('time.time_logs.create')}}" class="btn btn-primary pull-right">{{trans('app.time.time_logs.add_new')}}</a>
        <a href="{{route('time.time_logs.salary_report')}}" class="btn btn-default pull-right">{{trans('app.pim.employees.salaries.salary_report')}}</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.pim.employees.documents.add_new')}}</div>
            {!! Form::open(['route' => ['time.time_logs.upload'], 'class' => 'form-horizontal row', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group col-md-6">
                {!! Form::label('attachment', trans('app.pim.employees.documents.attachment'), ['class' => 'col-sm-3']) !!}
                <div class="col-sm-12">
                    {!! Form::input('file', 'attachment', null ) !!}
                </div>
            </div>
            <div class="form-group col-md-6" style="display: flex; align-items: flex-end; justify-content: flex-end;">
                <div>
                    <a href="{{route('pim.employees.documents.index', Route::input('employeeId'))}}" class="btn btn-default">{{trans('app.cancel')}}</a>
                    {!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.time.time_logs.main')}}</div>
            <div class="form-group clearfix">
                <form method="get" class="row" id="date_filter" action="">
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="date_start" placeholder="{{trans('app.time.time_logs.start_date')}}" required/>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="date_end" placeholder="{{trans('app.time.time_logs.end_date')}}" required/>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary" style="margin-top: 0;">{{trans('app.filter')}}</button>
                    </div>
                </form>
            </div>
            <hr>
            <table class="table table-bordered table-hover" id="timeLogTable">
                <thead>
                    <th>{{trans('app.time.time_logs.employee')}}</th>
                    <th>{{trans('app.time.time_logs.time')}}</th>
                </thead>
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
        var table = $('#timeLogTable').DataTable({
            // processing: true,
            // serverSide: true,
            ajax: '{{ route("time.time_logs.datatable")}}',
            columns: [
                {data: 0, name: 'user_id', sortable: false, searchable: false},
                {data: 1, name: 'time', sortable: true, searchable: false}
            ]
        });

        table.columns().every(function () {
            var that = this;
            $('input', this.header()).on( 'keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
            $('select', this.header()).on( 'change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

        $('#date_filter').submit(function() {
            var url = '{{ route("time.time_logs.datatable")}}?date_from='+$('#date_start').val()+'&date_to='+$('#date_end').val();
            table.ajax.url(url);
            table.draw();
            var dateFilter = '?date_from='+$('#date_start').val()+'&date_to='+$('#date_end').val();
            $('#timeLogTable .employeeLog').each(function() {
                $(this).attr('href', $(this).data('url')+dateFilter);
                console.log($(this));
            })
            return false;
        });
    });
</script>
@endsection