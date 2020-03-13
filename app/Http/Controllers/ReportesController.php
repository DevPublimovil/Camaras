<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        $name = strtotime(\Carbon\Carbon::now());
        $data = [
            'capturas' => $request->imagenes,
            'descripcion' => $request->descripcion
        ];
        $pdf = \PDF::loadView('reportes.plantillauno', $data);
 
        return $pdf->download($name .'.pdf');
    }
}
