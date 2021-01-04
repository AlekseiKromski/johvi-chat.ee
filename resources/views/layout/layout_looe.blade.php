<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Looe chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="{{asset('chat/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('chat/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('chat/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="dark" data-layout="horizontal">

@yield('content')

<!-- JAVASCRIPT -->
<script src="{{asset('chat/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('chat/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('chat/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('chat/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('chat/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('chat/js/app.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
