@extends('layouts.app')

@section('styles')
    <style>
        .verpantalla:hover{
            color:#FF3C00;
        }
        .verpantalla{
            cursor: pointer;
        }
        .select{
            border-color: #FF3C00;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content">
        <div class="col-lg-5 col-md-6 col-xs-12 col-12">

        </div>
        <div class="col-lg-7 col-md-6 col-xs-12 col-12">
            <div class="row justify-content-center">
                @foreach ($paises as $pais)
                    <div class="col-lg-2 col-md-2 col-xs-1 col-1">
                        <a href="{{route('pantallas.change')}}"><img src="{{asset($pais->image)}}" width="100%" height="100%" class="rounded-circle" alt="{{$pais->name}}"></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<default-component :screens="{{$screens}}"></default-component>
@endsection