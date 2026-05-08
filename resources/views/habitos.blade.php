<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Hábitos - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root { --bg-app: #f4f6f9; --blanco: #ffffff; --azul-boton: #1877f2; --verde-exito: #10b981; --texto-oscuro: #1f2937; --texto-gris: #6b7280; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--bg-app); color: var(--texto-oscuro); margin: 0; padding: 15px; box-sizing: border-box; -webkit-font-smoothing: antialiased; }
        .app-container { max-width: 600px; margin: 0 auto; padding-bottom: 100px; }
        
        /* HEADER ACTUALIZADO */
        .header-habitos { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding: 10px 5px; }
        .header-habitos h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; flex: 1; text-align: center; }
        
        .btn-back { background: var(--blanco); border: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro); transition: transform 0.15s; text-decoration: none; }
        .btn-back:active { transform: scale(0.9); }

        .btn-add-habito { background: var(--azul-boton); color: var(--blanco); border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3); transition: transform 0.2s; }
        .btn-add-habito:active { transform: scale(0.9); }
        
        /* RESTO DE ESTILOS */
        .habito-card { background: var(--blanco); padding: 18px; border-radius: 20px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px; transition: opacity 0.4s, transform 0.2s; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .habito-card.completado { opacity: 0.6; }
        .habito-check { width: 28px; height: 28px; border-radius: 50%; border: 2px solid #d1d5db; cursor: pointer; display: flex; justify-content: center; align-items: center; transition: all 0.3s; }
        .habito-check.active { background: var(--verde-exito); border-color: var(--verde-exito); color: var(--blanco); }
        .habito-info { flex: 1; }
        .habito-nombre { font-size: 17px; font-weight: 700; margin-bottom: 2px; display: block; }
        .habito-meta { font-size: 13px; color: var(--texto-gris); font-weight: 600; transition: color 0.3s; }
        .habito-controles { display: flex; align-items: center; gap: 12px; }
        .btn-step { background: #f3f4f6; border: none; width: 32px; height: 32px; border-radius: 10px; cursor: pointer; color: var(--texto-oscuro); display: flex; justify-content: center; align-items: center; font-weight: 800; transition: transform 0.1s; }
        .btn-step:active { transform: scale(0.9); }
        .progress-container { height: 6px; background: #e5e7eb; border-radius: 3px; margin-top: 8px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--azul-boton); transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.3s; }
        .btn-toggle-completados { background: transparent; color: var(--texto-gris); border: none; width: 100%; padding: 15px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 10px; transition: color 0.2s; }
        .btn-toggle-completados:active { color: var(--texto-oscuro); }
        .btn-toggle-completados svg { transition: transform 0.3s; }
        .btn-toggle-completados.abierto svg { transform: rotate(180deg); }
        .seccion-completados { display: none; margin-top: 15px; }
        .seccion-completados.visible { display: block; animation: fadeIn 0.3s ease; }
        .mensaje-todo-listo { text-align: center; padding: 30px 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 20px; color: #166534; animation: fadeIn 0.5s ease; }
        .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: flex-end; z-index: 1000; backdrop-filter: blur(4px); }
        .modal-content { background: var(--blanco); width: 100%; max-width: 600px; border-radius: 30px 30px 0 0; padding: 30px 20px; animation: slideUp 0.3s ease-out; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 14px; font-weight: 700; color: var(--texto-gris); margin-bottom: 8px; }
        .form-input { width: 100%; padding: 15px; border-radius: 15px; border: 2px solid #f3f4f6; font-size: 16px; box-sizing: border-box; outline: none; }
        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; }
    </style>
</head>
<body>

    <div class="app-container">
        <header class="header-habitos">
            <a href="/dashboard" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24" style="width: 18px; height: 18px;"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
            
            <h1>Hábitos</h1>
            
            <button class="btn-add-habito" onclick="abrirModal()">
                <svg class="svg-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </button>
        </header>

        @php 
            $pendientes = collect();
            $completados = collect();
            foreach($habitos as $habito) {
                $registroHoy = $habito->registros->first();
                if($registroHoy && $registroHoy->completado) { $completados->push($habito); } 
                else { $pendientes->push($habito); }
            }
        @endphp

        <div id="lista_pendientes">
            @forelse($pendientes as $habito)
                @php 
                    $registroHoy = $habito->registros->first();
                    $progresoActual = $registroHoy ? $registroHoy->progreso_actual : 0;
                    $porcentaje = ($habito->tipo == 'numerico' && $habito->meta_numerica > 0) ? ($progresoActual / $habito->meta_numerica) * 100 : 0;
                @endphp

                <div class="habito-card" id="habito_{{ $habito->id_habito }}">
                    @if($habito->tipo == 'binario')
                        <div class="habito-check" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, 0, 'binario', 0)">
                            <svg class="svg-icon" style="width:16px; height:16px;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="habito-info">
                            <span class="habito-nombre">{{ $habito->nombre }}</span>
                        </div>
                    @else
                        <div class="habito-info">
                            <span class="habito-nombre">{{ $habito->nombre }}</span>
                            <span class="habito-meta" id="texto_meta_{{ $habito->id_habito }}">{{ $progresoActual }} / {{ $habito->meta_numerica }} {{ $habito->unidad }}</span>
                            <div class="progress-container">
                                <div class="progress-bar" id="barra_{{ $habito->id_habito }}" style="width: {{ $porcentaje }}%;"></div>
                            </div>
                        </div>
                        <div class="habito-controles">
                            <button class="btn-step" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, -1, 'numerico', {{ $habito->meta_numerica }})">-</button>
                            <button class="btn-step" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, 1, 'numerico', {{ $habito->meta_numerica }})">+</button>
                        </div>
                    @endif
                </div>
            @empty
                @if($habitos->count() == 0)
                    <div style="text-align:center; padding: 40px; color: var(--texto-gris);">
                        <p>No tienes hábitos configurados.</p>
                        <p style="font-size: 14px;">Dale al botón + para empezar.</p>
                    </div>
                @endif
            @endforelse
        </div>

        <div id="mensaje_todo_listo" class="mensaje-todo-listo" style="display: {{ ($pendientes->count() == 0 && $habitos->count() > 0) ? 'block' : 'none' }};">
            <svg style="width: 40px; height: 40px; margin-bottom: 10px; stroke: currentColor; fill: none; stroke-width: 2;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <h3 style="margin: 0 0 5px 0;">¡Día perfecto!</h3>
            <p style="margin: 0; font-size: 14px;">Has completado todos tus hábitos de hoy.</p>
        </div>

        <button id="btn_toggle_completados" class="btn-toggle-completados" onclick="toggleCompletados()" style="display: {{ $completados->count() > 0 ? 'flex' : 'none' }};">
            <span id="texto_toggle">Mostrar Completados</span>
            <svg style="width: 16px; height: 16px; stroke: currentColor; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>

        <div id="lista_completados" class="seccion-completados">
            @foreach($completados as $habito)
                @php 
                    $registroHoy = $habito->registros->first();
                    $progresoActual = $registroHoy ? $registroHoy->progreso_actual : 0;
                    $porcentaje = ($habito->tipo == 'numerico' && $habito->meta_numerica > 0) ? ($progresoActual / $habito->meta_numerica) * 100 : 0;
                @endphp

                <div class="habito-card completado" id="habito_{{ $habito->id_habito }}">
                    @if($habito->tipo == 'binario')
                        <div class="habito-check active" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, 0, 'binario', 0)">
                            <svg class="svg-icon" style="width:16px; height:16px;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="habito-info">
                            <span class="habito-nombre">{{ $habito->nombre }}</span>
                        </div>
                    @else
                        <div class="habito-info">
                            <span class="habito-nombre">{{ $habito->nombre }}</span>
                            <span class="habito-meta" id="texto_meta_{{ $habito->id_habito }}" style="color: var(--verde-exito);">{{ $progresoActual }} / {{ $habito->meta_numerica }} {{ $habito->unidad }}</span>
                            <div class="progress-container">
                                <div class="progress-bar" id="barra_{{ $habito->id_habito }}" style="width: {{ $porcentaje }}%; background: var(--verde-exito);"></div>
                            </div>
                        </div>
                        <div class="habito-controles">
                            <button class="btn-step" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, -1, 'numerico', {{ $habito->meta_numerica }})">-</button>
                            <button class="btn-step" onclick="enviarProgresoAJAX({{ $habito->id_habito }}, 1, 'numerico', {{ $habito->meta_numerica }})">+</button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div id="modal_nuevo" class="modal">
        <div class="modal-content">
            <h2 style="margin: 0 0 20px 0; font-weight: 800;">Nuevo Hábito</h2>
            <form action="{{ route('habitos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">NOMBRE DEL HÁBITO</label>
                    <input type="text" name="nombre" class="form-input" placeholder="Ej: Tomar creatina" required>
                </div>

                <div class="form-group">
                    <label class="form-label">¿CADA CUÁNDO?</label>
                    <select name="frecuencia" class="form-input" required style="background: var(--blanco); cursor:pointer;">
                        <option value="diario">Todos los días</option>
                        <option value="semanal">Cada semana</option>
                        <option value="mensual">Cada mes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">TIPO DE META</label>
                    <input type="hidden" id="tipo_habito" name="tipo" value="binario">
                    <div style="display: flex; gap: 10px;">
                        <button type="button" id="btn_binario" onclick="seleccionarTipo('binario')" class="form-input" style="flex:1; background: #e0f2fe; color: var(--azul-boton); border-color: #bae6fd; font-weight: 800;">Binario (Sí/No)</button>
                        <button type="button" id="btn_numerico" onclick="seleccionarTipo('numerico')" class="form-input" style="flex:1; background: #f3f4f6; color: var(--texto-gris); font-weight: 600;">Numérico</button>
                    </div>
                </div>

                <div id="campos_numericos" style="display: none; gap: 10px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label class="form-label" style="font-size: 12px;">META (NÚMERO)</label>
                        <input type="number" name="meta_numerica" class="form-input" placeholder="Ej: 5">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label" style="font-size: 12px;">UNIDAD</label>
                        <input type="text" name="unidad" class="form-input" placeholder="Ej: gramos">
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px; margin-top: 30px;">
                    <button type="button" onclick="cerrarModal()" class="btn-primario" style="background: #f3f4f6; color: var(--texto-oscuro); flex:1; border:none; border-radius:15px; padding:15px; font-weight:700; margin-top:0;">Cancelar</button>
                    <button type="submit" class="btn-primario" style="background: var(--azul-boton); color: white; flex:2; border:none; border-radius:15px; padding:15px; font-weight:700; margin-top:0;">Crear Hábito</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModal() { document.getElementById('modal_nuevo').style.display = 'flex'; }
        function cerrarModal() { document.getElementById('modal_nuevo').style.display = 'none'; }
        window.onclick = function(event) { if (event.target == document.getElementById('modal_nuevo')) cerrarModal(); }

        function seleccionarTipo(tipo) {
            document.getElementById('tipo_habito').value = tipo;
            let btnBinario = document.getElementById('btn_binario');
            let btnNumerico = document.getElementById('btn_numerico');
            let camposNumericos = document.getElementById('campos_numericos');

            if (tipo === 'binario') {
                btnBinario.style.cssText = 'flex:1; background: #e0f2fe; color: var(--azul-boton); border-color: #bae6fd; font-weight: 800;';
                btnNumerico.style.cssText = 'flex:1; background: #f3f4f6; color: var(--texto-gris); border-color: #f3f4f6; font-weight: 600;';
                camposNumericos.style.display = 'none';
            } else {
                btnNumerico.style.cssText = 'flex:1; background: #e0f2fe; color: var(--azul-boton); border-color: #bae6fd; font-weight: 800;';
                btnBinario.style.cssText = 'flex:1; background: #f3f4f6; color: var(--texto-gris); border-color: #f3f4f6; font-weight: 600;';
                camposNumericos.style.display = 'flex';
            }
        }

        function toggleCompletados() {
            const seccion = document.getElementById('lista_completados');
            const btn = document.getElementById('btn_toggle_completados');
            const texto = document.getElementById('texto_toggle');

            if (seccion.classList.contains('visible')) {
                seccion.classList.remove('visible');
                btn.classList.remove('abierto');
                texto.innerText = 'Mostrar Completados';
            } else {
                seccion.classList.add('visible');
                btn.classList.add('abierto');
                texto.innerText = 'Ocultar Completados';
            }
        }

        function enviarProgresoAJAX(habitoId, cambio, tipo, meta) {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/habitos/${habitoId}/progreso`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ cambio: cambio }) 
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    actualizarUI(habitoId, data.progreso_actual, data.completado, tipo, meta);
                }
            })
            .catch(error => console.error("Error al guardar:", error));
        }

        function actualizarUI(id, progreso, completado, tipo, meta) {
            const card = document.getElementById('habito_' + id);
            const listaPendientes = document.getElementById('lista_pendientes');
            const listaCompletados = document.getElementById('lista_completados');
            
            if(tipo === 'binario'){
                const check = card.querySelector('.habito-check');
                if(completado) {
                    check.classList.add('active');
                    card.classList.add('completado');
                    listaCompletados.prepend(card);
                } else {
                    check.classList.remove('active');
                    card.classList.remove('completado');
                    listaPendientes.appendChild(card);
                }
            } else {
                const textoMeta = document.getElementById('texto_meta_' + id);
                const barra = document.getElementById('barra_' + id);
                let unidadOriginal = textoMeta.innerText.split(" ").pop();
                textoMeta.innerText = `${progreso} / ${meta} ${unidadOriginal}`;
                
                let porcentaje = (progreso / meta) * 100;
                barra.style.width = porcentaje + '%';

                if(completado) {
                    card.classList.add('completado');
                    textoMeta.style.color = 'var(--verde-exito)';
                    barra.style.background = 'var(--verde-exito)';
                    listaCompletados.prepend(card);
                } else {
                    card.classList.remove('completado');
                    textoMeta.style.color = 'var(--texto-gris)';
                    barra.style.background = 'var(--azul-boton)';
                    listaPendientes.appendChild(card);
                }
            }
            actualizarEstadoGeneral();
        }

        function actualizarEstadoGeneral() {
            const listaPendientes = document.getElementById('lista_pendientes');
            const listaCompletados = document.getElementById('lista_completados');
            const btnToggle = document.getElementById('btn_toggle_completados');
            const mensajeListo = document.getElementById('mensaje_todo_listo');
            
            if (listaCompletados.children.length > 0) { btnToggle.style.display = 'flex'; } 
            else { btnToggle.style.display = 'none'; listaCompletados.classList.remove('visible'); }

            const tarjetasPendientes = listaPendientes.querySelectorAll('.habito-card').length;
            if (tarjetasPendientes === 0 && listaCompletados.children.length > 0) {
                mensajeListo.style.display = 'block';
            } else {
                mensajeListo.style.display = 'none';
            }
        }
    </script>
</body>
</html>