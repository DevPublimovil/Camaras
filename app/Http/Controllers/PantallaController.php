<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Pantalla;
use App\Country;
use App\PantallaCliente;
use Illuminate\Support\Facades\DB;

class PantallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->fecha_fin <= \Carbon\Carbon::now() && Auth::user()->role_id == 3){
            $user = User::find(Auth::user()->id);
            $user->update(['status' => 'no-activo']);
            return redirect()->route('mediacam.contacts');
        }
        //verifica si el usuario tiene los permisos
       if(Auth::user()->hasPermission('view_cameras' && Auth::user()->status == 'activo')){
           //busca el usuario y su pais
           $user = User::find(Auth::user()->id)->load('country');

           //verifica si el usuario tiene el rol de cliente
           if($user->role_id == 3){
               //lista los paises en donde el cliente tiene articulos
                $paises = PantallaCliente::select('countries.id','countries.name','countries.image')
                ->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')
                ->join('countries','countries.id','pantallas.country_id')
                ->where('pantalla_clientes.user_id',$user->id)
                ->where('pantallas.status','disponible')
                ->groupBy('countries.id','countries.name','countries.image')
                ->get();
            //lista los articulos
                $pantallas = PantallaCliente::select('pantallas.*')
                    ->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')
                    ->where('pantalla_clientes.user_id',$user->id)
                    ->where('pantallas.country_id',$user->country->id)
                    ->get();
                return view('pantallas.index', compact('user','paises','pantallas'));
                //verifica si el usuario es trafico
           }else if($user->role_id == 4 || $user->role_id == 5){
               $pantallas = Pantalla::where('country_id',Auth::user()->country_id)->orderBy('name','ASC')->get();
               return view('pantallas.index', compact('pantallas','user'));
               //verifica si el usuario es administrador
           }else if($user->role_id == 1 || $user->role_id == 6){
                $paises = Country::orderBy('name','ASC')->get();
                
                $pantallas = Pantalla::select('pantallas.*')
                    ->where('pantallas.country_id',$user->country->id)
                    ->get();
                
                return view('pantallas.index', compact('user','pantallas','paises'));
           }
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
         
        $user = User::find($request->cliente);
        if($user->status == 'no-activo'){
            $user->update(['status' => 'activo']);
        }

        $user->update(['fecha_fin' => \Carbon\Carbon::now()->addDays(5)->format('Y-m-d')]);
        // guardar los articulos para el cliente
        foreach ($request->pantallas as $pantalla) {
            $busqueda = Pantalla::where('name',$pantalla)->first();
            $articulo= PantallaCliente::firstOrCreate(['pantalla_id' => $busqueda->id, 'user_id' => $request->cliente]);
        }

       return 'ok';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        
    }

    public function changescren(Request $request){
        $id = $request->pais;
        //buscar el usuario
        $user  = User::find(Auth::user()->id);
        //buscar el pais 
        $pais = Country::find($id);

        //verifico si el usuario tiene el rol de cliente
        if(Auth::user()->role_id == 3){

            //lista todos los articulos del cliente
            $pantallas = PantallaCliente::select('pantallas.*')
            ->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')
            ->where('pantalla_clientes.user_id',$user->id)
            ->where('pantallas.country_id',$pais->id)
            ->where('pantallas.status','disponible')
            ->get();

            // retorno el pais y sus articulos
            return response()->json([
                'pais' => $pais,
                'pantallas' => $pantallas
            ]);
            //verifico si el usuario es administrador
        }else if(Auth::user()->role_id == 1){
            // lista las pantallas del pais
            $pantallas = Pantalla::select('pantallas.*')
                ->where('pantallas.country_id',$pais->id)
                ->get();
            
            return response()->json([
                'pais' => $pais,
                'pantallas' => $pantallas
            ]);
        }

        
    }
}
