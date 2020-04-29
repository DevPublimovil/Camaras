<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Pantalla;
use App\Country;
use App\PantallaCliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\PautaResource;
use App\Http\Resources\PautaCountryResource as Countries;
use App\Pauta;
use Carbon\Carbon  as Fecha;

class PantallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load('country');
        //verifico si el usuario es cliente
        if($user->role_id == 3)
        {
            //verifico si el usuario tiene pautas activas
            if(count($user->pautas_cliente))
            {
                $paises = PantallaCliente::select('countries.id','countries.name','countries.image')->join('pautas','pautas.id','pantalla_clientes.pauta_id')
                            ->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')
                            ->join('countries','countries.id','pantallas.country_id')
                            ->where('pautas.cliente_id',$user->id)->distinct()->get();
            }else{
                return redirect()->route('mediacam.contacts');
            }
        }else if($user->role_id == 1 || $user->role_id == 6)
        {
            $paises = Country::orderBy('name','ASC')->get();
        }else
        {
            $paises = Country::where('id', $user->country_id)->get();
        }

        if(Auth::user()->hasPermission('view_cameras'))
        {
            return view('pantallas.index', compact('user','paises'));
        }
        else
        {
            return redirect()->route('mediacam.contacts');
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

        $user->update(['fecha_fin' => \Carbon\Carbon::parse($user->fecha_fin)->addDays(5)->format('Y-m-d')]);
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
        //busco el pais1
        $pais = Country::find($id);

        //busco las pantallas de ese pais en relacion al usuario que las solicita

        if(Auth::user()->role_id == 3)
        {
            $pantallas = PantallaCliente::select('pantallas.*')->join('pautas','pautas.id','pantalla_clientes.pauta_id')
                ->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')
                ->join('countries','countries.id','pantallas.country_id')
                ->where('pantallas.country_id',$pais->id)
                ->where('pautas.cliente_id', Auth::id())
                ->distinct()->get();
        }
        else
        {
            $pantallas = Pantalla::where('country_id', $pais->id)->orderBy('name','ASC')->get();
        }
        
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
        $cliente = User::find($id);

        if($request->tiempo_vida > \Carbon\Carbon::now()){
            $cliente->update([
                'fecha_fin' => $request->tiempo_vida
            ]);
            return back()->with('status','Se actualizó correctamente!');
        }else{
            return back()->with('errores','La fecha de vencimiento debe ser mayor al día de hoy ');
        }

        
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
        }else if(Auth::user()->role_id == 1 || $user->role_id == 6){
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

    /* public function imagedownload($id, $fecha){
        $pantalla = Pantalla::find($id);
        $cadena = explode('//',$pantalla->link);
        $url = 'http://'.$cadena[1].'/axis-cgi/jpg/image.cgi?dummy='.$fecha;
        $img = Image::make(file_get_contents($url))->encode('jpg',50);
        $imageName = str_replace([' ','.',','],'',$pantalla->name).'.jpg';
        $headers = [
            'Content-Type' => 'image/jpg',
            'Content-Disposition' => 'attachment; filename='. $imageName.".jpg",
        ];
        return response()->stream(function() use ($img) {
            echo $img;
        }, 200, $headers); 
    } */
}
