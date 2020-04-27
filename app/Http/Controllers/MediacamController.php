<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Country;
use Illuminate\Support\Facades\Mail;

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
}
