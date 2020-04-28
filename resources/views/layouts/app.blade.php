<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'MediaCam') }}</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        <style>
            .content-wrapper{
                background-color:#FFFFFF;   
            }
        </style>
        <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
        <style>
            body{
                font-family: 'Poppins', sans-serif;
            }
            .loader-bg{
                position: fixed;
                z-index: 35;
                background-color: #fff;
                width: 100%;
                height: 100%;
            }
            .loader{
                border: 0 solid transparent;
                border-radius: 50%;
                width: 150px;
                height: 150px;
                position: absolute;
                top: calc(50vh - 75px);
                left: calc(50vw - 75px)
            }
            .loader:before, .loader:after{
                content: '';
                border: 1em solid #ff5733;
                border-radius: 50%;
                width: inherit;
                height: inherit;
                position: absolute;
                top: 0;
                left: 0;
                animation: loader 2s linear infinite;
                opacity: 0;

            }
            .loader:before{
                animation-delay: .5s;
            }
            @keyframes loader{
                0%{
                    transform: scale(0);
                    opacity: 0;
                }
                50%{
                    opacity: 1;
                }
                100%{
                    transform: scale(1);
                    opacity: 0;
                }
            }
        </style>
        @yield('styles')
    </head>
    <body class="hold-transition @guest login-page  @else sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse @endguest">
        @guest
            @yield('content')
        @else
        <div class="loader-bg">
            <div class="loader"></div>
        </div>
            <div class="wrapper" id="app">
                @include('layouts.header')
                @include('layouts.menu')

                <div class="content-wrapper" style="padding-top:20px;padding-bottom:20px;">
                    
                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">
                            @yield('content')
                        </div><!-- /.container-fluid -->
                    </section>
                </div>
                <modal-camera></modal-camera>
            </div>
        @endguest

       <script src="{{asset('js/app.js')}}"></script>
       <script src="{{asset('js/adminlte.min.js')}}"></script>
       <script>
            setTimeout(function() {
                $('.loader-bg').fadeToggle();
            },2000);
        </script>
       <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
       <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
       @yield('scripts')
    </body>
</html>
