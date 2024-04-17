<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Marker;


class ResetMarkers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-markers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reiniciar el número de personas que no comen en los marcadores de la base de datos.';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        $markers = Marker::all();
        foreach ($markers as $marker) {
            $marker->num_people_not_eat = $marker->num_people;
            $marker->save();
        }
    } 
}
