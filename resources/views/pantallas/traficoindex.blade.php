@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/publimovil.css')}}">
@endsection

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
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10 col-12">
           <div class="card shadow shadow-lg">
               <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 col-sm-8 col-xs-8 col-8">
                        <h6>Listado de clientes</h6>
                    </div>
                    <div class="col-lg-6 col-sm-4 col-xs-4 col-4">
                        <button type="button" class="btn btn-sm btn-publimovil pull-right" data-toggle="modal" data-target="#addclient">Nuevo cliente</button>
                    </div>
                </div>
               </div>
               <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table id="clients_table" class="table text-center table-sm display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Fecha de ingreso</th>
                                <th>Opcion</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
               </div>
           </div>
        </div>
    </div>
    @include('addclients')
@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#clients_table').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Clientes",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontro el cliente",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },

                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('trafico.create') }}',
                "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "created_at" },
                { "data": "actions"},
                ]
            });

            @if($errors->any())
                $("#addclient").modal("show");
            @endif
        } );
    </script>
@endsection