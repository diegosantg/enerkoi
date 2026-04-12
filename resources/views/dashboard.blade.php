<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard - Enerkoi</title>
    </head>
    <body>

    <h1>
    Bienvenido a tu panel de entrenamiento,{{auth()->user()->nombre}} {{auth()->user()->apellido_p}}
    </h1>

    <div style="background-color: #f4f4f4; padding:15px; border-radius:8px; margin-bottom: 20px; max-width: 400px;">
        <h3 style="margin-top: 0;">Tu perfil fisico</h3>
        <p style="margin: 5px 0;">
            <strong>Peso:</strong>{{auth()->user()->perfil->peso_inicial}} kg
        </p>
        <p style="margin: 5px 0;">
            <strong>Estatura:</strong>{{auth()->user()->perfil->estatura}} cm
        </p>
        <p style="margin: 5px 0;">
            <strong>Objetivo:</strong>{{auth()->user()->perfil->objetivo}}
        </p>



    </div>
    <p>en desarrollo</p>

        <form action="/logout" method="POST">
            @csrf
            <button type="submit">
            Cerrar Sesion
            </button>
        </form>


    </body>


</html>