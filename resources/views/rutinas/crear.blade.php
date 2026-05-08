<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Rutina - Enerkoi</title>
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

        .app-container {
            max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px;
        }

        /* 2. HEADER Y TARJETAS */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
        }
        .top-nav h1 { margin: 0; font-size: 24px; font-weight: 800; color: var(--texto-oscuro); }

        .card-app {
            background: var(--blanco); border-radius: 24px; padding: 25px 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        .card-app h3 {
            margin: 0 0 20px 0; font-size: 18px; font-weight: 800;
            color: var(--texto-oscuro); display: flex; align-items: center; gap: 8px;
        }

        /* 3. INPUTS BASICOS */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; color: var(--texto-oscuro); }
        
        .input-app {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s;
        }
        .input-app:focus { border-color: var(--azul-boton); background: var(--blanco); }

        select.input-app { 
            appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'/%3e%3c/svg%3e"); 
            background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; 
            padding-right: 45px; cursor: pointer;
        }

        /* 4. BOTONES DISPARADORES DE MODALES */
        .btn-selector-modal {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 600; box-sizing: border-box; background: var(--bg-app); 
            color: var(--texto-oscuro); cursor: pointer; display: flex; justify-content: space-between; align-items: center;
            transition: all 0.2s;
        }
        .btn-selector-modal:active { border-color: var(--azul-boton); transform: scale(0.98); }
        .btn-selector-modal.desactivado { opacity: 0.6; pointer-events: none; }

        /* 5. MODALES FLOTANTES (Bottom Sheets) */
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
            max-height: 85vh; overflow-y: auto;
            display: flex; flex-direction: column;
        }
        .modal-overlay.activo .modal-content { transform: translateY(0); }

        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h3 { margin: 0; font-size: 20px; font-weight: 800; text-transform: capitalize; flex-grow: 1; text-align: center; }
        .btn-cerrar-modal {
            background: rgba(0,0,0,0.05); border: none; width: 36px; height: 36px;
            border-radius: 50%; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }

        /* 6. CUADRICULA DE GRUPOS (Modal 1) */
        .grid-grupos { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .tarjeta-grupo {
            position: relative; border-radius: 20px; overflow: hidden; aspect-ratio: 1 / 1; 
            cursor: pointer; background: var(--blanco); box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.1s;
        }
        .tarjeta-grupo:active { transform: scale(0.95); }
        .tarjeta-grupo img { width: 100%; height: 100%; object-fit: cover; }
        .tarjeta-grupo .overlay {
            position: absolute; bottom: 0; left: 0; width: 100%; padding: 40px 15px 15px 15px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); color: var(--blanco); 
            font-weight: 800; font-size: 16px; box-sizing: border-box; text-transform: capitalize;
        }

        /* 7. LISTA VISUAL DE EJERCICIOS (Modal 2) */
        .grid-ejercicios-seleccion { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .item-ejercicio-seleccion {
            background: var(--blanco); border-radius: 18px; padding: 10px; text-align: center;
            border: 2px solid transparent; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0,0,0,0.03); cursor: pointer;
        }
        .item-ejercicio-seleccion:active { transform: scale(0.96); }
        .item-ejercicio-seleccion img {
            width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; margin-bottom: 8px; background: var(--bg-app);
        }
        .item-ejercicio-seleccion span { font-size: 14px; font-weight: 700; display: block; color: var(--texto-oscuro); text-transform: capitalize; line-height: 1.2; }

        /* 8. DISEÑO DEL DETALLE DE EJERCICIO Y PARÁMETROS (Modal 3) */
        .detalle-full { border-radius: 24px 24px 0 0; padding: 20px; }
        .video-container { position: relative; width: 100%; padding-bottom: 56.25%; height: 0; border-radius: 16px; overflow: hidden; background: #000; margin-bottom: 20px; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
        .card-descripcion { background: var(--blanco); padding: 15px; border-radius: 16px; margin-bottom: 20px; }
        .card-descripcion h4 { margin: 0 0 10px 0; font-size: 16px; }
        .card-descripcion p { font-size: 14px; color: var(--texto-gris); line-height: 1.5; margin: 0; }

        .grid-parametros { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; background: var(--blanco); padding: 15px; border-radius: 16px; }
        .grid-parametros .input-app { padding: 12px 5px; text-align: center; font-size: 16px; font-weight: 700; border-color: #e5e7eb; }
        .grid-parametros .form-label { text-align: center; font-size: 13px; color: var(--texto-gris); }

        .btn-primario { width: 100%; background: var(--verde-exito); color: var(--blanco); border: none; border-radius: 20px; padding: 20px; font-size: 18px; font-weight: 800; cursor: pointer; transition: transform 0.1s; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-primario:active { transform: scale(0.97); }
        
        /* 9. LISTA DE VISTA PREVIA (Página principal) */
        .lista-preview { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
        .item-preview { background: var(--bg-app); border-radius: 16px; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
        .item-preview-info strong { display: block; font-size: 15px; color: var(--texto-oscuro); margin-bottom: 4px; }
        .item-preview-info small { color: var(--texto-gris); font-size: 13px; font-weight: 500; }
        .btn-quitar { background: none; border: none; color: var(--rojo-papelera); padding: 5px; cursor: pointer; }
        .estado-vacio { text-align: center; color: var(--texto-gris); padding: 20px; font-size: 14px; }
        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/rutinas" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Nueva Rutina</h1>
        </nav>

        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Información Base</h3>
            
            <div class="form-group">
                <label class="form-label">Nombre de la Rutina</label>
                <input type="text" id="nombre_rutina" class="input-app" placeholder="Ej. Día de Pierna Pesado" required>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción (Opcional)</label>
                <textarea id="descripcion_rutina" class="input-app" rows="2" placeholder="Enfoque en hipertrofia y fuerza..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Día asignado (Opcional)</label>
                <select id="dia_asignado" class="input-app">
                    <option value="">-- Ninguno (Día libre) --</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sabado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
            </div>
        </div>
        
        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M18 10h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"/><path d="M2 10h3v4H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Z"/><path d="M5 8h3v8H5Z"/><path d="M16 8h3v8h-3Z"/><path d="M8 11h8v2H8Z"/></svg> Construir Bloques</h3>
            
            <div class="form-group">
                <label class="form-label">1. Selecciona el músculo</label>
                <input type="hidden" id="input_grupo_oculto" value="">
                
                <div class="btn-selector-modal" onclick="abrirModalGrupos()">
                    <span id="texto_grupo_seleccionado">-- Toca para seleccionar --</span>
                    <svg style="width:18px; height:18px; color:#6b7280; stroke:currentColor; stroke-width:2; fill:none;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">2. Elige el ejercicio</label>
                
                <div class="btn-selector-modal desactivado" id="btn_selector_ejercicio" onclick="abrirModalEjercicios()">
                    <span id="texto_ejercicio_seleccionado" style="color: var(--texto-gris); font-weight: normal;">Primero elige un músculo arriba</span>
                    <svg style="width:18px; height:18px; color:#6b7280; stroke:currentColor; stroke-width:2; fill:none;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
            </div>
        </div>

        <div class="card-app">
            <h3><svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Tu rutina hasta ahora</h3>
            <ul id="lista_vista_previa" class="lista-preview">
                <div class="estado-vacio">Aún no has agregado ejercicios...</div>
            </ul>
        </div>

        <button onclick="guardarRutinaCompleta()" class="btn-primario">
            <svg class="svg-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Guardar Rutina Completa
        </button>

    </div>

    <div id="modal_grupos" class="modal-overlay" onclick="cerrarModalGruposAfuera(event)">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width: 36px;"></div> <h3>Músculos</h3>
                <button class="btn-cerrar-modal" onclick="cerrarModalGrupos()">
                    <svg style="width:20px; height:20px; stroke:#1f2937; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            
            <div class="grid-grupos">
                @foreach($grupos as $grupo)
                    <div class="tarjeta-grupo" onclick="seleccionarGrupo({{ $grupo->id_grupos_musculares }}, '{{ $grupo->nombre_espanol ?? $grupo->nombre }}')">
                        @if($grupo->gif_representativo)
                            <img src="{{ asset('storage/' . $grupo->gif_representativo) }}" alt="{{ $grupo->nombre_espanol ?? $grupo->nombre }}" loading="lazy">
                        @else
                            <div class="placeholder"><svg style="width:30px; opacity:0.5; stroke:currentColor; stroke-width:2; fill:none;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                        @endif
                        <div class="overlay">{{ $grupo->nombre_espanol ?? $grupo->nombre }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="modal_ejercicios" class="modal-overlay" onclick="cerrarModalEjerciciosAfuera(event)">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header">
                <button class="btn-cerrar-modal" style="background: transparent;" onclick="volverAGrupos()">
                    <svg style="width:24px; height:24px; stroke:#1f2937; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <h3 id="titulo_modal_ejercicios">Ejercicios</h3>
                <button class="btn-cerrar-modal" onclick="cerrarModalEjercicios()">
                    <svg style="width:20px; height:20px; stroke:#1f2937; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div id="contenedor_lista_ejercicios" class="grid-ejercicios-seleccion">
                <div class="estado-vacio" style="grid-column: 1 / -1;">Cargando...</div>
            </div>
        </div>
    </div>

    <div id="modal_detalle_ejercicio" class="modal-overlay" onclick="cerrarModalDetalleAfuera(event)">
        <div class="modal-content detalle-full">
            <div class="modal-header" style="margin-bottom: 15px;">
                <button class="btn-cerrar-modal" style="background: transparent;" onclick="volverAEjercicios()">
                    <svg style="width:24px; height:24px; stroke:#1f2937; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <h3 id="det_nombre">Detalle</h3>
                <button class="btn-cerrar-modal" onclick="cerrarModalDetalle()">
                    <svg style="width:20px; height:20px; stroke:#1f2937; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="modal-body">
                
                <div id="det_video_container" class="video-container" style="display:none;">
                    <iframe id="det_iframe" src="" allowfullscreen></iframe>
                </div>

                <div class="card-descripcion">
                    <h4>Técnica e Instrucciones</h4>
                    <p id="det_instrucciones"></p>
                </div>

                <h4 style="margin: 0 0 10px 0; text-align: center; color: var(--texto-oscuro);">Configura este ejercicio:</h4>
                <div class="grid-parametros">
                    <div>
                        <label class="form-label">Series</label>
                        <input type="number" id="input_sets" value="3" min="1" class="input-app">
                    </div>
                    <div>
                        <label class="form-label">Reps</label>
                        <input type="text" id="input_reps" value="10-12" class="input-app">
                    </div>
                    <div>
                        <label class="form-label">Desc. (s)</label>
                        <input type="number" id="input_rest" value="90" step="10" min="0" class="input-app">
                    </div>
                </div>

                <button class="btn-primario" onclick="agregarALaRutina()">
                    <svg class="svg-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Añadir a la Rutina
                </button>
            </div>
        </div>
    </div>

    <script>
        let ejerciciosEnRutina = [];
        let ejercicioSeleccionadoTemporal = null; 
        let tokenCSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ====== MODAL 1: GRUPOS ======
        function abrirModalGrupos() { document.getElementById('modal_grupos').classList.add('activo'); }
        function cerrarModalGrupos() { document.getElementById('modal_grupos').classList.remove('activo'); }
        function cerrarModalGruposAfuera(evento) {
            if(evento.target === document.getElementById('modal_grupos')) cerrarModalGrupos();
        }

        function seleccionarGrupo(idGrupo, nombreGrupo) {
            document.getElementById('input_grupo_oculto').value = idGrupo;
            
            let textoBtn = document.getElementById('texto_grupo_seleccionado');
            textoBtn.innerText = nombreGrupo;
            textoBtn.style.color = '#1877f2'; 
            textoBtn.style.fontWeight = '700';

            let btnEjercicio = document.getElementById('btn_selector_ejercicio');
            btnEjercicio.classList.remove('desactivado');
            document.getElementById('texto_ejercicio_seleccionado').innerText = "Toca para explorar ejercicios...";
            document.getElementById('texto_ejercicio_seleccionado').style.color = "var(--texto-oscuro)";
            document.getElementById('texto_ejercicio_seleccionado').style.fontWeight = "600";
            
            document.getElementById('titulo_modal_ejercicios').innerText = nombreGrupo;

            cerrarModalGrupos();
            buscarEjercicios(idGrupo); 
        }

        // ====== MODAL 2: EJERCICIOS ======
        function abrirModalEjercicios() { document.getElementById('modal_ejercicios').classList.add('activo'); }
        function cerrarModalEjercicios() { document.getElementById('modal_ejercicios').classList.remove('activo'); }
        function cerrarModalEjerciciosAfuera(e) {
            if(e.target === document.getElementById('modal_ejercicios')) cerrarModalEjercicios();
        }
        function volverAGrupos() {
            cerrarModalEjercicios();
            abrirModalGrupos();
        }

        function buscarEjercicios(grupoId){
            let contenedor = document.getElementById('contenedor_lista_ejercicios');
            contenedor.innerHTML = '<div class="estado-vacio" style="grid-column: 1 / -1;">Cargando catálogo...</div>';

            fetch('/api/ejercicios-del-grupo/'+grupoId)
            .then(res => res.json())
            .then(datos => {
                contenedor.innerHTML = '';
                if(datos.length === 0){
                    contenedor.innerHTML = '<div class="estado-vacio" style="grid-column: 1 / -1;">No hay ejercicios aquí todavía.</div>';
                    return;
                }

                datos.forEach(ej => {
                    let div = document.createElement('div');
                    div.className = 'item-ejercicio-seleccion';
                    let imgSrc = ej.gif_url ? '/storage/' + ej.gif_url : '/img/LOGOENERKOI.png'; 

                    div.innerHTML = `
                        <img src="${imgSrc}" alt="${ej.nombre_espanol || ej.nombre}" loading="lazy">
                        <span>${ej.nombre_espanol || ej.nombre}</span>
                    `;

                    div.onclick = function() { verDetalleEjercicio(ej); };
                    contenedor.appendChild(div);
                });
            });
        }

        // ====== MODAL 3: DETALLE (Con la magia del "Just in Time" para YouTube) ======
        function verDetalleEjercicio(ej) {
            ejercicioSeleccionadoTemporal = ej;
            
            // 1. Llenar datos de texto
            document.getElementById('det_nombre').innerText = ej.nombre_espanol || ej.nombre;
            document.getElementById('det_instrucciones').innerText = ej.descripcion || "Agrega este ejercicio a tus rutinas para dominar la técnica.";
            
            let videoCont = document.getElementById('det_video_container');
            let iframe = document.getElementById('det_iframe');
            
            // 2. Escondemos el video temporalmente por si tarda medio segundo en buscar
            videoCont.style.display = 'none';
            iframe.src = "";

            // 3. Transición: Cerrar el Modal 2, Abrir el Modal 3
            cerrarModalEjercicios();
            document.getElementById('modal_detalle_ejercicio').classList.add('activo');

            // 4. Magia: Vamos por el video a tu servidor en segundo plano
            fetch('/api/ejercicio/' + ej.id_ejercicio + '/video')
            .then(res => res.json())
            .then(data => {
                if (data.video_youtube) {
                    iframe.src = 'https://www.youtube.com/embed/' + data.video_youtube + '?rel=0';
                    videoCont.style.display = 'block'; // Lo mostramos cuando ya lo tenemos
                }
            })
            .catch(err => console.error("Error buscando video:", err));
        }

        function cerrarModalDetalle() {
            document.getElementById('modal_detalle_ejercicio').classList.remove('activo');
            document.getElementById('det_iframe').src = ""; // Apagar video
        }
        function cerrarModalDetalleAfuera(e) {
            if (e.target === document.getElementById('modal_detalle_ejercicio')) cerrarModalDetalle();
        }
        function volverAEjercicios() {
            cerrarModalDetalle();
            abrirModalEjercicios();
        }

        // ====== AGREGAR A LA LISTA ======
        function agregarALaRutina(){
            if(!ejercicioSeleccionadoTemporal){ return; }
            
            let sets = document.getElementById('input_sets').value;
            let reps = document.getElementById('input_reps').value;
            let rest = document.getElementById('input_rest').value;
            
            ejerciciosEnRutina.push({
                id: ejercicioSeleccionadoTemporal.id_ejercicio,
                nombre: ejercicioSeleccionadoTemporal.nombre_espanol || ejercicioSeleccionadoTemporal.nombre,
                sets: sets,
                reps: reps,
                rest: rest
            });

            actualizarVistaPrevia();
            cerrarModalDetalle();
        }

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
                        <button onclick="eliminarDeLista(${index})" class="btn-quitar">
                            <svg style="width:20px; height:20px; stroke:currentColor; stroke-width:2; fill:none; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </li>
                `;
            });
        }

        function eliminarDeLista(index){
            ejerciciosEnRutina.splice(index, 1);
            actualizarVistaPrevia();
        }

        // ====== GUARDAR RUTINA ======
        function guardarRutinaCompleta(){
            let dia = document.getElementById('dia_asignado').value;
            let nombre = document.getElementById('nombre_rutina').value;
            let desc = document.getElementById('descripcion_rutina').value;

            if(nombre === ""){ alert("Ponle un nombre a tu rutina."); return; }
            if(ejerciciosEnRutina.length === 0){ alert("Agrega al menos un ejercicio."); return; }

            let btnGuardar = document.querySelector('.btn-primario');
            let textoOriginal = btnGuardar.innerHTML;
            btnGuardar.innerHTML = "Guardando...";
            btnGuardar.disabled = true;

            let payload = {
                nombre: nombre,
                descripcion: desc,
                dia_asignado : dia,
                ejercicios: ejerciciosEnRutina
            };

            fetch('/rutinas',{
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': tokenCSRF
                },
                body : JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(respuesta => {
                if(respuesta.success){
                    alert("¡Rutina creada con éxito!");
                    window.location.href = "/rutinas";
                }
            })
            .catch(error => {
                console.error("Error al guardar:", error);
                alert("Hubo un error al guardar tu rutina.");
                btnGuardar.innerHTML = textoOriginal;
                btnGuardar.disabled = false;
            });
        }
    </script>
</body>
</html>