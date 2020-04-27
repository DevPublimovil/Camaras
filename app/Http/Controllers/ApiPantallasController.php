<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PantallaCliente;
use Auth;
use App\Pantalla;
use App\User;
use App\Http\Resources\PantallasResource;

class ApiPantallasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
        {
            $pantallas = Pantalla::select('id','name')->orderBy('country_id','ASC')->get();
        }else
        {
            $pantallas = Pantalla::select('id','name')->where('country_id',Auth::user()->country_id)->orderBy('name','ASC')->get();
        }

        return $pantallas;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listpantallas(){
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 1)
        {
            $pantallas = Pantallas::select('id','name')->orderBy('name','ASC')->get();
        }else{
            $pantallas = Pantalla::select('id','name')->where('country_id',Auth::user()->country_id)->orderBy('name','ASC')->get();
        }

        return $pantallas;
    }
}
