<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --texto-oscuro: #333;
        }

        /* 2. RESET Y CENTRADO ABSOLUTO */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-oscuro);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* 3. TARJETA DEL ONBOARDING */
        .perfil-card {
            background-color: var(--bg-claro);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 550px; /* Un poco más ancho para acomodar las 2 columnas */
        }

        /* LOGO CENTRADO */
        .perfil-logo {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .perfil-title {
            color: var(--bg-oscuro);
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
            text-align: center;
        }

        .perfil-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
            line-height: 1.5;
            text-align: center;
        }

        /* 4. ALERTA DE ERRORES */
        .alert-error {
            background-color: #ffe6e6;
            color: #d93025;
            border: 1px solid #d93025;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        /* 5. INPUTS Y SELECTS */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--texto-oscuro);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            background-color: white;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--azul-boton);
            outline: none;
        }

        /* Ajuste sutil para los placeholders */
        .form-control::placeholder {
            color: #aaa;
            font-style: italic;
        }

        /* 6. GRID PARA AGRUPAR DATOS (Ahorro de espacio vertical) */
        .grid-2-cols {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0px;
        }

        @media (min-width: 480px) {
            .grid-2-cols {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }

        /* 7. BOTÓN PRIMARIO */
        .btn-primario {
            background-color: var(--azul-boton);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            width: 100%;
            margin-top: 15px;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primario:hover {
            background-color: #155ebf;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="perfil-card">
        <img src="{{ asset('img/LOGOENERKOI.png') }}" alt="Logo Enerkoi" class="perfil-logo">
        
        <h1 class="perfil-title">¡Ya casi estamos, {{ auth()->user()->nombre }}!</h1>
        <p class="perfil-subtitle">Necesito unos datos clave para darte la mejor experiencia posible.</p>

        @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/completar-perfil" method="POST">
            @csrf

            <div class="grid-2-cols">
                <div class="form-group">
                    <label class="form-label">Estatura (cm)</label>
                    <input type="number" name="estatura" class="form-control" placeholder="Ej. 170" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Peso Inicial (kg)</label>
                    <input type="number" step="0.1" name="peso_inicial" class="form-control" placeholder="Peso pluma..." required>
                </div>
            </div>

            <div class="grid-2-cols">
                <div class="form-group">
                    <label class="form-label">Sexo:</label>
                    <select name="sexo" class="form-control" required>
                        <option value="">--- Selecciona ---</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha de nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">¿Cuál es tu objetivo actual?</label>
                <select name="objetivo" class="form-control" required>
                    <option value="" disabled selected>Selecciona una meta...</option>
                    <option value="Ganar masa muscular">Ganar masa muscular (Hipertrofia)</option>
                    <option value="Perder grasa">Perder porcentaje de grasa (Definición)</option>
                    <option value="Recompocision corporal">Recomposición corporal</option>
                    <option value="Mantenimiento">Mantenimiento / Salud</option>
                </select>
            </div>

            <button type="submit" class="btn-primario">Guardar perfil y empezar en Enerkoi</button>
        </form>
    </div>
</body>
</html>