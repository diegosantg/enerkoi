<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DescargarGifsEjercicios extends Command
{
    // Le agregamos una opción "--limite" por seguridad. Por defecto bajará de 50 en 50.
    protected $signature = 'gifs:descargar {--limite=50}';
    
    protected $description = 'Descarga masivamente los GIFs de RapidAPI a tu servidor local';

    public function handle()
    {
        $limite = $this->option('limite');

        // Buscamos ejercicios que SÍ tengan ID de API pero que NO tengan GIF guardado
        $ejercicios = Ejercicio::whereNotNull('api_id')
                                ->whereNull('gif_url')
                                ->take($limite)
                                ->get();

        if ($ejercicios->isEmpty()) {
            $this->info('¡Todos los ejercicios ya tienen su GIF descargado!');
            return;
        }

        $this->info("Comenzando la descarga de {$ejercicios->count()} GIFs...");
        
        // Creamos una barra de progreso visual en la terminal
        $bar = $this->output->createProgressBar($ejercicios->count());
        $bar->start();

        Storage::disk('public')->makeDirectory('gifs');

        foreach ($ejercicios as $ejercicio) {
            try {
                $respuestaGif = Http::withHeaders([
                    'x-rapidapi-key' => env('RAPIDAPI_KEY'),
                    'x-rapidapi-host' => 'exercisedb.p.rapidapi.com'
                ])->get("https://exercisedb.p.rapidapi.com/image", [
                    'exerciseId' => $ejercicio->api_id,
                    'resolution' => '180'
                ]);

                if ($respuestaGif->successful() && str_contains($respuestaGif->header('Content-Type'), 'image')) {
                    $nombreArchivo = 'gifs/' . $ejercicio->api_id . '.gif';
                    Storage::disk('public')->put($nombreArchivo, $respuestaGif->body());

                    $ejercicio->gif_url = $nombreArchivo;
                    $ejercicio->save();
                }
            } catch (\Exception $e) {
                $this->error("\nError en ID: " . $ejercicio->api_id);
            }

            $bar->advance();

            // ⏱️ PAUSA DE 1 SEGUNDO (CRÍTICO)
            // Si no ponemos esto, RapidAPI nos bloquea por hacer muchas peticiones por segundo
            sleep(1); 
        }

        $bar->finish();
        $this->info("\n¡Lote descargado con éxito!");
    }
}