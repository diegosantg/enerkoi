<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <style>
        /* 1. LAS VARIABLES DE TU SISTEMA DE DISEÑO */
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

        /* 3. LA TARJETA DEL FORMULARIO */
        .registro-card {
            background-color: var(--bg-claro);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px; 
        }

        /* === AQUÍ ESTÁ LA MAGIA PARA CENTRAR EL LOGO === */
        .registro-logo {
            width: 90px; 
            height: auto;
            margin-bottom: 15px;
            display: block; /* Lo convierte en un bloque independiente */
            margin-left: auto; /* Empuja el bloque desde la izquierda */
            margin-right: auto; /* Empuja el bloque desde la derecha (Centrado perfecto) */
        }

        .registro-title {
            color: var(--bg-oscuro);
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 26px;
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

        /* 5. ESTILOS DE LOS INPUTS Y GRID */
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
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--azul-boton);
            outline: none;
        }

        /* Grid para juntar los apellidos en la misma línea en PC */
        .grid-apellidos {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0px;
        }

        @media (min-width: 480px) {
            .grid-apellidos {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }

        /* 6. BOTÓN PRIMARIO */
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
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn-primario:hover {
            background-color: #155ebf;
        }

        /* 7. ENLACES INFERIORES */
        .footer-text {
            margin-top: 25px;
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .footer-text a {
            color: var(--azul-boton);
            text-decoration: none;
            font-weight: bold;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="registro-card">
        <img src="{{ asset('img/LOGOENERKOI.png') }}" alt="Logo Enerkoi" class="registro-logo">
        
        <h1 class="registro-title">Crea tu cuenta en Enerkoi</h1>
        
        @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/registro" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nombre(s):</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="grid-apellidos">
                <div class="form-group">
                    <label class="form-label">Apellido Paterno:</label>
                    <input type="text" name="apellido_p" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Apellido Materno:</label>
                    <input type="text" name="apellido_m" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-primario">Registrarme</button>
        </form>

        <p class="footer-text">¿Ya tienes una cuenta? <br> <a href="/login">Inicia sesión</a></p>
    </div>
</body>
</html>