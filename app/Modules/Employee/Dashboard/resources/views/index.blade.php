@extends('layouts.main_employee')
@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.leaves.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.leave.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.time.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.time.time_logs.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.time.report')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.time.time_logs.report')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.salary.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.employee.salary.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.training.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.employee.training.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.documents.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.employee.documents.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('employee.documents.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.pim.employees.documents.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">{{trans('app.dashboard.documents.main')}}</div>
                <table class="table table-bordered table-hover" id="dashboardDocumentsTable">
                    <thead>
                    <th>{{trans('app.id')}}</th>
                    <th>{{trans('app.dashboard.documents.name')}}</th>
                    <th></th>
                    </thead>
                    <tfoot>
                    <th>
                        <input type="text" placeholder="{{trans('app.id')}}"/>
                    </th>
                    <th>
                        <input type="text" placeholder="{{trans('app.dashboard.documents.name')}}"/>
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
        $(document).ready(function () {

            var table = $('#dashboardDocumentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("employee.dashboard_documents.datatable")}}',
                columns: [
                    {data: 0, name: 'id'},
                    {data: 1, name: 'name'},
                    {data: 2, name: 'actions', sortable: false, searchable: false}
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

            $('#dashboardDocumentsTable').removeClass('dataTable');
        });
    </script>
@endsection