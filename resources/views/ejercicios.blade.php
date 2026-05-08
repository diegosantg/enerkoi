<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --bg-oscuro: #2c336b; 
            --bg-gradiente: linear-gradient(135deg, #3b4282, #1877f2);
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased; 
        }

        .app-container { max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px; }

        /* 2. HEADER DE NAVEGACIÓN (Estilo App) */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.1s;
        }
        .btn-back:active { transform: scale(0.95); }
        .top-nav h1 { margin: 0; font-size: 24px; font-weight: 800; }
        .header-desc { color: var(--texto-gris); font-size: 14px; margin-top: 0; margin-bottom: 25px; line-height: 1.4; padding-left: 5px; }

        /* 3. FILTROS BÚSQUEDA (Inputs flotantes) */
        .filtros-card {
            background: var(--blanco); padding: 20px; border-radius: 24px;
            display: grid; grid-template-columns: 1fr; gap: 15px; margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }

        @media (min-width: 500px) {
            .filtros-card { grid-template-columns: 2fr 1fr; }
        }

        .filtro-input {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s;
        }
        .filtro-input:focus { border-color: var(--azul-boton); }
        
        /* Ajuste nativo para el select en móviles */
        select.filtro-input { 
            appearance: none; -webkit-appearance: none; 
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'/%3e%3c/svg%3e"); 
            background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; 
            padding-right: 45px; cursor: pointer;
        }

        /* 4. GRID Y TARJETAS DE EJERCICIO */
        .grid-ejercicios { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; }

        .ejercicio-card {
            background: var(--blanco); border-radius: 24px; padding: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.04); display: flex; flex-direction: column;
            justify-content: space-between; transition: transform 0.2s;
            text-decoration: none; 
            color: var(--texto-oscuro);
        }
        .ejercicio-card:active { transform: scale(0.98); }

        .img-placeholder {
            width: 100%; height: 160px; background: var(--bg-gradiente);
            border-radius: 16px; margin-bottom: 15px; display: flex;
            justify-content: center; align-items: center; color: rgba(255,255,255,0.3);
            box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden; /* Importante para que el GIF no se salga de los bordes redondeados */
        }
        
        /* Estilo para la miniatura del GIF */
        .img-preview {
            width: 100%; height: 100%; object-fit: cover; background-color: var(--blanco);
        }

        .svg-ejercicio { width: 65px; height: 65px; stroke: currentColor; stroke-width: 1.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }

        .ejercicio-nombre { margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: var(--texto-oscuro); line-height: 1.3; }
        .badge-grupo {
            background: var(--bg-app); color: var(--texto-gris); padding: 6px 12px;
            border-radius: 12px; font-size: 12px; font-weight: 700; display: inline-block; align-self: flex-start;
        }

        /* 5. ESTADOS VACÍOS */
        .sin-resultados {
            grid-column: 1 / -1; text-align: center; padding: 50px 20px; 
            color: var(--texto-gris); background: var(--blanco); 
            border-radius: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.04); 
        }

        /* 6. PAGINACIÓN ESTILO APP */
        .paginacion-contenedor { margin-top: 30px; width: 100%; }
        .paginacion-contenedor nav > div:first-child { display: none !important; }
        
        .paginacion-contenedor nav > div:last-child { 
            display: flex !important; flex-direction: column; gap: 15px; align-items: center; 
        }
        
        .paginacion-contenedor p.text-sm { color: var(--texto-gris); font-size: 14px; margin: 0; font-weight: 600; }
        
        .paginacion-contenedor .relative.z-0.inline-flex { 
            display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin: 0; padding: 0; border: none; box-shadow: none; 
        }
        
        .paginacion-contenedor .relative.z-0.inline-flex > span, 
        .paginacion-contenedor .relative.z-0.inline-flex > a {
            display: inline-flex; align-items: center; justify-content: center; min-width: 45px; height: 45px; padding: 0 10px;
            background: var(--blanco); color: var(--texto-oscuro); font-size: 15px; font-weight: 700; text-decoration: none;
            border-radius: 14px !important; border: none !important; margin: 0 !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04); transition: transform 0.1s, box-shadow 0.1s;
        }
        .paginacion-contenedor .relative.z-0.inline-flex > a:active { transform: scale(0.95); }
        
        .paginacion-contenedor [aria-current="page"] > span { 
            background: var(--azul-boton) !important; color: var(--blanco) !important; 
            box-shadow: 0 6px 12px rgba(24, 119, 242, 0.3) !important; 
        }
        
        .paginacion-contenedor svg { width: 18px; height: 18px; }
        
        .paginacion-contenedor span[aria-disabled="true"] span { 
            color: #ccc !important; box-shadow: none !important; background: rgba(255,255,255,0.5) !important; 
        }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/dashboard" class="btn-back">
                <svg style="width:20px; height:20px; stroke:currentColor; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Biblioteca</h1>
        </nav>
        <p class="header-desc">Explora y filtra ejercicios para tus rutinas. Toca uno para ver su técnica.</p>

        <form class="filtros-card" method="GET" action="/ejercicios">
            <input type="text" name="buscar" class="filtro-input" placeholder="Buscar ejercicio..." value="{{ request('buscar') }}">
            
            <select name="grupo" class="filtro-input" onchange="this.form.submit()">
                <option value="todos">Todos los músculos</option>
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
                <a href="/ejercicios/{{ $ejercicio->id_ejercicio }}" class="ejercicio-card">

                    <div class="img-placeholder">
                        
                        @if($ejercicio->gif_url)
                            <img src="{{ asset('storage/' . $ejercicio->gif_url) }}" alt="{{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }}" class="img-preview" loading="lazy">
                        @else
                            @php
                                $grupoAnatomico = mb_strtolower($ejercicio->grupoMuscular->nombre_espanol ?? $ejercicio->grupoMuscular->nombre ?? '', 'UTF-8');
                                
                                $esPierna = \Illuminate\Support\Str::contains($grupoAnatomico, ['cuádriceps', 'isquiotibiales', 'pantorrillas', 'glúteos', 'aductores', 'abductores', 'pierna']);
                                $esBrazo  = \Illuminate\Support\Str::contains($grupoAnatomico, ['tríceps', 'bíceps', 'antebrazos', 'deltoides', 'brazo']);
                                $esEspalda = \Illuminate\Support\Str::contains($grupoAnatomico, ['dorsales', 'espalda superior', 'trapecios', 'erectores espinales', 'elevador de la escápula', 'serrato anterior', 'espalda']);
                            @endphp

                            @if($esPierna)
                                <svg class="svg-ejercicio" viewBox="0 0 24 24"><path d="M20.5 13.52c-.62-.22-1.3-.35-2-.35h-3.17c-.82 0-1.57.48-1.9 1.25L12.5 17h-7l2-5H4L2 7h5.5l1.5 4h6.5c1.66 0 3 .89 3 2v.52Z"/><path d="M14 21v-4"/></svg>
                            @elseif($esBrazo)
                                <svg class="svg-ejercicio" viewBox="0 0 24 24"><path d="M18 10h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"/><path d="M2 10h3v4H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Z"/><path d="M5 8h3v8H5Z"/><path d="M16 8h3v8h-3Z"/><path d="M8 11h8v2H8Z"/></svg>
                            @elseif($esEspalda)
                                <svg class="svg-ejercicio" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                            @else
                                <svg class="svg-ejercicio" viewBox="0 0 24 24"><circle cx="12" cy="15" r="7"/><path d="M16 11V7a4 4 0 0 0-8 0v4"/><path d="M12 15v.01"/></svg>
                            @endif
                        @endif

                    </div>
                    
                    <h3 class="ejercicio-nombre">
                        {{ $ejercicio->nombre_espanol ?? $ejercicio->nombre }}
                    </h3>
                    
                    <span class="badge-grupo">
                        {{ $ejercicio->grupoMuscular->nombre_espanol ?? $ejercicio->grupoMuscular->nombre }}
                    </span>
                </a>
            @empty
                <div class="sin-resultados">
                    <svg style="width: 48px; height: 48px; stroke: #ccc; fill:none; stroke-width:1.5; margin-bottom: 15px;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <h3 style="margin:0 0 5px 0;">Sin resultados</h3>
                    <p style="margin:0; font-size:14px;">Intenta buscar con otro nombre o grupo muscular.</p>
                </div>
            @endforelse

        </div>

        <div class="paginacion-contenedor">
            {{ $ejercicios->links() }}
        </div>

    </div>
</body>
</html>