<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class CamaraController extends Controller
{
    public function vercamara($ip)
    {

        //comsumir camara
        header('Content-Type: multipart/x-mixed-replace; boundary=myboundary');
        while (@ob_end_clean());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://{$ip}/axis-cgi/mjpg/video.cgi");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_USERPWD, 'yoda:iwyoda');
        $output = curl_exec($ch);
        curl_close($ch);

        if(!$output){
            $path = public_path('images/noavailable.png');
            $image = Image::make($path)->encode();
            return $image;
        }
    }
}
