<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis rutinas - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. LAS VARIABLES DE TU SISTEMA DE DISEÑO */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #333;
            --texto-claro: #fff;
        }

        /* 2. REGLAS GLOBALES PARA PANTALLAS INTERNAS */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        /* Contenedor central: Evita que la lista se estire demasiado en PC */
        .main-container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* 3. BOTÓN DE NAVEGACIÓN (Volver) */
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

        /* 4. ENCABEZADO (Título + Botón) */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h1 {
            margin: 0;
            font-size: 28px;
        }

        .btn-crear {
            background-color: var(--verde-exito);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.2s, background 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-crear:hover {
            background-color: #218838;
            transform: translateY(-2px); /* Pequeño salto visual */
        }

        /* 5. LISTA Y TARJETAS DE RUTINAS */
        .lista-rutinas {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px; /* Espacio automático entre tarjetas */
        }

        /* Toda la tarjeta es un enlace <a> */
        .tarjeta-rutina {
            background-color: var(--bg-claro);
            padding: 20px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--texto-oscuro);
            display: block;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .tarjeta-rutina:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .tarjeta-rutina h3 {
            margin: 0 0 8px 0;
            color: var(--bg-oscuro);
            font-size: 20px;
        }

        .tarjeta-rutina p {
            margin: 0 0 15px 0;
            color: #666;
            font-size: 15px;
            line-height: 1.4;
        }

        /* Píldora de información */
        .badge-ejercicios {
            background-color: #ddd;
            color: #555;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        /* 6. ESTADO VACÍO (Empty State) */
        .estado-vacio {
            background-color: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            padding: 40px;
            text-align: center;
            border-radius: 8px;
        }

        .estado-vacio p {
            margin: 0;
            font-size: 18px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="/dashboard" class="btn-volver">← Volver al dashboard</a>

        <div class="header-section">
            <h1>Mis Rutinas</h1>
            <a href="/rutinas/crear" class="btn-crear">+ Nueva Rutina</a>
        </div>

        @if($rutinas->isEmpty())
            <div class="estado-vacio">
                <p>¡Oye! ¿Aún no has creado una rutina? Anímate 💪</p>
            </div>
        @else
            <ul class="lista-rutinas">
                @foreach($rutinas as $rutina)
                <li>
                    <a href="/rutinas/{{$rutina->id_rutinas}}" class="tarjeta-rutina">
                        <h3>{{$rutina->nombre}}</h3>
                        <p>{{$rutina->descripcion}}</p>
                        <span class="badge-ejercicios">
                            {{$rutina->ejercicios->count()}} ejercicios
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>