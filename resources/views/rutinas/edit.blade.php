<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rutina - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --peligro-borrar: #dc3545;
            --texto-oscuro: #333;
            --texto-claro: #fff;
        }

        /* 2. REGLAS GLOBALES */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        .main-container {
            max-width: 800px;
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

        h1 {
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 28px;
        }

        /* 3. TARJETAS DE SECCIÓN */
        .card-seccion {
            background-color: var(--bg-claro);
            color: var(--texto-oscuro);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-seccion h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: var(--bg-oscuro);
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        /* 4. FORMULARIOS (Inputs y Selects) */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: white;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--azul-boton);
            outline: none;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        /* 5. GRID PARA LOS PARÁMETROS DEL EJERCICIO */
        .grid-parametros {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        /* 6. BOTONES */
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: opacity 0.2s, transform 0.2s;
            text-align: center;
        }

        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn:active { transform: translateY(1px); }

        .btn-exito { background-color: var(--verde-exito); color: white; width: 100%; }
        .btn-primario { background-color: var(--azul-boton); color: white; width: 100%; font-size: 18px; padding: 15px;}
        .btn-texto-rojo { background: none; color: var(--peligro-borrar); border: none; font-weight: bold; cursor: pointer; padding: 5px; }
        .btn-texto-rojo:hover { text-decoration: underline; }

        /* 7. LISTA DE VISTA PREVIA */
        .lista-preview {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item-preview {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .item-preview-info strong {
            display: block;
            color: var(--bg-oscuro);
            font-size: 16px;
            margin-bottom: 4px;
        }

        .item-preview-info small {
            color: #666;
            font-size: 13px;
        }

        .estado-vacio {
            text-align: center;
            color: #888;
            padding: 20px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="/rutinas/{{ $rutina->id_rutinas }}" class="btn-volver">← Cancelar y volver</a>
        
        <h1>Editando: {{$rutina->nombre }}</h1>

        <div class="card-seccion">
            <h3>Información de la Rutina</h3>
            
            <div class="form-group">
                <label class="form-label">Nombre de la Rutina</label>
                <input type="text" id="nombre_rutina" value="{{ $rutina->nombre }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción (Opcional)</label>
                <textarea id="descripcion_rutina" class="form-control" rows="2">{{ $rutina->descripcion }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Día asignado (Opcional)</label>
                <select id="dia_asignado" class="form-control">
                    <option value="">-- Ninguno (Rutina libre) --</option>
                    <option value="Lunes" {{ (isset($rutina) && $rutina->dia_asignado == 'Lunes') ? 'selected' : '' }}>Lunes</option>
                    <option value="Martes" {{ (isset($rutina) && $rutina->dia_asignado == 'Martes') ? 'selected' : '' }}>Martes</option>
                    <option value="Miercoles" {{ (isset($rutina) && $rutina->dia_asignado == 'Miercoles') ? 'selected' : '' }}>Miércoles</option>
                    <option value="Jueves" {{ (isset($rutina) && $rutina->dia_asignado == 'Jueves') ? 'selected' : '' }}>Jueves</option>
                    <option value="Viernes" {{ (isset($rutina) && $rutina->dia_asignado == 'Viernes') ? 'selected' : '' }}>Viernes</option>
                    <option value="Sabado" {{ (isset($rutina) && $rutina->dia_asignado == 'Sabado') ? 'selected' : '' }}>Sábado</option>
                    <option value="Domingo" {{ (isset($rutina) && $rutina->dia_asignado == 'Domingo') ? 'selected' : '' }}>Domingo</option>
                </select>
            </div>
        </div>
        
        <div class="card-seccion">
            <h3>Agrega tus ejercicios</h3>
            
            <div class="form-group">
                <label class="form-label">1. Selecciona el músculo</label>
                <select id="select_grupo" onchange="buscarEjercicios()" class="form-control">
                    <option value="">-- Grupo Muscular --</option>
                    @foreach($grupos as $grupo)
                        <option value="{{$grupo->id_grupos_musculares}}">
                            {{$grupo->nombre_espanol ?? $grupo->nombre}}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">2. Selecciona el ejercicio</label>
                <select id="select_ejercicio" class="form-control" disabled>
                    <option value="">Primero elige un grupo arriba</option>
                </select>
            </div>
            
            <div id="detalles_ejercicio" style="display: none;">
                <div class="grid-parametros">
                    <div>
                        <label class="form-label">Series</label>
                        <input type="number" id="input_sets" value="3" min="1" class="form-control">
                    </div>
                    <div>
                        <label class="form-label">Reps</label>
                        <input type="text" id="input_reps" value="10-12" class="form-control">
                    </div>
                    <div>
                        <label class="form-label">Descanso (s)</label>
                        <input type="number" id="input_rest" value="90" step="10" min="0" class="form-control">
                    </div>
                </div>

                <button onclick="agregarALaRutina()" class="btn btn-exito">
                    Añadir a la rutina ➕
                </button>
            </div>
        </div>

        <div class="card-seccion">
            <h3>Tu rutina hasta ahora</h3>
            <ul id="lista_vista_previa" class="lista-preview">
            </ul>
        </div>

        <button onclick="guardarCambios()" class="btn btn-primario">
            💾 Guardar Cambios
        </button>

    </div>

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

        // HTML INTERNO ACTUALIZADO CON LAS NUEVAS CLASES
        function actualizarVistaPrevia() {
            let listaHTML = document.getElementById('lista_vista_previa');
            listaHTML.innerHTML = ""; 

            if (ejerciciosEnRutina.length === 0) {
                listaHTML.innerHTML = '<div class="estado-vacio">Aún no has agregado ejercicios...</div>';
                return;
            }

            ejerciciosEnRutina.forEach((ej, index) => {
                listaHTML.innerHTML += `
                    <li class="item-preview">
                        <div class="item-preview-info">
                            <strong>${index + 1}. ${ej.nombre}</strong>
                            <small>${ej.sets} series de ${ej.reps} (${ej.rest}s descanso)</small>
                        </div>
                        <button onclick="eliminarDeLista(${index})" class="btn-texto-rojo">✕ Quitar</button>
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
            let nombre = document.getElementById('nombre_rutina').value;
            let desc = document.getElementById('descripcion_rutina').value;

            if(nombre === ""){ alert("El nombre no puede estar vacío."); return; }
            if(ejerciciosEnRutina.length === 0){ alert("Agrega al menos un ejercicio."); return; }

            // UX: Bloquear botón mientras guarda
            let btnGuardar = document.querySelector('.btn-primario');
            let textoOriginal = btnGuardar.innerText;
            btnGuardar.innerText = "Guardando...";
            btnGuardar.disabled = true;

            fetch('/rutinas/{{ $rutina->id_rutinas }}',{
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')          
                },
                body: JSON.stringify({
                    nombre: nombre,
                    descripcion: desc,
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
                btnGuardar.innerText = textoOriginal;
                btnGuardar.disabled = false;
            });
        }
    </script>
</body>
</html>