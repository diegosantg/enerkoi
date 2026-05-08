<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelera - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --verde-exito: #28a745;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --rojo-papelera: #ef4444;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased;
        }

        /* 2. CONTENEDOR MÓVIL */
        .app-container { 
            max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px; 
        }

        /* 3. HEADER DE NAVEGACIÓN */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.1s;
        }
        .btn-back:active { transform: scale(0.95); }
        .top-nav h1 { margin: 0; font-size: 24px; font-weight: 800; }

        /* 4. TARJETA DE AVISO (Info Box) */
        .aviso-card {
            background: rgba(107, 114, 128, 0.1); border-radius: 16px; padding: 16px;
            color: var(--texto-gris); font-size: 14px; margin-bottom: 25px; line-height: 1.4;
            display: flex; gap: 12px; align-items: flex-start;
        }

        /* 5. LISTA DE RUTINAS EN PAPELERA */
        .grid-rutinas {
            display: flex; flex-direction: column; gap: 15px;
        }

        .rutina-card {
            background: var(--blanco); border-radius: 24px; padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; flex-direction: column; gap: 15px;
            /* Efecto visual de "Desactivado/Borrado" */
            filter: grayscale(80%) opacity(0.85); 
            transition: filter 0.2s, transform 0.1s;
        }
        .rutina-card:active { transform: scale(0.98); filter: grayscale(0%) opacity(1); }

        .rutina-header {
            display: flex; flex-direction: column; gap: 5px;
        }
        
        .rutina-nombre {
            margin: 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro);
            text-decoration: line-through; text-decoration-color: rgba(31, 41, 55, 0.3);
        }

        .rutina-fecha {
            font-size: 13px; color: var(--rojo-papelera); font-weight: 700;
            display: flex; align-items: center; gap: 5px;
        }

        .rutina-desc {
            margin: 0; font-size: 14px; color: var(--texto-gris); line-height: 1.4;
        }

        /* 6. BOTÓN DE RESTAURAR */
        .btn-restaurar {
            width: 100%; background: var(--verde-exito); color: var(--blanco);
            border: none; padding: 16px; border-radius: 16px; font-weight: 800; font-size: 15px;
            display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2); transition: transform 0.1s;
        }
        .btn-restaurar:active { transform: scale(0.97); }

        /* 7. ESTADO VACÍO */
        .sin-resultados { 
            text-align: center; padding: 50px 20px; color: var(--texto-gris); 
            background: var(--blanco); border-radius: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .sin-resultados h2 { margin: 0 0 5px 0; font-size: 20px; font-weight: 800; color: var(--texto-oscuro); }
        .sin-resultados p { margin: 0; font-size: 14px; }
        
        /* 8. SVGs GLOBALES */
        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .svg-small { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/rutinas" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Papelera</h1>
        </nav>

        <div class="aviso-card">
            <svg class="svg-icon" style="flex-shrink: 0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>Las rutinas eliminadas se purgarán permanentemente de la base de datos después de 30 días.</div>
        </div>

        <div class="grid-rutinas">
            @forelse($rutinas as $rutina)
                <div class="rutina-card">
                    <div class="rutina-header">
                        <h3 class="rutina-nombre">{{ $rutina->nombre }}</h3>
                        <span class="rutina-fecha">
                            <svg class="svg-small" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Eliminada {{ $rutina->deleted_at->diffForHumans() }}
                        </span>
                    </div>

                    @if($rutina->descripcion)
                        <p class="rutina-desc">
                            {{ Str::limit($rutina->descripcion, 60, '...') }}
                        </p>
                    @endif

                    <form action="{{ route('rutinas.restaurar', $rutina->id_rutinas) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-restaurar">
                            <svg class="svg-icon" style="width: 20px; height: 20px;" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                            Restaurar Rutina
                        </button>
                    </form>
                </div>
            @empty
                <div class="sin-resultados">
                    <svg style="width: 48px; height: 48px; stroke: #cbd5e1; fill:none; stroke-width:1.5; margin-bottom: 15px;" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    <h2>Papelera vacía</h2>
                    <p>No hay rutinas eliminadas recientemente.</p>
                </div>
            @endforelse
        </div>

    </div>
</body>
</html>