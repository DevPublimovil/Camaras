<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visualizacion;
use \Carbon\Carbon as Fecha;
use Illuminate\Support\Facades\DB;
use App\User;

class VisualizacionesController extends Controller
{

    public function index($date, $country){

        $masvistas = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereDate('visualizacions.created_at',Fecha::now())
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','DESC')
            ->take(10)
            ->get();

        $menosvistas = DB::table('visualizacions')
                ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
                ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
                ->whereDate('visualizacions.created_at',Fecha::now())
                ->where('pantallas.country_id',$country)
                ->groupBy('pantalla','pantallas.acronimo')
                ->orderBy('vistas','ASC')
                ->take(10)
                ->get();

        $fecha = 'Dia: ' . Fecha::now()->locale('es')->isoFormat('LL');
        return view('graficos.index', compact('masvistas','menosvistas','fecha','date','country'));
    }
    

    public function apigrafico(Request $request){
     
       if($request->tipo == 1){
        return $this->rangoFechas($request->fechauno, $request->fechados, $request->pais);
       }else if($request->tipo == 2){
        return $this->compararFechas($request->fechauno, $request->fechados, $request->pais);
       }
    }

    public function graficoDay(Request $request){

    }

    public function graficoMonth($date, $country){
        
        $masvistas = DB::table('visualizacions')
        ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
        ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
        ->whereMonth('visualizacions.created_at',Fecha::now()->month)
        ->where('pantallas.country_id',$country)
        ->groupBy('pantalla','pantallas.acronimo')
        ->orderBy('vistas','DESC')
        ->take(10)
        ->get();

        $menosvistas = DB::table('visualizacions')
                ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
                ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
                ->whereMonth('visualizacions.created_at',Fecha::now()->month)
                ->where('pantallas.country_id',$country)
                ->groupBy('pantalla','pantallas.acronimo')
                ->orderBy('vistas','ASC')
                ->take(10)
                ->get();

        $fecha = 'Mes: ' . Fecha::now()->locale('es')->isoFormat('MM [de] YYYY');
        return view('graficos.index', compact('masvistas','menosvistas','fecha','date','country'));
    }

    public function graficoYear($date, $country){

        $masvistas = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereYear('visualizacions.created_at',Fecha::now()->year)
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','DESC')
            ->take(10)
            ->get();

        $menosvistas = DB::table('visualizacions')
                ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
                ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
                ->whereYear('visualizacions.created_at',Fecha::now()->year)
                ->where('pantallas.country_id',$country)
                ->groupBy('pantalla','pantallas.acronimo')
                ->orderBy('vistas','ASC')
                ->take(10)
                ->get();

        $fecha = 'Año: ' . Fecha::now()->locale('es')->isoFormat('YYYY');
        return view('graficos.index', compact('masvistas','menosvistas','fecha','date','country'));
    }

    public function store(Request $request){
        $cliente = User::find($request->user);

        if($cliente->role_id == 3){
            $user = $request->user;
            $pantalla = $request->mipantalla;

            $vista = Visualizacion::create([
                'user_id' => $user,
                'pantalla_id' => $pantalla,
            ]);
        }
        

        return response()->json('Se guardó con éxito la visualizacón');
    }


    public function rangoFechas($fechauno, $fechados, $country){
        $masvistas = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereBetween('visualizacions.created_at',[$fechauno, $fechados])
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','DESC')
            ->take(10)
            ->get();

        $menosvistas = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereBetween('visualizacions.created_at',[$fechauno, $fechados])
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','ASC')
            ->take(10)
            ->get();
        $date = 0;
        $fecha = '<b>Desde ' . Fecha::parse($fechauno)->locale('es')->isoFormat('DD/MM/YYYY') . ' hasta ' . Fecha::parse($fechados)->locale('es')->isoFormat('DD/MM/YYYY'). '</b>';
        return view('graficos.index', compact('masvistas','menosvistas','fecha','date','country'));
    }

    public function compararFechas($fechauno, $fechados, $country){
        $masvistasUno = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereMonth('visualizacions.created_at',Fecha::parse($fechauno)->month)
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','DESC')
            ->take(10)
            ->get();


        $menosvistasUno = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereMonth('visualizacions.created_at',Fecha::parse($fechauno)->month)
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','ASC')
            ->take(10)
            ->get();

        $masvistasDos = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereMonth('visualizacions.created_at',Fecha::parse($fechados)->month)
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','DESC')
            ->take(10)
            ->get();

        $menosvistasDos = DB::table('visualizacions')
            ->select(DB::raw('count(*) as vistas, pantallas.name as pantalla, pantallas.acronimo'))
            ->join('pantallas','pantallas.id','visualizacions.pantalla_id')
            ->whereMonth('visualizacions.created_at',Fecha::parse($fechados)->month)
            ->where('pantallas.country_id',$country)
            ->groupBy('pantalla','pantallas.acronimo')
            ->orderBy('vistas','ASC')
            ->take(10)
            ->get();

            $date = 0;
            $fecha = '<b>Fecha: ' . Fecha::parse($fechauno)->locale('es')->isoFormat('MM/YYYY') . ' con fecha: ' . Fecha::parse($fechados)->locale('es')->isoFormat('MM/YYYY'). '</b>';
            return view('graficos.index', compact('masvistasUno','menosvistasUno','masvistasDos','menosvistasDos','fecha','date','country'));
    }
}
