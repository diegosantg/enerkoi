<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>{{ $rutina->nombre}} - Enerkoi</title>
    </head>
    <body style="font-family: sans-serif; max-width: 800px; margin:0 auto; padding: 20px;">
        <a href="/rutinas" style="text-decoration: none; color: #007bff;"><-Volver a mis rutinas</a>
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>{{$rutina->nombre}}</h1>

            <div style="display: flex; gap: 10px;">
                <a href="/rutinas/{{ $rutina->id_rutinas }}/edit" style="text-decoration: none">
                    <button style="padding: 10px; background-color: #ffc107; color: #333; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                        Editar Rutina
                    </button>
                </a>
            </div>
            <form action="/rutinas/{{ $rutina->id_rutinas}}" method="POST" onsubmit="return('¿Seguro que quieres enviar esta rutina a la papelera? Tienes 30 dias para recuperarla.');">
              @csrf
              @method('DELETE')<button type="submit" style="padding: 10px; background-color:#dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                🗑️ Enviar a Papelera
              </button>  
            </form>


        </div>

        @if($rutina->descripcion)
        <p style="color: #666; font-size: 18px;">{{ $rutina->descripcion }}</p>
        @endif

        <hr style="margin: 20px 0;">
        <h3>Ejercicios en esta rutina({{ $rutina->ejercicios->count()}})</h3>

        @if ($rutina->ejercicios->isEmpty())
        <p>Esta rutina esta vacia.</p>
        @else

        <ul style="list-style-type: none; padding:0;">
            @foreach($rutina->ejercicios as $indice => $item)
            <li style=" background: #f8f9fa; border: 1px solid #ddd; margin-bottom: 10px; padding: 15px; border-radius: 8px;">
                <h4 style="margin: 0 0 10px 0; color:#333; ">
                    {{$indice + 1}}.
                    {{$item->detalleEjercicio->nombre_espanol ?? $item->detalleEjercicio->nombre}}
                </h4>
                <div style="display: flex; gap: 20px; color: #555;">
                    <span><strong>Series:</strong>{{$item->target_sets}}</span>
                    <span><Strong>Reps:</Strong>{{$item->target_reps}}</span>
                    <span><Strong>Descanso:</Strong>{{$item->rest_seconds}} seg</span>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </body>

</html>