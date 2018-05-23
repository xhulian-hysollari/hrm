<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HRM') }}</title>

@include('includes.head')

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body style="z-index:-1;background-color: #f6f6f6">
<div id="app">

    <header class="app-headernavbar">
        <a class="navbar-brand" href="#">
        </a>
    </header>
    @yield('content')

</div>

<!-- Scripts -->
{{--<script src="/js/app.js"></script>--}}

<script src="{{asset('vendors/js/jquery.min.js')}}"></script>
<script src="{{asset('vendors/js/popper.min.js')}}"></script>
<script src="{{asset('vendors/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/pace.min.js')}}"></script>

<!-- Plugins and scripts required by this views -->
<script src="{{asset('vendors/js/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/gauge.min.js')}}"></script>
<script src="{{asset('vendors/js/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/daterangepicker.min.js')}}"></script>
</body>
</html>
