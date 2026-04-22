<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $rutina->nombre}} - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --texto-oscuro: #333;
            --texto-claro: #fff;
            
            /* Colores semánticos para acciones */
            --alerta-editar: #ffc107;
            --peligro-borrar: #dc3545;
        }

        /* 2. REGLAS GLOBALES */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .btn-volver {
            display: inline-block;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 15px;
            transition: color 0.3s;
        }

        .btn-volver:hover {
            color: var(--texto-claro);
            text-decoration: underline;
        }

        /* 3. ENCABEZADO Y BOTONES DE ACCIÓN */
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap; /* En celulares, los botones se bajan si no caben */
            gap: 15px;
            margin-bottom: 10px;
        }

        .rutina-titulo {
            font-size: 32px;
            margin: 0;
            color: var(--texto-claro);
        }

        .acciones-grupo {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-accion {
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            transition: opacity 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-accion:hover {
            opacity: 0.85;
        }

        .btn-editar {
            background-color: var(--alerta-editar);
            color: #333;
        }

        .btn-borrar {
            background-color: var(--peligro-borrar);
            color: white;
        }

        .rutina-desc {
            color: #ddd;
            font-size: 16px;
            margin-top: 5px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* 4. PANEL DE EJERCICIOS (Contraste visual) */
        .panel-ejercicios {
            background-color: var(--bg-claro);
            border-radius: 12px;
            padding: 25px;
            color: var(--texto-oscuro);
        }

        .panel-titulo {
            margin-top: 0;
            margin-bottom: 20px;
            color: var(--bg-oscuro);
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .lista-ejercicios {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .ejercicio-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .ejercicio-nombre {
            margin: 0 0 12px 0;
            color: var(--bg-oscuro);
            font-size: 18px;
        }

        /* Las píldoras de las estadísticas */
        .ejercicio-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap; /* Si hay muchos datos, bajan a la siguiente línea */
        }

        .stat-badge {
            background-color: #f0f0f0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #555;
            border: 1px solid #ddd;
        }

        .stat-badge strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="main-container">
        
        <a href="/rutinas" class="btn-volver">← Volver a mis rutinas</a>
        
        <div class="header-top">
            <h1 class="rutina-titulo">{{$rutina->nombre}}</h1>

            <div class="acciones-grupo">
                <a href="/rutinas/{{ $rutina->id_rutinas }}/edit" class="btn-accion btn-editar">
                    ✏️ Editar
                </a>
                
                <form action="/rutinas/{{ $rutina->id_rutinas}}" method="POST" onsubmit="return confirm('¿Seguro que quieres enviar esta rutina a la papelera? Tienes 30 días para recuperarla.');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-accion btn-borrar">
                        🗑️ Papelera
                    </button>  
                </form>
            </div>
        </div>

        @if($rutina->descripcion)
            <p class="rutina-desc">{{ $rutina->descripcion }}</p>
        @endif

        <div class="panel-ejercicios">
            <h3 class="panel-titulo">Ejercicios en esta rutina ({{ $rutina->ejercicios->count()}})</h3>

            @if ($rutina->ejercicios->isEmpty())
                <p style="color: #666; font-style: italic;">Esta rutina está vacía. Presiona "Editar" para agregarle ejercicios.</p>
            @else
                <ul class="lista-ejercicios">
                    @foreach($rutina->ejercicios as $indice => $item)
                    <li class="ejercicio-card">
                        <h4 class="ejercicio-nombre">
                            {{$indice + 1}}. {{$item->detalleEjercicio->nombre_espanol ?? $item->detalleEjercicio->nombre}}
                        </h4>
                        
                        <div class="ejercicio-stats">
                            <span class="stat-badge"><strong>Series:</strong> {{$item->target_sets}}</span>
                            <span class="stat-badge"><strong>Reps:</strong> {{$item->target_reps}}</span>
                            <span class="stat-badge"><strong>Descanso:</strong> {{$item->rest_seconds}}s</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</body>
</html>