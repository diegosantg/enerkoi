<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }} - Enerkoi</title>
    <style>
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; padding: 20px; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased;
        }

        .app-container { max-width: 600px; margin: 0 auto; padding-bottom: 40px; }

        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            text-decoration: none;
        }

        .ejercicio-header h1 { margin: 0 0 5px 0; font-size: 24px; font-weight: 800; text-transform: capitalize; }
        .tag-grupo { 
            display: inline-block; background: rgba(24, 119, 242, 0.1); color: var(--azul-boton); 
            padding: 6px 12px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; text-transform: capitalize;
        }

        .video-container {
            position: relative; width: 100%; padding-bottom: 56.25%; /* Ratio 16:9 */
            height: 0; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: #000; margin-bottom: 25px;
        }
        .video-container iframe {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;
        }

        .card-descripcion {
            background: var(--blanco); padding: 20px; border-radius: 24px; box-shadow: 0 6px 15px rgba(0,0,0,0.03);
            margin-bottom: 20px;
        }
        .card-descripcion h3 { margin: 0 0 10px 0; font-size: 18px; font-weight: 800; }
        .card-descripcion p { margin: 0; font-size: 15px; line-height: 1.6; color: var(--texto-gris); }

        .gif-container {
            width: 100%; background: var(--blanco); border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin-bottom: 25px;
            display: flex; justify-content: center; align-items: center;
            overflow: hidden; padding: 15px; box-sizing: border-box;
        }
        .gif-container img {
            width: 100%; max-width: 320px; height: auto; border-radius: 16px;
        }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/ejercicios" class="btn-back">
                <svg style="width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
        </nav>

        <div class="ejercicio-header">
            <h1>{{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }}</h1>
            <div class="tag-grupo">{{ $ejercicio->grupoMuscular->nombre_espanol ?? $ejercicio->grupoMuscular->nombre ?? 'General' }}</div>
        </div>

        @if($ejercicio->gif_url)
            <div class="gif-container">
                <img src="{{ asset('storage/' . $ejercicio->gif_url) }}" 
                     alt="Animación de {{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }}"
                     loading="lazy">
            </div>
        @endif

        @if($ejercicio->video_youtube)
            <h4 style="margin-bottom: 10px; margin-top: 0; font-size: 15px; color: var(--texto-gris);">Tutorial detallado:</h4>
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/{{ $ejercicio->video_youtube }}?rel=0" allowfullscreen loading="lazy"></iframe>
            </div>
        @else
            @if(!$ejercicio->gif_url)
                <div class="card-descripcion" style="text-align: center; margin-bottom: 20px; background: #fee2e2; color: #ef4444;">
                    <p>No se encontraron recursos visuales para este ejercicio.</p>
                </div>
            @endif
        @endif

        <div class="card-descripcion">
            <h3>Instrucciones</h3>
            <p>{{ ucfirst($ejercicio->descripcion) ?? 'Agrega este ejercicio a tus rutinas para dominar la técnica.' }}</p>
        </div>

    </div>
</body>
</html>