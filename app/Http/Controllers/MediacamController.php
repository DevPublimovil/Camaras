<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Country;
use Illuminate\Support\Facades\Mail;
use App\Hzip;
use Carbon\Carbon as Fecha;

class MediacamController extends Controller
{
    public function profile(){
        //busca el usuario y muestra el perfil
        $user = User::find(Auth::user()->id)->load('country');

        return view('profile',compact('user'));
    }

    public function contactos(){
        //busca el usuario y su pais
        $user = User::find(Auth::user()->id);
        $pais = Country::find($user->country_id);

        return view('contacts', compact('user','pais'));
    }

    public function contactar(Request $request){
        // verifica que tipo de usuario es
        if(Auth::user()->role_id == 3){
            $tipo = "cliente";
        }else if(Auth::user()->role_id == 4){
            $tipo = "Trafico";
        }else if(Auth::user()->role_id == 5){
            $tipo = "Vendedor";
        }else if(Auth::user()->role_id == 6){
            $tipo = "Vendedor Regional";
        }else if(Auth::user()->role_id == 1){
            $tipo = "Admin";
        }
        //detalles del mensaje
        $usuario = $request->nombre;
        $asunto = 'Mensaje de '.$tipo.' : '.$usuario.' desde Mediacam';

        $empresa = $request->empresa;
        $pais = $request->pais;
        $contenido = $request->mensaje;
        //envia el mensaje y lo adjunta a la vista mails.notification que se encuentra en resources/views/
        Mail::send('emails.notificacion',[
            'usuario' => $usuario,
            'empresa' => $empresa,
            'pais' => $pais,
            'contenido' => $contenido], function($mail) use ($asunto){
                $mail->from(Auth::user()->email, 'Mediacam');
                $mail->to('mediacam@grupopublimovil.com');
                $mail->subject($asunto);

        });
        //retorna un mensaje de confirmacion de que el mensaje ha sido enviado
        return back()->with('status','Su mensaje se envio con éxito');
    }

    public function index(){
        return 'ok';
    }
//para cerrar session del usuario
    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('inicio');
    }

    public function downloadBackup(Request $request)
    {
        $dir = $request->day;
        
       foreach ($dir as $key => $value) {
            $path = public_path('/storage/el_salvador/' . $value);
            $namezip = 'backup.zip';
            $destino = public_path('/storage/uploads/' . $namezip);

            Hzip::zipDir($path, $destino);
       }
        
    
        return response()->download($destino)->deleteFileAfterSend(true);
    }

    public function listDays()
    {
        $country = Auth::user()->country_id;
        switch ($country) {
            case 1:
                $dir = 'el_salvador';
                break;
            case 2:
                $dir = 'guatemala';
                break;
            case 3:
                $dir = 'costa_rica';
                break;
            case 4:
                $dir = 'honduras';
                break;
            case 5:
                $dir = 'panama';
                break;
            case 6:
                $dir = 'nicaragua';
                break;
            
            default:
                $dir = 'el_salvador';
                break;
        }
        $directory =  public_path('/storage/' . $dir);
        $directories = array_slice(scandir($directory), 2);
        return $directories;
    }
}
