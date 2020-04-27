<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pantalla;
use Auth; 
use App\User;
use DataTables;
use App\Http\Requests\StoreClientRequest;
use App\Country;
use App\PantallaCliente;
use App\Venta;
use App\Pauta;

class TraficoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        //verifica si el usuario tiene el permiso
       if(Auth::user()->hasPermission('list_clients')){
           //busca los paises y retorna la vista
            $paises = Country::orderBy('name','ASC')->get();
            return view('pantallas.traficoindex',compact('paises'));
       }else{
           return back();
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //metodo que retorna la informacion para la datatable de la lista de usuarios 
        // junto con las acciones necesarias
        if(Auth::user()->hasPermission('list_clients')){
            return DataTables::of(User::where('country_id',Auth::user()->country_id)->where('role_id',3))
            ->addColumn('actions', function($row){
                $addArticle = route('trafico.show', $row->id);
                $deleteClient = route('trafico.destroy', $row->id);
                $editClient = route('trafico.edit', $row->id);
                return view('pantallas.partials.actiontrafico', compact('addArticle', 'deleteClient','editClient'));
            })
            ->make(true);
        }else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $fechafin = \Carbon\Carbon::now()->addDay($request->tiempo_vida)->format('Y-m-d');
        
        //verifica si el usuario tiene permiso y guarda el cliente
       if(Auth::user()->hasPermission('store_clients')){
            $cliente = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
                'role_id' => $request->role_id,
                'country_id' => Auth::user()->country_id,
                'fecha_fin' => $fechafin,
            ]);

            return back()->with('status','Se agrego con éxito el cliente ' . $cliente->name );
       }else{
           return back();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::find($id);
        return view('pantallas.addArticulos',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //busca el usuario y su pais junto con los articulos del cliente
        $cliente= User::find($id)->load('country');

        $pautas = Pauta::where('cliente_id', $cliente->id)->orderBy('created_at','DESC')->with(['pantallas' => function($query){
            $query->with(['pantalla:id,name,link'])->get();
        }])->get();
            
        return view('pantallas.editArticulos',compact('cliente','pautas'));
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
        //busca el articulo y lo elimina del cliente
        $articulo = PantallaCliente::find($id);
        $articulo->delete();

        return;
    }
}
