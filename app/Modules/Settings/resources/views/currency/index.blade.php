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
                    <th>{{trans('app.settings.currency.name')}}</th>
                    <th>{{trans('app.settings.currency.contract_type')}}</th>
                    <th>{{trans('app.settings.currency.type')}}</th>
                    <th>{{trans('app.settings.currency.is_cost')}}</th>
                    <th></th>
                </thead>
                <tfoot>
                    <th>
                        <input type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.settings.currency.name')}}"/>
                    </th>
                    <th>
                        {!! Form::select('contract_type_id', $contractTypes, null, ['placeholder' => trans('app.settings.currency.contract_type')]) !!}
                    </th>
                    <th>
                        {!! Form::select('type', salary_component_types(), null, ['placeholder' => trans('app.settings.currency.type')]) !!}
                    </th>
                    <th>
                        {!! Form::select('is_cost', [trans('app.no'), trans('app.yes')], null, ['placeholder' => trans('app.settings.currency.type')]) !!}
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
                {data: 1, name: 'name'},
                {data: 2, name: 'contract_type_id'},
                {data: 3, name: 'type'},
                {data: 4, name: 'is_cost'},
                {data: 5, name: 'actions', sortable: false, searchable: false}
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