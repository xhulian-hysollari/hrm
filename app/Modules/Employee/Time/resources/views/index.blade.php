@extends('layouts.main_employee')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="{{route('employee.time.create')}}" class="btn btn-primary pull-right">{{trans('app.time.time_logs.add_new')}}</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.time.time_logs.main')}}</div>
            <table class="table table-bordered table-hover" id="timeLogTable">
                <thead>
                    <th>{{trans('app.id')}}</th>
                    <th>{{trans('app.time.time_logs.time')}}</th>
                    <th>{{trans('app.time.time_logs.date')}}</th>
                    <th>Reason</th>
                    <th></th>
                </thead>
                <tfoot>
                    <th>
                        <input type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th></th>
                    <th>
                        <input type="date" placeholder="{{trans('app.time.time_logs.date')}}"/>
                    </th>
                    <th>
                        Reason
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
        var table = $('#timeLogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("employee.time.datatable")}}',
            columns: [
                {data: 0, name: 'id'},
                {data: 1, name: 'time', sortable: true, searchable: false},
                {data: 2, name: 'date'},
                {data: 3, name: 'reason'},
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
            $('select', this.footer()).on( 'change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });
</script>
@endsection