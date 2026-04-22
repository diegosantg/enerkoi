<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Ejercicios - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. Variables de diseño */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --texto-oscuro: #333;
            --texto-claro: #fff;
        }

        /* 2. Estructura general */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        .main-container {
            max-width: 1000px;
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

        .header-section {
            margin-bottom: 25px;
        }

        .header-section h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }

        .header-section p {
            color: #ccc;
            margin: 0;
            font-size: 16px;
        }

        /* 3. Filtros de búsqueda */
        .filtros-card {
            background-color: var(--bg-claro);
            padding: 20px;
            border-radius: 12px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        @media (min-width: 600px) {
            .filtros-card {
                grid-template-columns: 2fr 1fr; 
            }
        }

        .filtro-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
        }

        .filtro-input:focus {
            border-color: var(--azul-boton);
        }

        /* 4. Listado de tarjetas */
        .grid-ejercicios {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .ejercicio-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            color: var(--texto-oscuro);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .ejercicio-nombre {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: var(--bg-oscuro);
            line-height: 1.3;
        }

        .badge-grupo {
            background-color: #e9ecef;
            color: #495057;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            align-self: flex-start;
        }

        /* 5. Estado sin resultados */
        .sin-resultados {
            grid-column: 1 / -1; 
            text-align: center;
            padding: 40px;
            background: rgba(255,255,255,0.05);
            border: 1px dashed rgba(255,255,255,0.2);
            border-radius: 8px;
            color: #ccc;
            font-size: 16px;
        }

        /* 6. Paginación estándar */
        .paginacion-contenedor {
            margin-top: 30px;
            width: 100%;
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        .paginacion-contenedor nav > div:first-child {
            display: none !important;
        }

        .paginacion-contenedor nav > div:last-child,
        .paginacion-contenedor .hidden.sm\:flex-1 {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .paginacion-contenedor p.text-sm {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
            display: block !important;
        }

        .paginacion-contenedor .relative.z-0.inline-flex,
        .paginacion-contenedor ul {
            display: flex;
            margin: 0;
            padding: 0;
            list-style: none;
            border-radius: 4px;
        }

        .paginacion-contenedor .relative.z-0.inline-flex > span,
        .paginacion-contenedor .relative.z-0.inline-flex > a,
        .paginacion-contenedor li {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            background-color: #fff;
            color: #0d6efd;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #dee2e6;
            margin-left: -1px; /* Superpone los bordes para evitar trazos dobles */
        }

        /* Bordes redondeados en los extremos */
        .paginacion-contenedor .relative.z-0.inline-flex > *:first-child,
        .paginacion-contenedor li:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .paginacion-contenedor .relative.z-0.inline-flex > *:last-child,
        .paginacion-contenedor li:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .paginacion-contenedor .relative.z-0.inline-flex > a:hover,
        .paginacion-contenedor a:hover {
            background-color: #e9ecef;
            color: #0a58ca;
        }

        /* Botón de página actual */
        .paginacion-contenedor [aria-current="page"] > span,
        .paginacion-contenedor .active span {
            background-color: #e9ecef !important;
            color: #212529 !important;
            font-weight: bold;
        }

        .paginacion-contenedor svg {
            width: 14px;
            height: 14px;
        }

        /* Botones deshabilitados */
        .paginacion-contenedor span[aria-disabled="true"] span {
            color: #6c757d !important;
            background-color: #fff !important;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .paginacion-contenedor nav > div:last-child {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        
        <a href="/dashboard" class="btn-volver">← Volver al Dashboard</a>
        
        <div class="header-section">
            <h1>Biblioteca de Ejercicios</h1>
            <p>La función de GIF por ejercicio estará disponible pronto.</p>
        </div>

        <form class="filtros-card" method="GET" action="/ejercicios">
            <input type="text" name="buscar" class="filtro-input" placeholder="Buscar ejercicio por nombre..." value="{{ request('buscar') }}">
            
            <select name="grupo" class="filtro-input" onchange="this.form.submit()">
                <option value="todos">Todos los grupos</option>
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id_grupos_musculares }}" {{ request('grupo') == $grupo->id_grupos_musculares ? 'selected' : '' }}>
                        {{ $grupo->nombre_espanol ?? $grupo->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit" style="display: none;"></button>
        </form>

        <div class="grid-ejercicios" id="contenedor_ejercicios">
            
            @forelse($ejercicios as $ejercicio)
                <div class="ejercicio-card">

                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--bg-oscuro), var(--azul-boton)); border-radius: 4px; margin-bottom: 15px; display: flex; justify-content: center; align-items: center; color: rgba(255,255,255,0.2); font-size: 80px;">
                        @php
                            $grupoAnatomico = mb_strtolower($ejercicio->grupoMuscular->nombre_espanol ?? $ejercicio->grupoMuscular->nombre ?? '', 'UTF-8');
                            
                            $esPierna = \Illuminate\Support\Str::contains($grupoAnatomico, ['cuádriceps', 'isquiotibiales', 'pantorrillas', 'glúteos', 'aductores', 'abductores', 'pierna']);
                            $esBrazo  = \Illuminate\Support\Str::contains($grupoAnatomico, ['tríceps', 'bíceps', 'antebrazos', 'deltoides', 'brazo']);
                            $esEspalda = \Illuminate\Support\Str::contains($grupoAnatomico, ['dorsales', 'espalda superior', 'trapecios', 'erectores espinales', 'elevador de la escápula', 'serrato anterior', 'espalda']);
                        @endphp

                        @if($esPierna)
                            🦵
                        @elseif($esBrazo)
                            💪
                        @elseif($esEspalda)
                            🦍
                        @else
                            🏋️‍♂️
                        @endif
                    </div>
                    
                    <h3 class="ejercicio-nombre">
                        {{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }}
                    </h3>
                    
                    <span class="badge-grupo">
                        {{ $ejercicio->grupoMuscular->nombre_espanol ?? $ejercicio->grupoMuscular->nombre }}
                    </span>
                </div>
            @empty
                <div class="sin-resultados" style="display: block;">
                    No se encontraron ejercicios con los parámetros proporcionados.
                </div>
            @endforelse

        </div>

        <div class="paginacion-contenedor">
            {{ $ejercicios->links() }}
        </div>

    </div>
</body>
</html>