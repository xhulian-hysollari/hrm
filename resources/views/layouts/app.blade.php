<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HRM') }}</title>
    <style>
        .app-header.navbar .navbar-brand {
            background-image: url(http://forcontact.com/wp-content/uploads/2018/01/logo_Forcontact_nuovo_Google-e1516734469445.png) !important;
        }
    </style>
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
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="panel panel-default">
        @yield('content')
    </div></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{asset('old/js/app.js')}}"></script>
<script src="{{asset('vendors/js/jquery.min.js')}}"></script>
<script src="{{asset('vendors/js/popper.min.js')}}"></script>
<script src="{{asset('vendors/js/bootstrap.min.js')}}"></script>
</body>
</html>
