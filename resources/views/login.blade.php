<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <style>
        /* 1. LAS VARIABLES DE TU SISTEMA DE DISEÑO */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --texto-oscuro: #333;
        }

        /* 2. RESET Y CENTRADO ABSOLUTO (Para pantallas de Login) */
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
            min-height: 100vh; /* Ocupa toda la altura de la pantalla */
            box-sizing: border-box;
        }

        /* 3. LA TARJETA DEL FORMULARIO */
        .login-card {
            background-color: var(--bg-claro);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        
        .login-logo {
            width: 90px; 
            height: auto;
            margin-bottom: 15px; 
            display: inline-block;
        }

        .login-title {
            color: var(--bg-oscuro);
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 28px;
        }

        .login-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
            line-height: 1.5;
        }

        /* 4. ESTILOS DE LOS INPUTS */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--texto-oscuro);
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: var(--azul-boton);
            outline: none; /* Quita el borde negro por defecto de los navegadores */
        }

        /* 5. BOTÓN PRIMARIO */
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

        /* 6. ALERTA DE ERRORES (Más estética pero igual de visible) */
        .alert-error {
            background-color: #ffe6e6;
            color: #d93025;
            border: 1px solid #d93025;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 14px;
        }

        .alert-error p {
            margin: 5px 0;
        }

        /* 7. ENLACES INFERIORES */
        .footer-text {
            margin-top: 25px;
            font-size: 14px;
            color: #555;
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

    <div class="login-card">
        <img src="{{ asset('img/LOGOENERKOI.png') }}" alt="Logo Enerkoi" class="login-logo">
        
        <h1 class="login-title">¡Ey!</h1>
        <p class="login-subtitle">Hace tiempo no nos veíamos, bienvenido de vuelta a Enerkoi.</p>

        @if ($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
            <p>• {{$error}}</p>
            @endforeach
        </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email')}}" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-primario">Iniciar Sesión</button>
        </form>

        <p class="footer-text">¿QUÉ? ¿Aún no tienes cuenta? <br> <a href="/registro">¿Qué esperas?</a></p>
    </div>

</body>
</html>