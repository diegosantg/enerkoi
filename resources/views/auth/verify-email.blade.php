<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Dashboard - Enerkoi</title>
        
        <style>
            :root {
                --bg-oscuro : #3b4282;
                --bg-claro: #f4f4f4;
                --bg-perfil: #e9ecd8;
                --azul-boton: #1877f2;
                --texto-oscuro: #333;
            }

            body{
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
                background-color: var(--bg-oscuro);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                color: var(--texto-oscuro);

            }

            .card{
                background-color: white;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                max-width: 500px;
                width: 90%;
                text-align: center;
            }
            .btn-primary{
                background-color: var(--azul-boton);
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius:  5px;
                cursor: pointer;
                font-size: 16px;
                font-weight: bold;
                width: 100%;
                margin-top: 15px;
            }
            .btn-primary:hover {
            background-color: #155bb5;
        }

        .btn-secondary {
            background-color: transparent;
            color: #666;
            border: none;
            cursor: pointer;
            text-decoration: underline;
            margin-top: 20px;
        }

        .alerta-exito {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
<div class="card">
        <h2 style="color: var(--bg-oscuro);">¡Casi listos!</h2>
        <p style="color: #555; line-height: 1.6;">
            Muchas gracias por registrarte en Enerkoi. Antes de empezar tu vida fit , necesitamos verificar tu Correo electronico para darte la mejor experiencia.
            Acabamos de enviarte un enlace de confirmacion a tu bandeja de entrada en <strong>{{auth()->user()->email}}</strong>.
        </p>
        @if(session('mensaje'))
        <div class="alerta-exito">
            {{session('mensaje')}}
        </div>
        @endif

        <form method="POSt" action="/email/verification-notification">
            @csrf
            <button type="submit" class="btn-primary">
            Reenviar correo de verificacion
            </button>
        </form>

        <form  method= "POST" action="/logout">
            @csrf
            <button type="submit" class="btn-secondary">
                Cerrar Sesion
            </button>
        </form>
</div>