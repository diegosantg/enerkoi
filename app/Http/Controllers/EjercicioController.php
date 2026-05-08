<?php
namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\GrupoMuscular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage; // <-- SUPER IMPORTANTE PARA GUARDAR EL GIF

class EjercicioController extends Controller
{
    public function index(Request $request)
    {
        $grupos = GrupoMuscular::all();
        $query = Ejercicio::with('grupoMuscular');

        //Barra de busqueda
        if ($request->filled('buscar')){
            $termino = $request->buscar;
            $query->where(function($q) use($termino){
                $q->where('nombre_espanol', 'LIKE', '%'. $termino . '%')
                ->orWhere('nombre', 'LIKE', '%'.$termino . '%');
            });
        }

        //Filtro muscular
        if ($request->filled('grupo') && $request->grupo != 'todos'){
            $query->where('grupo_muscular_id', $request->grupo);
        }

        $ejercicios = $query->paginate(18)->appends($request->query());

        return view('ejercicios', compact('grupos', 'ejercicios'));
    }

    public function show($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        $huboCambios = false;

        // 1. MAGIA DE RAPIDAPI (Descargar y Guardar el GIF localmente)
        if (is_null($ejercicio->gif_url) && !is_null($ejercicio->api_id)) {
            
            $respuestaGif = Http::withHeaders([
                'x-rapidapi-key' => env('RAPIDAPI_KEY'),
                'x-rapidapi-host' => 'exercisedb.p.rapidapi.com'
            ])->get("https://exercisedb.p.rapidapi.com/image", [
                'exerciseId' => $ejercicio->api_id,
                'resolution' => '180' // <-- AQUÍ SE CONFIGURA LA RESOLUCIÓN
            ]);

            // Verificamos que sea un éxito Y que realmente nos esté devolviendo una imagen
            if ($respuestaGif->successful() && str_contains($respuestaGif->header('Content-Type'), 'image')) {
                
                Storage::disk('public')->makeDirectory('gifs'); // Crea la carpeta por si no existe
                $nombreArchivo = 'gifs/' . $ejercicio->api_id . '.gif';
                
                Storage::disk('public')->put($nombreArchivo, $respuestaGif->body());

                $ejercicio->gif_url = $nombreArchivo;
                $huboCambios = true;
            }
        }
        // 2. MAGIA DE YOUTUBE (Guardar el ID)
        if (is_null($ejercicio->video_youtube)) {
            
            $apiKey = env('YOUTUBE_API_KEY');
            $queryBusqueda = "how to do " . $ejercicio->nombre . " exercise proper form";

            $respuesta = Http::get("https://www.googleapis.com/youtube/v3/search", [
                'part' => 'snippet',
                'q' => $queryBusqueda,
                'type' => 'video',
                'maxResults' => 1,
                'key' => $apiKey
            ]);

            if ($respuesta->successful() && isset($respuesta->json()['items'][0])) {
                $videoId = $respuesta->json()['items'][0]['id']['videoId'];
                $ejercicio->video_youtube = $videoId;
                $huboCambios = true;
            }
        }

        // Guardamos todo de una vez si se descargó algo
        if ($huboCambios) {
            $ejercicio->save();
        }

        return view('detalle-ejercicio', compact('ejercicio'));
    }

    public function obtenerVideoApi($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);

        // Si no tiene video guardado, hacemos la magia de YouTube express
        if (is_null($ejercicio->video_youtube)) {
            $apiKey = env('YOUTUBE_API_KEY');
            $queryBusqueda = "how to do " . $ejercicio->nombre . " exercise proper form";

            $respuestaYt = \Illuminate\Support\Facades\Http::get("https://www.googleapis.com/youtube/v3/search", [
                'part' => 'snippet',
                'q' => $queryBusqueda,
                'type' => 'video',
                'maxResults' => 1,
                'key' => $apiKey
            ]);

            if ($respuestaYt->successful() && isset($respuestaYt->json()['items'][0])) {
                $ejercicio->video_youtube = $respuestaYt->json()['items'][0]['id']['videoId'];
                $ejercicio->save();
            }
        }

        // Devolvemos el ID del video (ya sea el que acabamos de buscar o el que ya estaba guardado)
        return response()->json(['video_youtube' => $ejercicio->video_youtube]);
    }
}