<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Launch_Pack;

class ResetLaunchpacks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-launchpacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar todos los paquetes de lanzamiento de la base de datos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $launchpacks = Launch_Pack::with('menu','user')->get();
        foreach ($launchpacks as $launchpack) {
           $launchpacks->delete();
        }
    }
}
