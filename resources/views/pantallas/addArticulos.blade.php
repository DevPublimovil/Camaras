@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <agenda-component  :cliente="{{$client}}"></agenda-component>
    {{-- <select-pantalla :articulos="{{$pantallas}}" :cliente="{{$client}}" :user="{{Auth::user()->role_id}}"></select-pantalla>

    @if(isset($articulos))
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-xs-12 col-12">
                <div class="card shadow shadow-lg">
                    <div class="card-header">
                        <strong>Artículos activos del cliente</strong>
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
                                            <button class="btn btn-sm btn-info pull-right" v-on:click="ver('{{$item->id}}','{{$item->link}}')"><i class="fa fa-video-camera" aria-hidden="true"></i> Ver</button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-center">No se encontraron artículos</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
@endsection