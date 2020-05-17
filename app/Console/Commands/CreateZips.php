<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Hzip;
use Carbon\Carbon as Fecha;
use Illuminate\Support\Facades\Log;

class CreateZips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea carpetas zip para las capturas';

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
        //extiendo el tiempo de ejecucion
        ini_set("max_execution_time", 3600);

        //strtolower(str_replace([' ','.',','],'_',$country->name))

        //defino un array con las carpetas
        $folders = ['el_salvador','honduras','nicaragua','guatemala'];

        //defino el nombre del dia actual
        $day = Fecha::now()->subDay()->locale('es')->isoFormat('dddd');

        //recorro el array de folders
        for($i = 0; $i < count($folders); $i++){
            //concateno las variables para buscar el directorio
            $folder = $folders[$i] . '/' . $day;
            //defino el origen de los archivos para el zip

            $origin = public_path('/storage/' . $folder);

            //defino un nombre para el zip
            $namezip = $folders[$i] . '_' . $day . '.zip';

            //defino el destino para el zip
            $destination = public_path('/storage/uploads/' . $namezip);

            //verifico si la ruta existe
            $exists = Storage::disk('public')->exists($folder);

            if($exists)
            {
                Hzip::zipDir($origin, $destination);
            }else{
                Log::info('La carpeta no existe ' . $folder);
            }
        }
    }
}
