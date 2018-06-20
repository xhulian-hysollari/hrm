@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="{{route('settings.currency.create')}}" class="btn btn-primary pull-right">{{trans('app.settings.currency.add_new')}}</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{trans('app.settings.currency.main')}}</div>
            <table class="table table-bordered table-hover" id="positionsTable">
                <thead>
                    <th>{{trans('app.id')}}</th>
                    <th>{{trans('app.settings.currency.code')}}</th>
                    <th>{{trans('app.settings.currency.display')}}</th>
                    <th></th>
                </thead>
                <tfoot>
                    <th>
                        <input class="form-control" type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th>
                        <input class="form-control" type="text" placeholder="{{trans('app.settings.currency.code')}}"/>
                    </th>
                    <th>
                        <input class="form-control" type="text" placeholder="{{trans('app.settings.currency.display')}}"/>
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
        var table = $('#positionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("settings.currency.datatable")}}',
            columns: [
                {data: 0, name: 'id'},
                {data: 1, name: 'currency_code'},
                {data: 2, name: 'currency_display'},
                {data: 3, name: 'actions', sortable: false, searchable: false}
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