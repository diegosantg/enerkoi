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
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --rojo-papelera: #ef4444;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased;
        }

        .app-container { max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px; }

        /* 2. HEADER Y TARJETAS */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
        }
        .top-nav h1 { margin: 0; font-size: 22px; font-weight: 800; color: var(--texto-oscuro); }

        .card-app {
            background: var(--blanco); border-radius: 24px; padding: 25px 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        .card-app h3 { margin: 0 0 20px 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro); display: flex; align-items: center; gap: 8px; }

        /* 3. INPUTS Y SELECTORES MODALES */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; color: var(--texto-oscuro); }
        .input-app {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s;
        }
        .input-app:focus { border-color: var(--azul-boton); background: var(--blanco); }

        .btn-selector-modal {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 600; box-sizing: border-box; background: var(--bg-app); 
            color: var(--texto-oscuro); cursor: pointer; display: flex; justify-content: space-between; align-items: center;
        }
        .btn-selector-modal.desactivado { opacity: 0.6; pointer-events: none; }

        /* 4. MODALES (Bottom Sheets) */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);
            display: flex; align-items: flex-end; justify-content: center;
            z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .modal-overlay.activo { opacity: 1; pointer-events: auto; }
        .modal-content {
            background: var(--bg-app); width: 100%; max-width: 600px;
            border-radius: 30px 30px 0 0; padding: 25px; box-sizing: border-box;
            transform: translateY(100%); transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            max-height: 85vh; overflow-y: auto; display: flex; flex-direction: column;
        }
        .modal-overlay.activo .modal-content { transform: translateY(0); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-cerrar-modal { background: rgba(0,0,0,0.05); border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; }

        /* 5. CUADRÍCULAS Y DETALLE */
        .grid-grupos, .grid-ejercicios-seleccion { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .tarjeta-grupo { position: relative; border-radius: 20px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; background: var(--blanco); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .tarjeta-grupo img { width: 100%; height: 100%; object-fit: cover; }
        .tarjeta-grupo .overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 30px 15px 15px 15px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); color: var(--blanco); font-weight: 800; text-transform: capitalize; }
        
        .item-ejercicio-seleccion { background: var(--blanco); border-radius: 18px; padding: 10px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); cursor: pointer; }
        .item-ejercicio-seleccion img { width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; margin-bottom: 8px; background: var(--bg-app); }
        .item-ejercicio-seleccion span { font-size: 14px; font-weight: 700; display: block; color: var(--texto-oscuro); text-transform: capitalize; }

        .video-container { position: relative; width: 100%; padding-bottom: 56.25%; height: 0; border-radius: 16px; overflow: hidden; background: #000; margin-bottom: 20px; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
        .grid-parametros { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; background: var(--blanco); padding: 15px; border-radius: 16px; }
        .grid-parametros .input-app { padding: 12px 5px; text-align: center; font-weight: 700; border-color: #e5e7eb; }

        /* 6. BOTONES Y VISTA PREVIA */
        .btn-primario { width: 100%; background: var(--verde-exito); color: var(--blanco); border: none; border-radius: 20px; padding: 20px; font-size: 18px; font-weight: 800; cursor: pointer; transition: transform 0.1s; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-primario.btn-azul { background: var(--azul-boton); }
        .btn-primario:active { transform: scale(0.97); }
        .lista-preview { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
        .item-preview { background: var(--bg-app); border-radius: 16px; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
        .item-preview-info strong { display: block; font-size: 15px; color: var(--texto-oscuro); }
        .item-preview-info small { color: var(--texto-gris); font-size: 13px; font-weight: 500; }
        .btn-quitar { background: none; border: none; color: var(--rojo-papelera); cursor: pointer; }
        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/rutinas/{{ $rutina->id_rutinas }}" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Editar: {{ $rutina->nombre }}</h1>
        </nav>

        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Información</h3>
            
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" id="nombre_rutina" value="{{ $rutina->nombre }}" class="input-app" required>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea id="descripcion_rutina" class="input-app" rows="2">{{ $rutina->descripcion }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Día asignado</label>
                <select id="dia_asignado" class="input-app">
                    <option value="">-- Ninguno --</option>
                    @foreach(['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia)
                        <option value="{{ $dia }}" {{ $rutina->dia_asignado == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M18 10h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"/><path d="M2 10h3v4H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Z"/><path d="M5 8h3v8H5Z"/><path d="M16 8h3v8h-3Z"/><path d="M8 11h8v2H8Z"/></svg> Agregar Bloques</h3>
            
            <div class="form-group">
                <label class="form-label">1. Músculo</label>
                <div class="btn-selector-modal" onclick="abrirModalGrupos()">
                    <span id="texto_grupo_seleccionado">-- Toca para seleccionar --</span>
                    <svg style="width:18px; height:18px; color:#6b7280; stroke:currentColor; stroke-width:2; fill:none;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">2. Ejercicio</label>
                <div class="btn-selector-modal desactivado" id="btn_selector_ejercicio" onclick="abrirModalEjercicios()">
                    <span id="texto_ejercicio_seleccionado">Primero elige un músculo</span>
                    <svg style="width:18px; height:18px; color:#6b7280; stroke:currentColor; stroke-width:2; fill:none;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
            </div>
        </div>

        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> Rutina Actual</h3>
            <ul id="lista_vista_previa" class="lista-preview"></ul>
        </div>

        <button onclick="guardarCambios()" class="btn-primario btn-azul">
            <svg class="svg-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Guardar Cambios
        </button>
    </div>

    <div id="modal_grupos" class="modal-overlay" onclick="e => e.target.id==='modal_grupos' && cerrarModalGrupos()">
        <div class="modal-content">
            <div class="modal-header"><h3>Músculos</h3><button class="btn-cerrar-modal" onclick="cerrarModalGrupos()">×</button></div>
            <div class="grid-grupos">
                @foreach($grupos as $grupo)
                    <div class="tarjeta-grupo" onclick="seleccionarGrupo({{ $grupo->id_grupos_musculares }}, '{{ $grupo->nombre_espanol ?? $grupo->nombre }}')">
                        @if(isset($grupo->gif_representativo))
                            <img src="{{ asset('storage/' . $grupo->gif_representativo) }}" loading="lazy">
                        @endif
                        <div class="overlay">{{ $grupo->nombre_espanol ?? $grupo->nombre }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="modal_ejercicios" class="modal-overlay" onclick="e => e.target.id==='modal_ejercicios' && cerrarModalEjercicios()">
        <div class="modal-content"><div class="modal-header"><button onclick="volverAGrupos()">←</button><h3 id="titulo_modal_ejercicios">Ejercicios</h3><button onclick="cerrarModalEjercicios()">×</button></div><div id="contenedor_lista_ejercicios" class="grid-ejercicios-seleccion"></div></div>
    </div>

    <div id="modal_detalle_ejercicio" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header"><button onclick="volverAEjercicios()">←</button><h3 id="det_nombre">Detalle</h3><button onclick="cerrarModalDetalle()">×</button></div>
            <div class="modal-body">
                <div id="det_video_container" class="video-container" style="display:none;"><iframe id="det_iframe" src="" allowfullscreen></iframe></div>
                <div class="card-descripcion"><h4>Instrucciones</h4><p id="det_instrucciones"></p></div>
                <div class="grid-parametros">
                    <div><label class="form-label">Series</label><input type="number" id="input_sets" value="3" class="input-app"></div>
                    <div><label class="form-label">Reps</label><input type="text" id="input_reps" value="10-12" class="input-app"></div>
                    <div><label class="form-label">Desc. (s)</label><input type="number" id="input_rest" value="90" class="input-app"></div>
                </div>
                <button class="btn-primario" onclick="agregarALaRutina()">Añadir a la Rutina</button>
            </div>
        </div>
    </div>

    @php 
        $ejerciciosMapeados = $rutina->ejercicios->map(function($item){
            return [
                'id'=> $item->ejercicio_id,
                'nombre'=>$item->detalleEjercicio->nombre_espanol ?? $item->detalleEjercicio->nombre,
                'sets'=>$item->target_sets,
                'reps'=> $item->target_reps,
                'rest'=> $item->rest_seconds
            ];
        });
    @endphp

    <script>
        let ejerciciosEnRutina = @json($ejerciciosMapeados); // Cargamos los datos existentes
        let ejercicioSeleccionadoTemporal = null;
        let tokenCSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        window.onload = () => actualizarVistaPrevia();

        function abrirModalGrupos() { document.getElementById('modal_grupos').classList.add('activo'); }
        function cerrarModalGrupos() { document.getElementById('modal_grupos').classList.remove('activo'); }
        
        function seleccionarGrupo(id, nombre) {
            document.getElementById('texto_grupo_seleccionado').innerText = nombre;
            document.getElementById('btn_selector_ejercicio').classList.remove('desactivado');
            document.getElementById('titulo_modal_ejercicios').innerText = nombre;
            cerrarModalGrupos();
            buscarEjercicios(id);
        }

        function buscarEjercicios(grupoId){
            let contenedor = document.getElementById('contenedor_lista_ejercicios');
            contenedor.innerHTML = 'Cargando...';
            fetch('/api/ejercicios-del-grupo/' + grupoId)
                .then(res => res.json())
                .then(datos => {
                    contenedor.innerHTML = '';
                    datos.forEach(ej => {
                        let div = document.createElement('div');
                        div.className = 'item-ejercicio-seleccion';
                        div.innerHTML = `<img src="/storage/${ej.gif_url || ''}"><span>${ej.nombre_espanol || ej.nombre}</span>`;
                        div.onclick = () => verDetalleEjercicio(ej);
                        contenedor.appendChild(div);
                    });
                });
        }

        function verDetalleEjercicio(ej) {
            ejercicioSeleccionadoTemporal = ej;
            document.getElementById('det_nombre').innerText = ej.nombre_espanol || ej.nombre;
            document.getElementById('det_instrucciones').innerText = ej.descripcion || "Sin instrucciones.";
            let iframe = document.getElementById('det_iframe');
            document.getElementById('det_video_container').style.display = 'none';
            iframe.src = "";
            
            document.getElementById('modal_ejercicios').classList.remove('activo');
            document.getElementById('modal_detalle_ejercicio').classList.add('activo');

            fetch('/api/ejercicio/' + ej.id_ejercicio + '/video')
                .then(res => res.json())
                .then(data => {
                    if (data.video_youtube) {
                        iframe.src = 'https://www.youtube.com/embed/' + data.video_youtube + '?rel=0';
                        document.getElementById('det_video_container').style.display = 'block';
                    }
                });
        }

        function agregarALaRutina(){
            ejerciciosEnRutina.push({
                id: ejercicioSeleccionadoTemporal.id_ejercicio,
                nombre: ejercicioSeleccionadoTemporal.nombre_espanol || ejercicioSeleccionadoTemporal.nombre,
                sets: document.getElementById('input_sets').value,
                reps: document.getElementById('input_reps').value,
                rest: document.getElementById('input_rest').value
            });
            actualizarVistaPrevia();
            cerrarModalDetalle();
        }

        function actualizarVistaPrevia() {
            let listaHTML = document.getElementById('lista_vista_previa');
            listaHTML.innerHTML = ejerciciosEnRutina.length ? "" : "No hay ejercicios.";
            ejerciciosEnRutina.forEach((ej, index) => {
                listaHTML.innerHTML += `<li class="item-preview"><div class="item-preview-info"><strong>${index+1}. ${ej.nombre}</strong><small>${ej.sets} series x ${ej.reps} (${ej.rest}s)</small></div><button class="btn-quitar" onclick="eliminarDeLista(${index})">Eliminar</button></li>`;
            });
        }

        function eliminarDeLista(index) { ejerciciosEnRutina.splice(index, 1); actualizarVistaPrevia(); }
        function cerrarModalDetalle() { document.getElementById('modal_detalle_ejercicio').classList.remove('activo'); document.getElementById('det_iframe').src = ""; }
        function abrirModalEjercicios() { document.getElementById('modal_ejercicios').classList.add('activo'); }
        function cerrarModalEjercicios() { document.getElementById('modal_ejercicios').classList.remove('activo'); }
        function volverAGrupos() { cerrarModalEjercicios(); abrirModalGrupos(); }
        function volverAEjercicios() { cerrarModalDetalle(); abrirModalEjercicios(); }

        function guardarCambios(){
            let btn = document.querySelector('.btn-azul');
            btn.innerText = "Guardando..."; btn.disabled = true;
            fetch('/rutinas/{{ $rutina->id_rutinas }}', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': tokenCSRF },
                body: JSON.stringify({
                    nombre: document.getElementById('nombre_rutina').value,
                    descripcion: document.getElementById('descripcion_rutina').value,
                    dia_asignado: document.getElementById('dia_asignado').value,
                    ejercicios: ejerciciosEnRutina
                })
            }).then(res => res.json()).then(data => {
                if(data.success) window.location.href = "/rutinas/{{ $rutina->id_rutinas }}";
            });
        }
    </script>
</body>
</html>