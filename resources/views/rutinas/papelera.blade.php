<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelera de Rutinas - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #333;
            --texto-claro: #fff;
            --alerta-rojo: #dc3545;
        }

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
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .header-section h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-section p {
            color: #ccc;
            margin: 0;
            font-size: 16px;
        }

        /* GRID DE RUTINAS ELIMINADAS */
        .grid-rutinas {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        /* ESTILO "APAGADO" PARA TARJETAS EN PAPELERA */
        .rutina-card {
            background-color: rgba(255, 255, 255, 0.9); /* Ligeramente transparente */
            border-radius: 12px;
            padding: 20px;
            color: var(--texto-oscuro);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-left: 5px solid #888; /* Borde gris indicando que está inactiva */
            filter: grayscale(40%); /* Efecto visual de "eliminado" */
            transition: filter 0.3s;
        }

        .rutina-card:hover {
            filter: grayscale(0%); /* Recobra color al pasar el mouse */
        }

        .rutina-header {
            margin-bottom: 15px;
        }

        .rutina-nombre {
            margin: 0 0 5px 0;
            font-size: 20px;
            color: #555;
            text-decoration: line-through; /* Tachado sutil */
        }

        .rutina-fecha {
            font-size: 13px;
            color: var(--alerta-rojo);
            font-weight: bold;
        }

        /* BOTONES */
        .acciones-container {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .btn-restaurar {
            flex: 1;
            background-color: var(--verde-exito);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .btn-restaurar:hover {
            background-color: #218838;
        }

        .btn-restaurar:active {
            transform: scale(0.98);
        }

        /* ESTADO VACÍO */
        .sin-resultados {
            grid-column: 1 / -1; 
            text-align: center;
            padding: 60px 20px;
            background: rgba(255,255,255,0.05);
            border: 2px dashed rgba(255,255,255,0.2);
            border-radius: 12px;
            color: #ccc;
        }

        .icono-vacio {
            font-size: 50px;
            margin-bottom: 15px;
            display: block;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="main-container">
        
        <a href="/rutinas" class="btn-volver">← Volver a mis Rutinas Activas</a>
        
        <div class="header-section">
            <h1>🗑️ Papelera de Reciclaje</h1>
            <p>Las rutinas aquí almacenadas se eliminarán permanentemente de la base de datos después de 30 días gracias al sistema Prunable.</p>
        </div>

        <div class="grid-rutinas">
            
            @forelse($rutinas as $rutina)
                <div class="rutina-card">
                    <div class="rutina-header">
                        <h3 class="rutina-nombre">{{ $rutina->nombre }}</h3>
                        <span class="rutina-fecha">
                            Eliminada {{ $rutina->deleted_at->diffForHumans() }}
                        </span>
                    </div>

                    <p style="color: #666; font-size: 14px; margin-top: 0;">
                        {{ Str::limit($rutina->descripcion, 60, '...') }}
                    </p>

                    <div class="acciones-container">
                        <form action="{{ route('rutinas.restaurar', $rutina->id_rutinas) }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn-restaurar">
                                ♻️ Restaurar Rutina
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sin-resultados">
                    <span class="icono-vacio">✨</span>
                    <h2>Tu papelera está vacía</h2>
                    <p>No hay rutinas eliminadas recientemente.</p>
                </div>
            @endforelse

        </div>

    </div>
</body>
</html>