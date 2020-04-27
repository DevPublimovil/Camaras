<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use Auth;
use App\Country;
use DataTables;
use App\User;
use \Carbon\Carbon as Fecha;
use Illuminate\Support\Facades\Mail;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = Country::orderBy('name','ASC')->get();
        return view('ventas.index', compact('paises'));
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
        $fechafin = Fecha::now()->addDay($request->tiempo_vida)->format('Y-m-d');
        $user = User::where('email',$request->email)->first();
        if($user)
        {
            $cliente_venta = Venta::where('cliente_id',$user->id)->first();
            if($cliente_venta)
            {
                return back()->with('warning', '¡Ya posees un cliente en tu lista con el correo ingresado!');
            }else{
                $venta = Venta::create([
                    'cliente_id' => $user->id,
                    'vendedor_id' => Auth::id()
                ]);
                return back()->with('status', 'El email ingresado ya existia, se agregó a tu lista de clientes');
            }
        }else{
            $cliente = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
                'role_id' => $request->role_id,
                'country_id' => ($request->country_id) ? $request->country_id : Auth::user()->country_id,
                'fecha_fin' => $fechafin,
            ]);

            $venta = Venta::create([
                'cliente_id' => $cliente->id,
                'vendedor_id' => Auth::id()
            ]);
        
            $this->enviarCredenciales($cliente, $request->password);

            return back()->with('status','El cliente fue creado correctamente!');
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
        //
    }

    public function apiventas()
    {
        if(Auth::user()->hasPermission('list_clients_ventas'))
        {
            $query = Venta::where('vendedor_id',Auth::id())->with(['user' => function ($consulta){
                $consulta->with('country:id,name');
            }]);
            return DataTables::of($query)
                    ->addColumn('actions', function($row){
                        $addArticle = route('trafico.show', $row->cliente_id);
                        $deleteClient = route('trafico.destroy', $row->cliente_id);
                        $editClient = route('trafico.edit', $row->cliente_id);
                        return view('pantallas.partials.actiontrafico', compact('addArticle', 'deleteClient','editClient'));
                    })
                    ->make(true);
        }else{
            abort(403);
        }
    }

    public function enviarCredenciales($cliente, $password)
    {
        //creamos el asunto del correo
        $asunto = 'credenciales para cliente ' . $cliente->name;

        //creamos el correo
        Mail::send('emails.credencialescliente',[
            'cliente' => $cliente,
            'password' => $password], function($mail) use ($asunto){
                $mail->from('mediacam@grupopublimovil.com', 'Mediacam');
                $mail->to(Auth::user()->email);
                $mail->subject($asunto);

        });
    }
}
