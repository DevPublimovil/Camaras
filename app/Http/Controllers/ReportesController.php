<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        $paths = [];
        foreach ($request->imagenes as $item){
            $cadena = substr($item,22);
            $paths []= $cadena ;
        }
        $name = strtotime(\Carbon\Carbon::now());
        $data = [
            'capturas' => $paths,
            'descripcion' => $request->descripcion
        ];
        $pdf = \PDF::loadView('reportes.plantillauno', $data)->setPaper('A4', 'landscape');
 
        return $pdf->download($name .'.pdf');
    }
}
