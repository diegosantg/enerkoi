<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Rutinas - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased; 
        }

        .app-container {
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
            padding-bottom: 80px;
        }

        /* 2. HEADER DE NAVEGACIÓN (Estilo App) */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.1s;
        }
        .btn-back:active { transform: scale(0.95); }
        
        .top-nav h1 { margin: 0; font-size: 24px; font-weight: 800; color: var(--texto-oscuro); }

        /* 3. BOTÓN PRINCIPAL (Crear Nueva Rutina) */
        .btn-crear {
            display: flex; justify-content: center; align-items: center; gap: 10px;
            width: 100%; background: var(--verde-exito); color: var(--blanco);
            border: none; border-radius: 20px; padding: 18px; font-size: 16px; font-weight: 800;
            text-decoration: none; box-shadow: 0 8px 20px rgba(40, 167, 69, 0.2);
            margin-bottom: 30px; transition: transform 0.1s;
        }
        .btn-crear:active { transform: scale(0.97); }

        /* 4. LISTA Y TARJETAS DE RUTINAS */
        .lista-rutinas {
            display: flex; flex-direction: column; gap: 15px;
        }

        .tarjeta-rutina {
            background: var(--blanco); border-radius: 24px; padding: 20px;
            text-decoration: none; color: var(--texto-oscuro); display: flex;
            justify-content: space-between; align-items: center;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); transition: transform 0.2s, box-shadow 0.2s;
        }
        .tarjeta-rutina:active { transform: scale(0.98); background: #f9fafb; }

        .rutina-info { flex: 1; }
        .rutina-info h3 { margin: 0 0 6px 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro); }
        .rutina-info p { margin: 0 0 12px 0; color: var(--texto-gris); font-size: 14px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .badge-ejercicios {
            background: var(--bg-app); color: var(--texto-gris); padding: 6px 12px;
            border-radius: 12px; font-size: 12px; font-weight: 700; 
            display: inline-flex; align-items: center; gap: 6px;
        }

        .icon-arrow { color: #ccc; font-size: 24px; font-weight: bold; margin-left: 15px; }

        /* 5. ESTADO VACÍO (Empty State) */
        .estado-vacio {
            background: var(--blanco); border-radius: 24px; padding: 40px 20px;
            text-align: center; color: var(--texto-gris); box-shadow: 0 6px 15px rgba(0,0,0,0.03);
        }
        .estado-vacio h3 { margin: 0 0 5px 0; font-size: 18px; color: var(--texto-oscuro); }
        .estado-vacio p { margin: 0; font-size: 14px; }

        /* 6. SVGs GLOBALES */
        .svg-icon { width: 20px; height: 20px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .svg-small { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/dashboard" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Mis Rutinas</h1>
        </nav>

        <a href="/rutinas/crear" class="btn-crear">
            <svg class="svg-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Diseñar Nueva Rutina
        </a>

        @if($rutinas->isEmpty())
            <div class="estado-vacio">
                <svg style="width: 48px; height: 48px; stroke: #ccc; fill:none; stroke-width:1.5; margin-bottom: 15px;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                <h3>Lista vacía</h3>
                <p>¡Anímate a armar tu primera rutina de entrenamiento!</p>
            </div>
        @else
            <div class="lista-rutinas">
                @foreach($rutinas as $rutina)
                <a href="/rutinas/{{$rutina->id_rutinas}}" class="tarjeta-rutina">
                    <div class="rutina-info">
                        <h3>{{$rutina->nombre}}</h3>
                        @if($rutina->descripcion)
                            <p>{{$rutina->descripcion}}</p>
                        @endif
                        <span class="badge-ejercicios">
                            <svg class="svg-small" viewBox="0 0 24 24"><path d="M18 10h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"/><path d="M2 10h3v4H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Z"/><path d="M5 8h3v8H5Z"/><path d="M16 8h3v8h-3Z"/><path d="M8 11h8v2H8Z"/></svg>
                            {{$rutina->ejercicios->count()}} ejercicios
                        </span>
                    </div>
                    <div class="icon-arrow">›</div>
                </a>
                @endforeach
            </div>
        @endif
        
    </div>
</body>
</html>