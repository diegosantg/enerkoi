<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $rutina->nombre}} - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --alerta-editar: #f59e0b; /* Naranja/Ámbar moderno */
            --peligro-borrar: #ef4444; /* Rojo suave nativo */
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

        /* 2. HEADER DE NAVEGACIÓN */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.1s;
        }
        .btn-back:active { transform: scale(0.95); }
        
        .top-nav h1 { margin: 0; font-size: 20px; font-weight: 800; color: var(--texto-oscuro); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;}

        /* 3. TARJETA DE CABECERA (Info y Acciones) */
        .header-card {
            background: var(--blanco); border-radius: 24px; padding: 25px 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
            text-align: center;
        }

        .header-card h2 { margin: 0 0 10px 0; font-size: 26px; font-weight: 800; color: var(--texto-oscuro); }
        .header-card p { margin: 0 0 25px 0; color: var(--texto-gris); font-size: 15px; line-height: 1.5; }

        /* Grid de botones 50/50 */
        .acciones-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
        }

        .btn-accion {
            display: flex; justify-content: center; align-items: center; gap: 8px;
            width: 100%; border: none; border-radius: 16px; padding: 14px;
            font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none;
            transition: transform 0.1s, opacity 0.2s;
        }
        .btn-accion:active { transform: scale(0.97); }
        
        .btn-editar { background-color: rgba(245, 158, 11, 0.1); color: var(--alerta-editar); }
        .btn-borrar { background-color: rgba(239, 68, 68, 0.1); color: var(--peligro-borrar); }

        /* 4. TARJETA DE EJERCICIOS */
        .card-app {
            background: var(--blanco); border-radius: 24px; padding: 25px 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        
        .card-app h3 {
            margin: 0 0 20px 0; font-size: 18px; font-weight: 800;
            color: var(--texto-oscuro); display: flex; align-items: center; justify-content: space-between;
        }

        .badge-count {
            background: var(--bg-app); color: var(--texto-gris); padding: 4px 10px;
            border-radius: 12px; font-size: 13px; font-weight: 700;
        }

        .lista-ejercicios { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px; }

        .ejercicio-item {
            background: var(--bg-app); border-radius: 16px; padding: 18px;
        }

        .ejercicio-item h4 { margin: 0 0 12px 0; color: var(--texto-oscuro); font-size: 16px; font-weight: 700; }

        .ejercicio-stats { display: flex; gap: 8px; flex-wrap: wrap; }

        .stat-badge {
            background: var(--blanco); padding: 8px 12px; border-radius: 10px;
            font-size: 13px; color: var(--texto-gris); font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 5px;
        }
        .stat-badge strong { color: var(--texto-oscuro); }

        /* ESTADO VACÍO */
        .estado-vacio { text-align: center; color: var(--texto-gris); padding: 20px; font-size: 14px; }

        /* 5. SVGs */
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
            <h1>Detalle de Rutina</h1>
        </nav>

        <div class="header-card">
            <h2>{{$rutina->nombre}}</h2>
            @if($rutina->descripcion)
                <p>{{ $rutina->descripcion }}</p>
            @else
                <p style="font-style: italic;">Sin descripción agregada.</p>
            @endif

            <div class="acciones-grid">
                <a href="/rutinas/{{ $rutina->id_rutinas }}/edit" class="btn-accion btn-editar">
                    <svg class="svg-icon" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Editar
                </a>
                
                <form action="/rutinas/{{ $rutina->id_rutinas}}" method="POST" onsubmit="return confirm('¿Seguro que quieres enviar esta rutina a la papelera? Tienes 30 días para recuperarla.');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-accion btn-borrar">
                        <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Papelera
                    </button>  
                </form>
            </div>
        </div>

        <div class="card-app">
            <h3>
                Ejercicios
                <span class="badge-count">{{ $rutina->ejercicios->count()}} en total</span>
            </h3>

            @if ($rutina->ejercicios->isEmpty())
                <div class="estado-vacio">
                    <svg style="width: 48px; height: 48px; stroke: #ccc; fill:none; stroke-width:1.5; margin-bottom: 15px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p>Esta rutina está vacía. Presiona "Editar" para agregarle bloques de entrenamiento.</p>
                </div>
            @else
                <ul class="lista-ejercicios">
                    @foreach($rutina->ejercicios as $indice => $item)
                    <li class="ejercicio-item">
                        <h4>{{$indice + 1}}. {{$item->detalleEjercicio->nombre_espanol ?? $item->detalleEjercicio->nombre}}</h4>
                        
                        <div class="ejercicio-stats">
                            <div class="stat-badge">
                                <svg class="svg-small" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="10" rx="2" ry="2"/><line x1="12" y1="7" x2="12" y2="17"/></svg>
                                <strong>Series:</strong> {{$item->target_sets}}
                            </div>
                            <div class="stat-badge">
                                <svg class="svg-small" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                <strong>Reps:</strong> {{$item->target_reps}}
                            </div>
                            <div class="stat-badge">
                                <svg class="svg-small" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <strong>Desc:</strong> {{$item->rest_seconds}}s
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</body>
</html>