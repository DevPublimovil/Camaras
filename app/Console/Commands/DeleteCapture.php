<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
Use App\Country;
use Storage;
use Illuminate\Support\Facades\Log;

class DeleteCapture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capture:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para eliminar las capturas de un dia';

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
        $dir = \Carbon\Carbon::now()->subDays(4)->locale('es')->isoFormat('dddd');
        $countries = Country::get();
        foreach ($countries as $country) {
            $path = str_replace(' ','_',strtolower($country->name)).'/'.$dir;
            if(Storage::disk('public')->exists($path)):
                Storage::disk('public')->deleteDirectory($path);
            else:
                Log::info('El directorio que intentastes borrar no existe, Dir: ' . $path );
            endif;
        }
    }
}
