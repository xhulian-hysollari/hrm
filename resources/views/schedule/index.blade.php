@extends ('layouts.main_employee')

@section('content')
    <table id="scheduleTable" class="table-striped">
        <thead>

        <tr>
            <th style="display: none">Id</th>
            <th style="padding: 8px 10px">{{trans('app.pim.employees.main')}}</th>
            {{--@for ($i = 0; $i < 7; $i++)--}}
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(0)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(1)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(2)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(3)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(4)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(5)->format('D, d M Y')}}</th>
            <th style="padding: 8px 10px">{{\Carbon\Carbon::parse('next monday')->addDays(6)->format('D, d M Y')}}</th>
            {{--@endfor--}}
        </tr>
        </thead>
        <tfoot>
        <th style="display: none"></th>
        <th style="padding: 8px 10px">
            <input class="form-control" type="text" placeholder="{{trans('app.visitor.name')}}"/>
        </th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        <th style="padding: 8px 10px"></th>
        </tfoot>
    </table>
@endsection
@section('additionalCSS')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('css/wickedpicker.css')}}">
    <style>
        ul.wickedpicker__controls {
            display: flex;
            align-items: center;
            font-size: large;
        }

        .wickedpicker__controls__control--separator {
            margin: inherit;
        }

        li.wickedpicker__controls__control {
            display: flex;
            flex-direction: column;
        }
        /*td{*/
            /*display: flex;*/
            /*align-items: center;*/
        /*}*/
    </style>
@endsection
@section('additionalJS')
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('js/wickedpicker.js')}}"></script>

    <script>
        function bootApp() {
            let date = $('.date');
            date.daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            date.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'))
            });
            $('.date-parent-start').on('apply.daterangepicker', function (ev, picker) {
                $('.start-child').val(picker.startDate.format('YYYY-MM-DD'))
            });
            $('.date-parent-end').on('apply.daterangepicker', function (ev, picker) {
                $('.end-child').val(picker.startDate.format('YYYY-MM-DD'))
            });
            date.on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            let time = $('.time');
            time.wickedpicker({
                now: '09:00',
                twentyFour: true,
                upArrow: 'fa fa-arrow-up',
                downArrow: 'fa fa-arrow-down',
                close: 'wickedpicker__close',
                hoverState: 'hover-state',
                title: 'Timepicker',
                showSeconds: false,
                minutesInterval: 30,
                beforeShow: null,
                show: null,
                clearable: false
            });

            $('#auto_start_frame').on('change', function () {
                $('.start-frame-child').val($(this).val())
            });
            $('#auto_end_frame').on('change', function () {
                $('.end-frame-child').val($(this).val())
            });
        }

        $(document).ready(function () {
            var table = $('#scheduleTable').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ajax: '{{ route("schedule.datatable")}}',
                columns: [
                    {data: 0, name: 'id', visible: false},
                    {data: 3, name: 'full_name'},
                    {data: 4, name: 'time_monday', sortable: false, searchable: false},
                    {data: 5, name: 'time_tuesday', sortable: false, searchable: false},
                    {data: 6, name: 'time_wednesday', sortable: false, searchable: false},
                    {data: 7, name: 'time_thursday', sortable: false, searchable: false},
                    {data: 8, name: 'time_friday', sortable: false, searchable: false},
                    {data: 9, name: 'time_saturday', sortable: false, searchable: false},
                    {data: 10, name: 'time_sunday', sortable: false, searchable: false}
                ],
                initComplete: function (settings, json) {
                    bootApp();
                }
            });
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        })
        ;
    </script>
@endsection