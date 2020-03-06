<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Str;
use App\Pantalla;
use Illuminate\Support\Facades\Storage;
use Image;

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
            for ($i=0; $i < 60; $i++)
            {
                foreach ($pantallas as $key => $pantalla)
                {
                    $cadena = explode('//',$pantalla->link);
                    $url = 'http://' . $cadena[1] . '/axis-cgi/jpg/image.cgi';
                    $carpeta= str_replace([' ','.',','],'_',$pantalla->name);
                    $imageName = Str::random(20).'.jpg';
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    $image = curl_exec($ch);
                    $info = curl_getinfo($ch);
                    
                    if(!empty($image))
                    {
                        $img = Image::make($image)->encode('jpg',30);
                        Storage::disk('public')->put('/Capturas/'.$carpeta.'/'.$imageName,$img);
                    }
                }
            }
        curl_close($ch);
        return "se termino con exito";
    }
}
