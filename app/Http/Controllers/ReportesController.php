<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        //print_r($request->all());
        $name = strtotime(\Carbon\Carbon::now());
        $data = [
            'capturas' => $request->imagenes,
            'marca' => $request->marca,
            'descripcion' => $request->descripcion
        ];
        $pdf = \PDF::loadView('reportes.plantillauno', $data)->setPaper('A4', 'landscape');
 
        return $pdf->download($name .'.pdf');
    }
}
