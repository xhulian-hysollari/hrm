@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary text-center">
                <a class="nav-box" href="{{route('dashboard.documents.index')}}">
                    <div class="card-body">
                        <blockquote class="card-bodyquote">
                            <h2>{{trans('app.dashboard.documents.main')}}</h2>
                        </blockquote>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="custom-panel">
                <div class="custom-panel-heading">{{trans('app.leave.calendar.main')}}</div>
                <div id="leave-calendar"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="custom-panel">
                <div class="custom-panel-heading">{{trans('app.pim.birthdays')}}</div>
                <div id="birthday-calendar"></div>
            </div>
        </div>
    </div>
@endsection
@section('additionalCSS')
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.print.css"
          media='print'>
@endsection
@section('additionalJS')
    <script src="{{asset('vendor/moment/moment.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function () {
            var sources = [];
            $('#leave-calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '{{get_current_date()}}',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                viewRender: function (view, element) {
                    var date = $('#leave-calendar').fullCalendar('getDate');
                    date = moment(date).format('YYYY-MM-DD');
                    if (sources.indexOf(date) == -1) {
                        sources.push(date);
                        $.ajax({
                            url: "{{route('leave.calendar.render')}}",
                            data: {date: date},
                            success: function (events) {
                                $('#leave-calendar').fullCalendar('addEventSource', events);
                            }
                        });
                    }
                }
            });
            var sources = [];
            $('#birthday-calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '{{get_current_date()}}',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                viewRender: function (view, element) {
                    var date = $('#birthday-calendar').fullCalendar('getDate');
                    date = moment(date).format('YYYY-MM-DD');
                    if (sources.indexOf(date) == -1) {
                        sources.push(date);
                        $.ajax({
                            url: "{{route('pim.employees.birthdays')}}",
                            data: {date: date},
                            success: function (events) {
                                $('#birthday-calendar').fullCalendar('addEventSource', events);
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection