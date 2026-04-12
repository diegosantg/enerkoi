<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rutina - Enerkoi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">
    <a href="/rutinas/{{ $rutina->id_rutinas }}" style="text-decoration: none; color: #007bff;">← Cancelar</a>
    <h1>Editando: {{$rutina->nombre }}</h1>

    <div style="background: #f4f4f4; padding:20px; border-radius: 8px; margin-bottom: 20px;">
        <h3>Información de la Rutina</h3>
        <label>Nombre de la Rutina</label><br>
        <input type="text" id="nombre_rutina" value="{{ $rutina->nombre }}" required style="width: 100%; max-width: 400px; padding:8px;"><br><br>

        <label>Descripción (Opcional)</label><br>
        <textarea id="descripcion_rutina" style="width: 100%; max-width: 400px; padding:8px;">{{ $rutina->descripcion }}</textarea><br><br>

        <label>Día asignado (Opcional):</label><br>
        <select id="dia_asignado" style="width: 100%; max-width: 400px; padding: 8px;">
            <option value="">-- Ninguno (Rutina libre) --</option>
            <option value="Lunes" {{ (isset($rutina) && $rutina->dia_asignado == 'Lunes') ? 'selected' : '' }}>Lunes</option>
            <option value="Martes" {{ (isset($rutina) && $rutina->dia_asignado == 'Martes') ? 'selected' : '' }}>Martes</option>
            <option value="Miercoles" {{ (isset($rutina) && $rutina->dia_asignado == 'Miercoles') ? 'selected' : '' }}>Miércoles</option>
            <option value="Jueves" {{ (isset($rutina) && $rutina->dia_asignado == 'Jueves') ? 'selected' : '' }}>Jueves</option>
            <option value="Viernes" {{ (isset($rutina) && $rutina->dia_asignado == 'Viernes') ? 'selected' : '' }}>Viernes</option>
            <option value="Sabado" {{ (isset($rutina) && $rutina->dia_asignado == 'Sabado') ? 'selected' : '' }}>Sábado</option>
            <option value="Domingo" {{ (isset($rutina) && $rutina->dia_asignado == 'Domingo') ? 'selected' : '' }}>Domingo</option>
        </select><br><br>
    </div>
    
    <div style="background: #e9ecef; padding:20px; border-radius:8px; margin-bottom: 20px;">
        <h3>Agrega tus ejercicios</h3>
        <select id="select_grupo" onchange="buscarEjercicios()" style="width: 200px; padding:8px;">
            <option value="">--Grupo Muscular--</option>
            @foreach($grupos as $grupo)
                <option value="{{$grupo->id_grupos_musculares}}">
                    {{$grupo->nombre_espanol ?? $grupo->nombre}}
                </option>
            @endforeach
        </select>
        
        <select id="select_ejercicio" style="width: 250px; padding: 8px;" disabled>
            <option value="">Primero elige un grupo</option>
        </select>
        
        <div id="detalles_ejercicio" style="display: none; margin-top: 15px;">
            <input type="number" id="input_sets" value="3" min="1" style="width: 60px; padding: 5px;" title="Series"> Series x
            <input type="text" id="input_reps" value="10-12" style="width:80px; padding:5px;" title="Repeticiones"> Reps |
            <input type="number" id="input_rest" value="90" style="width: 60px; padding: 5px;" title="Descanso"> Seg Descanso
            <br><br>

            <button onclick="agregarALaRutina()" style="padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Añadir a la rutina +
            </button>
        </div>
    </div>

    <div style="border:2px dashed #ccc; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h3>Tu rutina hasta ahora</h3>
        <ul id="lista_vista_previa" style="list-style-type: none; padding:0;">
            </ul>
    </div>

    <button onclick="guardarCambios()" style="padding: 15px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; max-width:400px;">
        Guardar Cambios
    </button>

    @php 
        $ejerciciosMapeados = $rutina->ejercicios->map(function($item){
            return[
                'id'=> $item->ejercicio_id,
                'nombre'=>$item->detalleEjercicio->nombre_espanol ?? $item->detalleEjercicio->nombre,
                'sets'=>$item->target_sets,
                'reps'=> $item->target_reps,
                'rest'=> $item->rest_seconds
            ];
        });
    @endphp

    <script>
        let ejerciciosEnRutina = @json($ejerciciosMapeados);
        
        window.onload = function(){
            actualizarVistaPrevia();
        }

        function buscarEjercicios(){
            let grupoId= document.getElementById('select_grupo').value;
            let selectEjercicio = document.getElementById('select_ejercicio');
            let detalles = document.getElementById('detalles_ejercicio');

            if (grupoId===""){
                selectEjercicio.innerHTML = '<option value="">Primero escoge un grupo muscular</option>';
                selectEjercicio.disabled = true;
                detalles.style.display = 'none';
                return;
            }

            selectEjercicio.innerHTML='<option value="">Cargando...</option>';
            selectEjercicio.disabled=true;

            fetch('/api/ejercicios-del-grupo/'+grupoId)
            .then(res =>res.json())
            .then(datos=>{
                selectEjercicio.innerHTML='<option value="">--Escoge un ejercicio--</option>';
                datos.forEach(ejercicio=>{
                    let opcion=document.createElement('option');
                    opcion.value = ejercicio.id_ejercicio;
                    opcion.text = ejercicio.nombre_espanol ? ejercicio.nombre_espanol: ejercicio.nombre;
                    selectEjercicio.appendChild(opcion);
                });
                selectEjercicio.disabled=false;
            });
        }

        document.getElementById('select_ejercicio').onchange = function(){
            document.getElementById('detalles_ejercicio').style.display = this.value ? 'block' : 'none';
        };

        function agregarALaRutina(){
            let selectEj = document.getElementById('select_ejercicio');
            let idEj = selectEj.value;

            if(!idEj){alert("Selecciona un ejercicio"); return;}
            let nombreEj = selectEj.options[selectEj.selectedIndex].text;
            let sets = document.getElementById('input_sets').value;
            let reps=document.getElementById('input_reps').value;
            let rest = document.getElementById('input_rest').value;
            
            ejerciciosEnRutina.push({
                id: idEj,
                nombre: nombreEj,
                sets: sets,
                reps: reps,
                rest: rest
            });

            actualizarVistaPrevia();
            selectEj.value = "";
            document.getElementById('detalles_ejercicio').style.display = 'none';
        }

       
        function actualizarVistaPrevia() {
            let listaHTML = document.getElementById('lista_vista_previa');
            listaHTML.innerHTML = ""; 

            if (ejerciciosEnRutina.length === 0) {
                listaHTML.innerHTML = '<li style="color: #888;">Aún no has agregado ejercicios...</li>';
                return;
            }

            ejerciciosEnRutina.forEach((ej, index) => {
                listaHTML.innerHTML += `
                    <li style="background: #fff; border: 1px solid #ddd; margin-bottom: 5px; padding: 10px; border-radius: 4px; display: flex; justify-content: space-between;">
                        <span><strong>${index + 1}. ${ej.nombre}</strong> <br> <small>${ej.sets} series de ${ej.reps} (${ej.rest}s descanso)</small></span>
                        <button onclick="eliminarDeLista(${index})" style="color: red; border: none; background: none; cursor: pointer;">X Eliminar</button>
                    </li>
                `;
            });
        }

        function eliminarDeLista(index){
            ejerciciosEnRutina.splice(index, 1);
            actualizarVistaPrevia();
        }

        function guardarCambios(){
            let dia = document.getElementById('dia_asignado').value;
            fetch('/rutinas/{{ $rutina->id_rutinas }}',{
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')          
                },
                body: JSON.stringify({
                    nombre:document.getElementById('nombre_rutina').value,
                    descripcion:document.getElementById('descripcion_rutina').value,
                    dia_asignado: dia,
                    ejercicios: ejerciciosEnRutina
                })
            })
            .then(res=>res.json())
            .then(data => {
                if(data.success){
                    alert('Cambios guardados');
                    window.location.href= "/rutinas/{{ $rutina->id_rutinas }}";
                }
            })
            .catch(error => {
                console.error("Error al guardar:", error);
                alert("Hubo un error al guardar los cambios.");
            });
        }
    </script>
</body>
</html>