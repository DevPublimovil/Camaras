@extends('layouts.app')
    
@section('styles')
    <style>
        body{
            background-color:#4A4A4A;
            color: #FFFFFF;
        }
        .text-publimovil{
            color: #FF3C00;
        }
        .content-wrapper{
            background-color:#4A4A4A;
        }
        .main-header{
            background-color:#4A4A4A;
            color:#FFFFFF;
        }
        .border-white{
            border-color:#4A4A4A!important;
        }
        #user-name, .fa-bars{
            color: #FFFFFF;
        }
        .input-contact{
            border-radius:8px;
            background-color: #4A4A4A;
            color: #FFFFFF;
        }
        .input-contact:focus{
            background-color: #4A4A4A;
            color: #FFFFFF;
            border-color:#FF3C00;
        }
        label{
            color:#FFFFFF
        }
        .title-contact{
            color: #FF3C00;
        }
        .btn-contact{
            background-color: #FF3C00;
            color: #FFFFFF;
        }
        .btn-contact:hover{
            color: #FBA795;
        }
        .cursor-pointer{
           cursor: pointer;
        }
        .fill-orange-hover:hover{
            fill: #F2921E;
        }
        .fillactive{
            fill: #F2921E;
        }
        .active-country{
            fill: #F2921E;
        }
        a{
            text-decoration: none;
            color:#FFFFFF;
        }
        a:hover{
            color: #FFFFFF
        }
    </style>
@endsection

@section('content')
        <div class="row justify-content-center">
            <div class="col-10">
                @if (session('status'))
                    <div class="alert alert-success" style="background-color: #FF3C00;border-color:#FF3C00">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
        @if(Auth::user()->status == 'no-activo')
        <div class="row justify-content-center">
            <div class="col-10">
                    <div class="alert alert-warning" >
                        ¡Por el momento no tienes pautas activas. Escríbenos Para contratar nuestros servicios o para notificar algún problema!
                    </div>
            </div>
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-12  col-xs-12 col-12">
                <h1 class="font-weight-bold title-contact">Escríbenos</h1>
                <form action="{{route('mediacam.contacto')}}"  method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control input-contact" id="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input type="text" name="empresa" class="form-control input-contact" id="empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" name="pais" class="form-control input-contact" id="pais" value="{{$pais->name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">Mensaje</label>
                        <textarea name="mensaje" class="form-control input-contact" id="mensaje" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-contact">Enviar</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 col-md-5 offset-1">
                <contact-map></contact-map>
            </div>
        </div>
@endsection

@section('scripts')
   <script src="{{asset('js/paises.js')}}"></script>
@endsection