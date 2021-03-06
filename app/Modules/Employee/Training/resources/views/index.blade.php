@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{route('admin.training.create')}}"
               class="btn btn-primary pull-right">{{trans('app.training.add_new')}}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">{{trans('app.training.training_list')}}</div>
                <table class="table table-bordered table-hover" id="trainingTable">
                    <thead>
                    <th>{{trans('app.id')}}</th>
                    <th>{{trans('app.training.name')}}</th>
                    <th>{{trans('app.training.location')}}</th>
                    <th>{{trans('app.training.date')}}</th>
                    <th>{{trans('app.training.notes')}}</th>
                    <th></th>
                    </thead>
                    <tfoot>
                    <th>
                        <input type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.training.name')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.training.location')}}"/>
                    </th>
                    <th>
                        <input type="date" placeholder="{{trans('app.time.time_logs.date')}}"/>
                    </th>
                    <th></th>
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
        $(document).ready(function () {
            var table = $('#trainingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.training.datatable")}}',
                columns: [
                    {data: 0, name: 'id'},
                    {data: 1, name: 'name'},
                    {data: 3, name: 'location'},
                    {data: 4, name: 'training_date', sortable: true, searchable: true},
                    {data: 5, name: 'notes'},
                    {data: 10, name: 'actions', sortable: false, searchable: false}
                ]
            });
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
                $('select', this.footer()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });
    </script>
@endsection