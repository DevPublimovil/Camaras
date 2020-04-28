<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PantallaCliente;
use Auth;
use App\Pantalla;
use App\User;
use App\Http\Resources\PautaResource;
use App\Http\Resources\PantallaClienteResource;
use \Carbon\Carbon as Fecha;
use App\Pauta;


class PautasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //guardo la pauta con los datos recibidos
        $pauta = Pauta::create([
            'titulo' => $request->titulo,
            'start_date' => Fecha::parse($request->start_date)->format('Y-m-d'),
            'end_date' => Fecha::parse($request->end_date)->format('Y-m-d'),
            'vendedor_id' => Auth::id(),
            'cliente_id' => $request->cliente_id
        ]); 

        //si existen pantallas para agregar a la pauta lo hago a continuacion

        if($request->pantallas != null)
        {
            foreach ($request->pantallas as $key => $pantalla) {
                PantallaCliente::create([
                    'pantalla_id'   => $pantalla,
                    'pauta_id'      => $pauta->id
                ]);
            }
        }

        //si todo ha salido bien podemos terminar retornando

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buscamos la pauta
        $pauta = Pauta::find($id);
        //enviamos las pantallas pertenecientes a la pauta
        $pantallas =  PantallaClienteResource::collection($pauta->pantallas);

        return $pantallas;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //busco la pauta
        $pauta = Pauta::find($id);

        //actualizo la pauta
        $pauta->update([
            'titulo' => $request->titulo,
            'start_date' => Fecha::parse($request->start_date)->format('Y-m-d'),
            'end_date' => Fecha::parse($request->end_date)->format('Y-m-d'),
            'vendedor_id' => Auth::id(),
            'cliente_id' => $request->cliente_id
        ]);

        //elimino todas las pantallas no deseadas para la pauta
        foreach ($request->pantallas as $key => $value) {
            $pauta->pantallas()->where('pantalla_id', '!=', $value)->delete();
        }
        
        //agrego las nuevas pantallas siempre y cuando estas no se repitan ya que la pauta es unica
        foreach ($request->pantallas as $key => $item) {
            $pantalla = PantallaCliente::firstOrCreate([
                'pantalla_id'   => $item,
                'pauta_id'      => $pauta->id
            ]);
        }


        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //busco la pauta y la elimino
        $pauta = Pauta::find($id);
        $pauta->delete();

        return;
    }

    public function listpautas($id)
    {
        //busco el cliente
        $cliente = User::find($id);

        //verifico que rol es el usuario autenticado, si es admin o trafico puede ver todas las pautas que el cliente tiene
        if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
        {
            //obtengo todas las pautas del cliente
            $query = $cliente->pautas_cliente()->orderBY('created_at','DESC')->get();
        }else //si no solo puede ver las pautas que el ha creado para el cliente
        {
            $query = $cliente->pautas_cliente()->where('vendedor_id',Auth::id())->orderBY('created_at','DESC')->get();
        }

        //retorno las pautas
        return PautaResource::collection($query);
    }
}
