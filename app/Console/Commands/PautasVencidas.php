<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon as Fecha;
use App\Pauta;

class PautasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pautas:vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para eliminar Pautas vencidas';

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
        $day = Fecha::parse(Fecha::now())->subDay()->format('Y-m-d');

        try{
            $pautas = Pauta::where('end_date', $day)->delete();
        }
        catch(Exception $ex)
        {
            Log::info('Ocurrio un error ' . $ex->getMessage());
        }
    }
}
