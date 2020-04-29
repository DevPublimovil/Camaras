@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('js/aos.css') }}">
    <style>
        @media screen and (min-width: 745px) {
            #circuito{
                border-right:#FF3C00 1px solid;
            }
        }

        #modal-link{
            z-index: 4000;
        }
        .verpantalla, .img-cameras{
            cursor: pointer;
        }
        .verpantalla:hover{
            color: #FF3C00;
        }
        a> .cameras{
                -webkit-animation-name: example;
                -webkit-animation-duration: 4s;
                animation-name: example;
                animation-duration: 4s;
                animation-iteration-count: infinite;
                }

                @-webkit-keyframes example {
                from {box-shadow: 0px 10px 15px 0px #FF3C00;}
                to {box-shadow: 0px 2px 2px 0px #FF3C00;}
                }

                @keyframes example {
                from {box-shadow: 0px 2px 2px 0px #FF3C00;}
                to {box-shadow: 0px 10px 15px 0px #FF3C00;}
        }
        a > .cameras:hover{
            transform:scale(0.8);
            -ms-transform:scale(0.8); 
            -moz-transform:scale(0.8); 
            -webkit-transform:scale(0.8);
            -o-transform:scale(0.8); 
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')

     {{--    @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 5 )
            <trafico-component :user="{{$user}}"  :pantallas="{{$pantallas}}"></trafico-component>
        @elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 1 || Auth::user()->role_id == 6) --}}
            <client-component :user="{{$user}}" :paises="{{$paises}}"></client-component>

        <canvas id="canvas" width="800" height="450" style="display:none"></canvas>
@endsection

@section('scripts')
    <script src="{{ asset('js/aos.js') }}"></script>
    <script>
         AOS.init({
            duration: 800,
            easing: "ease-in-out"
        });
    </script>
@endsection