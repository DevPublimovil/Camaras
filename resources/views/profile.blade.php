@extends('layouts.app')

@section('content')
   <div class="container">
       <div class="row justify-content-center">
           <div class="col-lg-8 col-md-8 col-xs-12 col-12">
               <div class="card shadow shadow-lg">
                   <div class="card-header">
                    <h6>  @if(Auth::user()->role_id == 3) <strong>Cliente:</strong> @elseif(Auth::user()->role_id == 5) <strong>Vendedor: </strong> @elseif(Auth::user()->role_id == 4) <strong>Trafico:</strong> @endif {{$user->name}}</h6> 
                   </div>
                   <div class="card-body px-4">
                       <div class="row">
                           <div class="col-lg-6 col-md-6 col-12">
                                <img src="{{asset('storage/'.$user->avatar)}}" class="img-fluid" alt="">
                           </div>
                           <div class="col-lg-6 col-md-6 col-12 ">
                               <p><strong>Correo: </strong>{{$user->email}}</p>
                               <p><strong>País: </strong>{{$user->country->name}}</p>
                            </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection