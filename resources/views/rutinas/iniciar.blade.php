<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamiento Activo - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --bg-oscuro: #1e293b;
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #10b981;
            --peligro-borrar: #ef4444;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-app); 
            color: var(--texto-oscuro);
            margin: 0; padding: 15px; box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        .app-container { 
            max-width: 600px; margin: 0 auto; padding-bottom: 40px;
            overflow-x: hidden;
        }

        /* ========================================================
           ✨ ANIMACIONES CORE ✨
           ======================================================== */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(30px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .timer-card { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        #panel_activo { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.15s forwards; }
        #panel_cola { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards; }

        .animar-cambio-ejercicio {
            animation: slideInRight 0.4s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        /* 2. CRONÓMETRO Y CONTROLES */
        .timer-card { 
            background: var(--bg-oscuro); color: var(--blanco);
            border-radius: 24px; padding: 20px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15); margin-bottom: 25px;
            position: sticky; top: 15px; z-index: 100;
        }

        .timer-display {
            font-size: 40px; font-weight: 800; font-variant-numeric: tabular-nums;
            letter-spacing: -1px; text-align: center; flex: 1;
        }

        .btn-control { 
            background: rgba(255,255,255,0.15); color: var(--blanco);
            border: none; border-radius: 50%; width: 55px; height: 55px; 
            cursor: pointer; transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.2s;
            display: flex; justify-content: center; align-items: center;
            backdrop-filter: blur(5px);
        }
        .btn-control:active { transform: scale(0.85); background: rgba(255,255,255,0.25); }

        /* 3. PANELES Y TARJETAS */
        .card-app { 
            background: var(--blanco); padding: 25px 20px; 
            border-radius: 24px; box-shadow: 0 6px 15px rgba(0,0,0,0.03);
            margin-bottom: 20px;
        }

        .panel-titulo {
            margin: 0; color: var(--texto-oscuro); font-size: 20px; font-weight: 800;
            line-height: 1.2;
        }

        .header-ejercicio { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 10px;}

        .btn-skip { 
            background: #fee2e2; color: var(--peligro-borrar); flex-shrink: 0;
            border: none; padding: 8px 12px; border-radius: 12px; 
            font-weight: 700; font-size: 13px; cursor: pointer; transition: transform 0.1s;
            display: flex; align-items: center; gap: 4px;
        }
        .btn-skip:active { transform: scale(0.95); }

        /* 4. DISEÑO DE LAS SERIES */
        .serie-row {
            background: var(--blanco); padding: 18px 20px; margin-bottom: 12px; 
            border-radius: 16px; border: 2px solid #f3f4f6; 
            display: flex; justify-content: space-between; align-items: center; 
            cursor: pointer; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .serie-row:active { transform: scale(0.97); }
        .serie-row.activa { border-color: var(--verde-exito); background: #f0fdf4; }

        .serie-info { display: flex; flex-direction: column; gap: 4px; transition: color 0.3s; }
        .serie-info strong { font-size: 18px; color: var(--texto-oscuro); font-weight: 800; }
        .serie-info span { font-size: 14px; color: var(--texto-gris); font-weight: 600; }
        .serie-row.activa .serie-info strong { color: var(--verde-exito); }

        .serie-check {
            width: 32px; height: 32px; border-radius: 50%; border: 3px solid #d1d5db; 
            display: flex; justify-content: center; align-items: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); color: transparent;
        }
        
        .serie-row.activa .serie-check {
            background: var(--verde-exito); border-color: var(--verde-exito); color: var(--blanco);
            animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        /* 5. DISEÑO DE LA COLA */
        .seccion-cola h3 { font-size: 16px; color: var(--texto-gris); margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 1px;}
        .cola-item {
            padding: 12px 15px; margin-bottom: 8px; border-radius: 12px; 
            background: #f8fafc; color: var(--texto-gris); font-weight: 600; font-size: 15px;
            display: flex; align-items: center; gap: 10px; transition: opacity 0.3s;
        }
        .cola-dot { width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%; }

        /* 6. PANTALLA FINAL DE VICTORIA */
        .pantalla-final {
            text-align: center; padding: 40px 20px; 
            background: var(--blanco); border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            display: flex; flex-direction: column; align-items: center;
        }

        .trofeo-icon {
            color: #fbbf24; width: 64px; height: 64px; margin-bottom: 15px;
            filter: drop-shadow(0 4px 10px rgba(251, 191, 36, 0.3));
        }

        .pantalla-final h2 { color: var(--texto-oscuro); font-size: 28px; margin: 0 0 10px 0; font-weight: 800;}
        .tiempo-resumen { font-size: 45px; font-weight: 800; color: var(--azul-boton); margin: 20px 0; font-variant-numeric: tabular-nums; }

        .btn-guardar-final {
            background: var(--verde-exito); color: var(--blanco); border: none; 
            padding: 20px; font-size: 18px; font-weight: 800; border-radius: 20px; 
            cursor: pointer; width: 100%; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
            transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-guardar-final:active { transform: scale(0.95); }

        /* NUEVO BOTÓN PARA DESCARTAR */
        .btn-descartar-final {
            background: transparent; color: var(--texto-gris); border: none; 
            padding: 15px; font-size: 15px; font-weight: 700; border-radius: 20px; 
            cursor: pointer; width: 100%; margin-top: 10px;
            transition: color 0.15s;
        }
        .btn-descartar-final:active { color: var(--peligro-borrar); }

        /* 7. SVGs GLOBALES */
        .svg-icon { width: 26px; height: 26px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .check-svg { width: 20px; height: 20px; stroke: currentColor; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round; }

        /* 8. MODAL FLOTANTE ANIMADO PARA EL GIF */
        .modal-overlay-gif {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            display: flex; justify-content: center; align-items: center;
            z-index: 2000; opacity: 0; pointer-events: none; 
            transition: opacity 0.3s ease;
        }
        .modal-overlay-gif.activo { opacity: 1; pointer-events: auto; }

        .contenedor-gif-animado {
            position: relative; width: 90%; max-width: 400px;
            transform: scale(0.7) translateY(40px); opacity: 0; 
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); 
        }
        
        .modal-overlay-gif.activo .contenedor-gif-animado {
            transform: scale(1) translateY(0); opacity: 1;
        }

        .contenedor-gif-animado img {
            width: 100%; border-radius: 24px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 4px solid var(--blanco); background: var(--blanco);
            object-fit: cover; aspect-ratio: 1/1;
        }

        .btn-cerrar-gif {
            position: absolute; top: -15px; right: -15px;
            background: var(--peligro-borrar); color: var(--blanco);
            border: none; width: 40px; height: 40px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            cursor: pointer; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 10;
        }
        .btn-cerrar-gif:active { transform: scale(0.8); }
        .btn-cerrar-gif svg { width: 20px; height: 20px; stroke: currentColor; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <div class="timer-card">
            <button onclick="toggleCronometro()" class="btn-control">
                <svg class="svg-icon" id="icon_pause" viewBox="0 0 24 24"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                <svg class="svg-icon" id="icon_play" viewBox="0 0 24 24" style="display:none;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </button>
            
            <div class="timer-display" id="cronometro_display">00:00:00</div>
            
            <button onclick="finalizarRutina()" class="btn-control" style="background: rgba(239, 68, 68, 0.2); color: #fca5a5;">
                <svg class="svg-icon" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/></svg>
            </button>
        </div>

        <div id="main_workout_area">
            <div class="card-app" id="panel_activo">
                <div class="header-ejercicio">
                    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <img id="gif_ejercicio" src="" alt="gif" style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover; border: 2px solid #f3f4f6; display: none; cursor: pointer; transition: transform 0.2s;" onactive="this.style.transform='scale(0.9)'">
                        <h2 class="panel-titulo" id="titulo_ejercicio">Cargando...</h2>
                    </div>
                    <button onclick="descartarEjercicio()" class="btn-skip">
                        Saltar <svg style="width: 14px; height:14px; stroke:currentColor; stroke-width:2.5; fill:none;" viewBox="0 0 24 24"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
                    </button>
                </div>
                
                <div id="contenedor_series"></div>
            </div>

            <div class="seccion-cola" id="panel_cola">
                <h3>Próximos Ejercicios</h3>
                <div id="contenedor_cola"></div>
            </div>
        </div>

    </div>

    <div id="modal_gif_grande" class="modal-overlay-gif" onclick="cerrarGifEnGrande()">
        <div class="contenedor-gif-animado" onclick="event.stopPropagation()">
            <button class="btn-cerrar-gif" onclick="cerrarGifEnGrande()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <img id="img_gif_grande" src="" alt="Demostración completa">
        </div>
    </div>

    @php 
    $rutinaActivaJS= $rutina->ejercicios->map(function($pivot){
        $seriesDesempacadas=[];
        for($i = 0; $i<$pivot->target_sets; $i++){
            $seriesDesempacadas[]=[
            'reps_objetivo'=>$pivot->target_reps,
            'estado'=>null
            ];
        }

        return[
        'id_ejercicio'=>$pivot->ejercicio_id,
        'nombre'=>$pivot->detalleEjercicio->nombre_espanol ?? $pivot->detalleEjercicio->nombre,
        'gif_url'=>$pivot->detalleEjercicio->gif_url ?? null,
        'descanso_segundos'=> $pivot->rest_seconds,
        'series'=>$seriesDesempacadas
        ];
    });
    @endphp

    <script>
        let rutinaId = {{ $rutina->id_rutinas}};
        let segundosTotales = 0; 
        let intervaloCronometro = null;
        let cronometroCorriendo = false;
        let rutinaActiva=@json($rutinaActivaJS);
        let ejercicioActualIndex = 0;

        function renderizarPantalla(){
            if(ejercicioActualIndex >= rutinaActiva.length){
                mostrarPantallaFinal();
                return;
            }
            renderizarEjercicioActivo();
            renderizarCola();
        }

        function renderizarEjercicioActivo(){
            let ejercicio = rutinaActiva[ejercicioActualIndex];
            
            document.getElementById('titulo_ejercicio').innerText = ejercicio.nombre;
            
            let gifElement = document.getElementById('gif_ejercicio');
            if (ejercicio.gif_url) {
                let urlCompleta = '/storage/' + ejercicio.gif_url;
                gifElement.src = urlCompleta;
                gifElement.style.display = 'block';
                
                gifElement.onclick = function() {
                    abrirGifEnGrande(urlCompleta);
                };
            } else {
                gifElement.style.display = 'none';
            }
            
            let contenedor = document.getElementById('contenedor_series');
            let html = '';
            
            ejercicio.series.forEach((serie, index) => {
                let numSerie = index + 1;
                let estaCompletada = (serie.estado === 'completada');
                
                let claseActiva = estaCompletada ? 'activa' : '';
                let iconoCheck = estaCompletada ? '<svg class="check-svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' : '';

                html += `
                    <div class="serie-row ${claseActiva}" onclick="marcarSerie(${index})">
                        <div class="serie-info">
                            <strong>Serie ${numSerie}</strong>
                            <span>Objetivo: ${serie.reps_objetivo} reps</span>
                        </div>
                        <div class="serie-check">
                            ${iconoCheck}
                        </div>
                    </div>
                `;
            });
            
            contenedor.innerHTML = html;

            contenedor.classList.remove('animar-cambio-ejercicio');
            void contenedor.offsetWidth; 
            contenedor.classList.add('animar-cambio-ejercicio');
        }

        function abrirGifEnGrande(url) {
            document.getElementById('img_gif_grande').src = url;
            document.getElementById('modal_gif_grande').classList.add('activo');
        }

        function cerrarGifEnGrande() {
            document.getElementById('modal_gif_grande').classList.remove('activo');
            setTimeout(() => {
                document.getElementById('img_gif_grande').src = "";
            }, 300);
        }

        function renderizarCola(){
            let contenedor = document.getElementById('contenedor_cola');
            let html = '';

            for(let i = ejercicioActualIndex + 1; i < rutinaActiva.length; i++){
                html += `<div class="cola-item"><span class="cola-dot"></span> ${rutinaActiva[i].nombre}</div>`;
            }

            if (html === ''){
                html = `
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 16px; font-weight: 700; animation: fadeInUp 0.5s ease;">
                    <svg style="width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;" viewBox="0 0 24 24"><path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z"/></svg>
                    ¡Este es tu último ejercicio! Termina fuerte.
                </div>`;
            }
            
            contenedor.innerHTML = html;
        }

        function marcarSerie(indexSerieClickeada){
            let ejercicio = rutinaActiva[ejercicioActualIndex];

            if (ejercicio.series[indexSerieClickeada].estado === 'completada'){
                ejercicio.series[indexSerieClickeada].estado = null;
            }else{
                ejercicio.series[indexSerieClickeada].estado = 'completada';
            }

            renderizarEjercicioActivo();
            verificarAutoAvance();
        }

        function verificarAutoAvance(){
            let ejercicio = rutinaActiva[ejercicioActualIndex];
            let terminamosTodo = ejercicio.series.every(serie => serie.estado === 'completada');

            if (terminamosTodo){
                setTimeout(()=>{
                    ejercicioActualIndex++;
                    renderizarPantalla();
                }, 600); 
            }
        }

        function mostrarPantallaFinal(){
            document.querySelector('.timer-card').style.display = 'none';
            
            document.getElementById('main_workout_area').innerHTML = `
                <div class="pantalla-final">
                    <svg class="trofeo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                        <path d="M4 22h16"/>
                        <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                    </svg>
                    <h2>¡Rutina Completada!</h2>
                    <p style="color: var(--texto-gris); font-size: 16px; margin-bottom: 0;">Tiempo bajo tensión:</p>
                    <div class="tiempo-resumen">${formatearTiempo(segundosTotales)}</div>
                    
                    <button type="button" onclick="guardarEntrenamientoBD(event)" class="btn-guardar-final">
                        <svg class="svg-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar Entrenamiento
                    </button>
                    
                    <button type="button" onclick="salirSinGuardar()" class="btn-descartar-final">
                        Descartar y salir
                    </button>
                </div>
            `;    
        }

        function descartarEjercicio(){
            let ejercicio = rutinaActiva[ejercicioActualIndex];

            ejercicio.series.forEach(serie => {
                if(serie.estado !== 'completada'){
                    serie.estado = 'omitida';
                }
            });
            ejercicioActualIndex++;
            renderizarPantalla();
        }

        function formatearTiempo(segundos){
            let hrs = Math.floor(segundos/3600);
            let mins = Math.floor((segundos % 3600)/ 60);
            let secs = segundos % 60;

            let hDisplay = hrs < 10 ? "0" + hrs : hrs;
            let mDisplay = mins < 10 ? "0" + mins : mins;
            let sDisplay = secs < 10 ? "0" + secs : secs;

            return `${hDisplay}:${mDisplay}:${sDisplay}`;
        }

        function toggleCronometro (){
            let iconPause = document.getElementById('icon_pause');
            let iconPlay = document.getElementById('icon_play');

            if (cronometroCorriendo){
                clearInterval(intervaloCronometro);
                cronometroCorriendo = false;
                if(iconPause) { iconPause.style.display = 'none'; iconPlay.style.display = 'block'; }
            }else{
                cronometroCorriendo = true;
                if(iconPause) { iconPause.style.display = 'block'; iconPlay.style.display = 'none'; }
                
                intervaloCronometro = setInterval(()=>{
                    segundosTotales++;
                    document.getElementById('cronometro_display').innerText = formatearTiempo(segundosTotales);   
                }, 1000);
            }
        }

        function finalizarRutina(){
            clearInterval(intervaloCronometro);
            cronometroCorriendo = false;

            if (confirm("¿Deseas terminar tu entrenamiento ahora? Las series restantes se marcarán como No completadas.")){
                for (let i = ejercicioActualIndex; i < rutinaActiva.length; i++){
                    let ejercicio = rutinaActiva[i];
                    ejercicio.series.forEach(serie => {
                        if (serie.estado !== 'completada'){
                            serie.estado = 'omitida';
                        }
                    });
                }
                ejercicioActualIndex = rutinaActiva.length;
                renderizarPantalla();
            }else{
                toggleCronometro(); 
            }
        }

        // NUEVA FUNCIÓN DE DESCARTE TOTAL
        function salirSinGuardar(){
            if(confirm("¿Estás seguro de que deseas salir sin guardar? No se registrará este entrenamiento en tu progreso.")){
                window.location.href = '/dashboard';
            }
        }

        function guardarEntrenamientoBD(event){
            if (event) { event.preventDefault(); }
            
            let payload = {
                tiempo_total: segundosTotales,
                historial: rutinaActiva
            };
            
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let botonGuardar = document.querySelector('.btn-guardar-final');
            let textoOriginal = botonGuardar.innerHTML;
            botonGuardar.innerHTML = '<svg style="animation: spin 1s linear infinite;" class="svg-icon" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Guardando...';
            botonGuardar.disabled = true;

            // Desactivamos el botón de salir para evitar dobles clics accidentales
            let botonSalir = document.querySelector('.btn-descartar-final');
            if(botonSalir) botonSalir.style.pointerEvents = 'none';

            fetch(`/rutinas/${rutinaId}/guardar`, {
                method : 'POST', 
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
                if (datos.success) {
                    window.location.href = '/dashboard';
                } else {
                    alert("Error en la Base de Datos: " + datos.error);
                    botonGuardar.innerHTML = textoOriginal;
                    botonGuardar.disabled = false;
                    if(botonSalir) botonSalir.style.pointerEvents = 'auto';
                }
            })
            .catch(error => {
                console.error('Error de red:', error);
                alert("Ocurrió un error de conexión al intentar guardar.");
                botonGuardar.innerHTML = textoOriginal;
                botonGuardar.disabled = false;
                if(botonSalir) botonSalir.style.pointerEvents = 'auto';
            });
        }    
        
        const styleSheet = document.createElement("style");
        styleSheet.innerText = "@keyframes spin { 100% { transform: rotate(360deg); } }";
        document.head.appendChild(styleSheet);

        // ARRANQUE AUTOMÁTICO
        renderizarPantalla();
        toggleCronometro();
    </script>
</body>
</html>