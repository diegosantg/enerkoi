<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis rutinas - Enerkoi</title>
    </head>
    <body>
        <a href="/dashboard">Volver al dashboard</a>
        <h1>Mis Rutinas para entrenar</h1>
        <a href="/rutinas/crear">
            <button style="padding: 10px; background-color: #28a745; color:white; border: none; border-radius: 5px ; cursor: pointer;">
                + Nueva Rutina
            </button>
        </a>
        <br><br>

        @if($rutinas->isEmpty())
        <p>Oye!! Aun no has creado una rutina??? Animate</p>
        @else
        <ul style="list-style-type: none; padding: 0;">
            @foreach($rutinas as $rutina)
            <li style="background: #f4f4f4; margin-bottom: 10px; padding: 15p; border-radius: 8px;">
                <h3 style="margin:0;"><a href="/rutinas/{{$rutina->id_rutinas}}" style="color: #333; text-decoration: none;">
                    {{$rutina->nombre}}
                </a></h3>
                <p style="margin: 5px 0; color:#666;">{{$rutina->descripcion}}</p>
                <small>Ejercicios en esta rutina {{$rutina->ejercicios->count()}}</small>
            </li>
            @endforeach
        </ul>
        @endif
    </body>

</html>