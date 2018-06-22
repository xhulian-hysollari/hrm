<meta charset="UTF-8">
<title>Document</title>
<link href="{{asset('vendors/css/flag-icon.min.css')}}" rel="stylesheet">
<link href="{{asset('vendors/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('vendors/css/simple-line-icons.min.css')}}" rel="stylesheet">

<!-- Main styles for this application -->
<link href="{{asset('css/style.css')}}" rel="stylesheet">

<!-- Styles required by this views -->
<link href="{{asset('vendors/css/daterangepicker.min.css')}}" rel="stylesheet">
<link href="{{asset('vendors/css/gauge.min.css')}}" rel="stylesheet">
<link href="{{asset('vendors/css/toastr.min.css')}}" rel="stylesheet">

<style>
    .container{
        margin-top: 20px;
    }
    .card.text-white.bg-primary.text-center a:hover {
        color: white;
    }

    .card.text-white.bg-primary.text-center a {
        color: white !important;
    }
    .card-body:not(.login-card), .card-block {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 140px;
    }

    blockquote {
        margin: 0;
    }
    .app-header.navbar .navbar-brand {
        background-image: url(http://forcontact.com/wp-content/uploads/2018/01/logo_Forcontact_nuovo_Google-e1516734469445.png) !important;
        background-size: 120px auto;
    }
    label{
        margin: .5rem 0 !important;
    }
    .btn {
        margin-top: 10px;
    }
    tr > td:last-child {
        display: flex;
    }
    input[type=text],input[type=search]{
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #3e515b;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e3e8ec;
        border-radius: 0;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .dataTables_filter > label{
        display: flex;
        align-items: center;
    }
    [class*="primary"]{
        background-color: #4379b3 !important;
    }

    .help-block{
        color:#aa5500;
    }
</style>