<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Str;
use App\Pantalla;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\Log;

class CaptureCameras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capture:cameras';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Captura fotos de las camaras';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set("max_execution_time", 3600);
        $pantallas = Pantalla::where('country_id',1)->select('name','link')->orderBy('id','ASC')->take(20)->get();

        $ch = curl_init();
            for ($i=0; $i < 80; $i++)
            {
                foreach ($pantallas as $key => $pantalla)
                {
                    $url = 'http://' . $pantalla->link . '/axis-cgi/jpg/image.cgi';
                    $carpeta=  'el_salvador/'.\Carbon\Carbon::now()->locale('es')->isoFormat('dddd').'/'.str_replace([' ','.',','],'_',substr($pantalla->name,9));
                    $imageName = \Carbon\Carbon::now()->format('Y_m_d').strtotime(\Carbon\Carbon::now()).'.jpg';
                    while (@ob_end_clean());
                    header('Content-Type: multipart/x-mixed-replace; boundary=myboundary');
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_USERPWD, 'yoda:iwyoda');
                    $image= curl_exec($ch);
                    if (!curl_errno($ch)) {
                        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                          case 200:  
                                $img = Image::make($image)->encode('jpg',30);
                                Storage::disk('public')->put($carpeta.'/'.$imageName,$img);
                            break;
                          default:
                                Log::info('La pantalla no respondio despues de los 25 segundos: '.$pantalla->name);
                        }
                    }
                }
            }
        curl_close($ch);
        return "se termino con exito";
    }
}
