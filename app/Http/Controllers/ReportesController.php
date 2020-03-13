<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        $pdf = PDF::loadHtml('hello world');
        return $pdf->output();
    }
}
