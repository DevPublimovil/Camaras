@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/publimovil.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('errores'))
                <div class="alert alert-danger">
                    {{ session('errores') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>



    <section class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-uppercase">
                            Editar pautas
                        </div>
                        <div>
                            <span class="badge badge-pill badge-light"><b>Cliente: </b>{{$cliente->name}}</span> 
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    
                    @if (count($pautas)>0)
                        <ul class="list-group m-0">
                            @foreach ($pautas as $pauta)
                                <li class="list-group-item text-xs">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <b>Nombre de la pauta: </b> {{$pauta->titulo}}
                                        </div>
                                        <div>
                                            <span class="badge badge-pill badge-light"><b>Desde:</b> {{\Carbon\Carbon::parse($pauta->start_date)->format('d-m-Y')}}</span>
                                            <span class="badge badge-pill badge-light"><b>Hasta:</b> {{\Carbon\Carbon::parse($pauta->end_date)->format('d-m-Y')}}</span>
                                        </div>
                                    </div>
                                    <p class="m-0"><b>Vendedor: </b>{{$pauta->vendedor->name}}</p><br>

                                    <b>Pantallas:</b>
                                    @if (count($pauta->pantallas)>0)
                                        @foreach ($pauta->pantallas as $pantalla)
                                            <div class="d-flex justify-content-between">
                                                <div class="mt-2">
                                                    {{$pantalla->pantalla->name}}
                                                </div>
                                                <div>
                                                    <a href="#" v-on:click="ver('{{$pantalla->pantalla->id}}','{{$pantalla->pantalla->link}}')" class="mr-4"><i class="fa fa-video-camera" aria-hidden="true"></i> Ver</a>
                                                    <a href="#" class="text-danger" v-on:click="eliminarPantalla({{$pantalla->id}})"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">!Al parecer la pauta no contiene niguna pantalla!</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">¡Al parecer el cliente no tiene pautas activas!, puedes agregarle una <a href="{{route('trafico.show',$cliente->id)}}">aquí</a></p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- 
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-xs-12 col-12">
            <div class="card shadow shadow-lg">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">Editar artículos para {{$user->name}}</div>
                        <div class="col-6"><a href="{{route('trafico.show', $user->id)}}" class="btn btn-sm btn-publimovil pull-right">Agregar</a></div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($articulos)>0)
                    <ul class="list-group">
                        @foreach ($articulos as $item)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-6">{{$item->name}}
                                        <p><small class="text-secondary" style="font-style:italic">agregado: {{$item->created_at}}</small></p>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{route('trafico.destroy', $item->articulo)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger pull-right ml-1"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                        <button class="btn btn-sm btn-primary pull-right" v-on:click="ver('{{$item->id}}','{{$item->link}}')"><i class="fa fa-video-camera" aria-hidden="true"></i> Ver</button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center">No se encontraron artículos</p>
                    @endif
                    <div class="row">
                        <div class="col"><small> <a href="#" data-toggle="modal" data-target="#editclient"><strong>Editar fecha de vencimiento:</strong></a> <span class="text-danger">{{\Carbon\Carbon::parse($user->fecha_fin)->format('d/m/Y')}}<span></small></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- @include('pantallas.editcliente') --}}
@endsection