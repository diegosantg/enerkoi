<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamiento Activo - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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

        /* 2. RESET Y ESTRUCTURA */
        body { 
            font-family: Arial, Helvetica, sans-serif;
            background-color: var(--bg-oscuro); 
            color: var(--texto-claro);
            margin: 0; 
            padding: 20px; 
            box-sizing: border-box;
        }

        .grid-container { 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 20px; 
            max-width: 1000px; 
            margin: 0 auto; 
        }

        @media (min-width: 768px) { 
            .grid-container { 
                /* 2/3 para el ejercicio activo, 1/3 para la cola */
                grid-template-columns: 2fr 1fr; 
            }
        }

        /* 3. EL CRONÓMETRO GIGANTE */
        .header-timer { 
            background: var(--bg-claro);
            color: var(--bg-oscuro);
            padding: 20px;
            text-align: center;
            border-radius: 16px;
            font-size: 45px; /* Más grande y visible */
            font-weight: bold;
            margin: 0 auto 25px auto;
            max-width: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .btn-control { 
            background: var(--bg-oscuro); 
            color: white;
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px; 
            font-size: 22px; 
            cursor: pointer; 
            transition: transform 0.2s, opacity 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-control:active { transform: scale(0.9); }

        /* 4. PANELES BLANCOS */
        .panel { 
            background: var(--bg-claro); 
            color: var(--texto-oscuro);
            padding: 25px; 
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .panel-titulo {
            margin-top: 0;
            color: var(--bg-oscuro);
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .btn-descartar { 
            background: var(--peligro-borrar); 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            border-radius: 8px; 
            float: right; 
            cursor: pointer; 
            font-weight: bold;
            margin-bottom: 15px;
            transition: opacity 0.2s;
        }

        .btn-descartar:hover { opacity: 0.85; }

        /* 5. DISEÑO DE LAS SERIES (Inyectado por JS) */
        .serie-item {
            background: white; 
            padding: 15px 20px; 
            margin-bottom: 12px; 
            border-radius: 10px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border: 2px solid #eee; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            font-size: 18px;
            font-weight: bold;
            color: #555;
            transition: border-color 0.3s;
        }

        /* Botón de Checkbox Gigante */
        .btn-check {
            width: 50px; 
            height: 50px; 
            cursor: pointer; 
            border-radius: 12px; 
            border: 3px solid #ccc; 
            background: #f8f9fa; 
            font-size: 24px; 
            color: white; 
            display: flex; 
            justify-content: center; 
            align-items: center;
            transition: all 0.2s;
        }

        /* Estado completado */
        .btn-check.completada {
            background: var(--verde-exito);
            border-color: var(--verde-exito);
        }
        .serie-item.activa {
            border-color: var(--verde-exito);
        }

        /* 6. DISEÑO DE LA COLA (Inyectado por JS) */
        .cola-item {
            background: white; 
            padding: 15px; 
            margin-bottom: 10px; 
            border-radius: 8px; 
            border: 1px solid #ddd; 
            color: #666;
            font-weight: bold;
        }

        /* 7. PANTALLA FINAL DE VICTORIA */
        .pantalla-final {
            text-align: center; 
            padding: 50px 20px; 
            background: var(--bg-claro); 
            border-radius: 16px; 
            grid-column: 1 / -1; /* Ocupa todo el ancho */
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .pantalla-final h2 {
            color: var(--bg-oscuro);
            font-size: 32px;
            margin-top: 0;
        }

        .btn-guardar-final {
            background: var(--verde-exito); 
            color: white; 
            border: none; 
            padding: 18px 40px; 
            font-size: 20px; 
            font-weight: bold;
            border-radius: 12px; 
            cursor: pointer; 
            margin-top: 25px; 
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
            transition: transform 0.2s;
        }

        .btn-guardar-final:active { transform: scale(0.95); }
    </style>
</head>
<body>
    <div class="header-timer">
        <button onclick="toggleCronometro()" class="btn-control" title="Pausar/Reanudar">⏯</button>
        <button onclick="finalizarRutina()" class="btn-control" title="Detener">⏹</button>
        <span id="cronometro_display">00:00:00</span>
    </div>

    <div class="grid-container">
        <div class="panel" id="panel_activo">
            <button onclick="descartarEjercicio()" class="btn-descartar">Descartar ejercicio ⏭</button>
            <div style="clear: both;"></div>
            
            <div id="contenedor_series">
                <p>Cargando ejercicio...</p>
            </div>
        </div>

        <div class="panel" id="panel_cola">
            <h3 class="panel-titulo" style="font-size: 20px;">Próximos Ejercicios</h3>
            <div id="contenedor_cola">
            </div>
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
            let contenedor = document.getElementById('contenedor_series');
            
            // Usando las clases CSS limpias
            let html = `<h2 class="panel-titulo">${ejercicio.nombre}</h2>`;
            
            ejercicio.series.forEach((serie, index) => {
                let numSerie = index + 1;
                let estaCompletada = (serie.estado === 'completada');
                
                // Asignamos clases en lugar de estilos en línea
                let claseCompletada = estaCompletada ? 'completada' : '';
                let claseActiva = estaCompletada ? 'activa' : '';
                let icono = estaCompletada ? '✔️' : '';

                html += `
                    <div class="serie-item ${claseActiva}">
                        <span>Serie ${numSerie} <small style="color:#888;">(Objetivo: ${serie.reps_objetivo} reps)</small></span>
                        <button onclick="marcarSerie(${index})" class="btn-check ${claseCompletada}">
                            ${icono}
                        </button>
                    </div>
                `;
            });
            
            contenedor.innerHTML = html;
        }

        function renderizarCola(){
            let contenedor = document.getElementById('contenedor_cola');
            let html = '';

            for(let i = ejercicioActualIndex + 1; i < rutinaActiva.length; i++){
                html += `<div class="cola-item">${rutinaActiva[i].nombre}</div>`;
            }

            if (html === ''){
                html = '<p style="color: #888; font-style : italic; text-align: center;">¡Este es tu último ejercicio de hoy! Dale con todo 💪</p>';
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
                }, 600); // Un pequeño retraso para que el usuario vea la palomita verde
            }
        }

        function mostrarPantallaFinal(){
            // Reemplaza todo el Grid con la pantalla de victoria
            document.querySelector('.grid-container').innerHTML = `
                <div class="pantalla-final">
                    <h2>¡Entrenamiento Finalizado! 🏆</h2>
                    <p style="font-size: 22px; color: #555; margin-bottom: 30px;">
                        Tiempo total de sudor: <strong>${formatearTiempo(segundosTotales)}</strong>
                    </p>
                    
                    <button type="button" onclick="guardarEntrenamientoBD(event)" class="btn-guardar-final">
                        Guardar Entrenamiento
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
            if (cronometroCorriendo){
                clearInterval(intervaloCronometro);
                cronometroCorriendo = false;
            }else{
                cronometroCorriendo = true;
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
                toggleCronometro(); // Reanuda si canceló
            }
        }

        function guardarEntrenamientoBD(event){
            // Frenamos cualquier recarga de página fantasma
            if (event) { event.preventDefault(); }
            
            let payload = {
                tiempo_total: segundosTotales,
                historial: rutinaActiva
            };
            
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let botonGuardar = document.querySelector('.btn-guardar-final');
            botonGuardar.innerText = 'Guardando en la bóveda...';
            botonGuardar.disabled = true;

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
                alert(datos.mensaje);
                window.location.href = '/dashboard';
            })
            .catch(error => {
                console.error('Enerkoi detectó un error en su servidor', error);
                alert("Ocurrió un error al guardar.");
                botonGuardar.innerText = "Reintentar";
                botonGuardar.disabled = false;
            });
        }    
        // ARRANQUE AUTOMÁTICO DE LA APLICACION
        renderizarPantalla();
        toggleCronometro();

    </script>
</body>
</html>