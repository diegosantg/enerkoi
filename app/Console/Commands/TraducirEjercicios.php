<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ejercicio;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TraducirEjercicios extends Command
{
    // nombre del comando lol
    protected $signature = 'enerkoi:traducir';
    protected $description = 'Traduce los nombres de los ejercicios de inglés a español';

    public function handle()
    {
        // Configuramos el traductor: De Inglés ('en') a Español ('es')
        $traductor = new GoogleTranslate('es', 'en');

        //Buscamos los ejercicios que aún no tienen traducción
        $ejercicios = Ejercicio::whereNull('nombre_espanol')->get();

        $total = $ejercicios->count();
        
        if ($total == 0) {
            $this->info('¡Todos los ejercicios ya están traducidos!');
            return;
        }

        $this->info("Iniciando traducción de $total ejercicios. Esto tomará un par de minutos...");

        //Empezamos una barra de progreso visual en la terminal
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($ejercicios as $ejercicio) {
            try {
                // Traducimos el nombre
                $traduccion = $traductor->translate($ejercicio->nombre);
                
                // Lo guardamos en la base de datos
                $ejercicio->update(['nombre_espanol' => $traduccion]);
                
                //para que Google no nos bloquee por hacer peticiones muy rápido
                usleep(500000); 

            } catch (\Exception $e) {
                // Si hay un error con un nombre raro, lo ignoramos y seguimos con el siguiente
                continue;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('¡Traducción completada con éxito!');
    }
}