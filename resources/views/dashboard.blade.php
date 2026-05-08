<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
            --bg-app: #f4f6f9; 
            --bg-oscuro: #2c336b; 
            --bg-gradiente: linear-gradient(135deg, #3b4282, #1877f2);
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --rojo-papelera: #ef4444;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; padding: 0;
            background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased; 
        }

        .app-container { max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px; }

        @keyframes fadeSlideUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes pulseSoft { 0% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(1.15); opacity: 1; color: var(--azul-boton); } 100% { transform: scale(1); opacity: 0.8; } }
        @keyframes blurFadeIn { 0% { opacity: 0; backdrop-filter: blur(0px); } 100% { opacity: 1; backdrop-filter: blur(4px); } }

        .perfil-header   { animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .cta-iniciar     { opacity: 0; animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 0.1s forwards; }
        .seccion-titulo  { opacity: 0; animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 0.15s forwards; }
        .nav-grid        { opacity: 0; animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s forwards; }
        .rutinas-list    { opacity: 0; animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards; }
        
        .perfil-header { background: var(--bg-gradiente); border-radius: 24px; padding: 25px; color: var(--blanco); display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 25px rgba(24, 119, 242, 0.2); margin-bottom: 25px; position: relative; overflow: hidden; }
        .perfil-info h3 { margin: 0 0 5px 0; font-size: 24px; font-weight: 800; }
        .perfil-info p { margin: 0 0 15px 0; color: rgba(255,255,255,0.8); font-size: 14px; display: flex; align-items: center; gap: 6px; }
        .perfil-stats { display: flex; gap: 15px; font-size: 13px; }
        .perfil-stats div { background: rgba(0,0,0,0.2); padding: 5px 12px; border-radius: 12px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { position: absolute; top: 20px; right: 20px; background: none; border: none; color: rgba(255,255,255,0.6); font-size: 12px; cursor: pointer; text-decoration: underline; }

        .avatar-btn { position: relative; display: block; text-decoration: none; transition: transform 0.1s; }
        .avatar-btn:active { transform: scale(0.95); }
        .avatar-circle { width: 65px; height: 65px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; justify-content: center; align-items: center; overflow: hidden; backdrop-filter: blur(5px); border: 2px solid rgba(255,255,255,0.4); }
        .avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
        .ajustes-badge { position: absolute; bottom: -2px; right: -2px; background: var(--blanco); color: var(--texto-oscuro); width: 22px; height: 22px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .ajustes-badge svg { width: 12px; height: 12px; stroke-width: 2.5; }

        .cta-iniciar { display: flex; justify-content: center; align-items: center; gap: 10px; width: 100%; background: var(--blanco); border: 2px solid var(--azul-boton); border-radius: 20px; padding: 20px; font-size: 18px; font-weight: 800; color: var(--azul-boton); box-shadow: 0 8px 20px rgba(0,0,0,0.06); cursor: pointer; text-align: center; margin-bottom: 25px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease; }
        .cta-iniciar:active { transform: scale(0.95); box-shadow: 0 4px 10px rgba(0,0,0,0.04); }
        .cta-iniciar .cta-icon { animation: pulseSoft 2s infinite ease-in-out; }

        .seccion-titulo { font-size: 18px; font-weight: 700; margin-bottom: 15px; color: var(--texto-oscuro); }
        .nav-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
        .nav-card { background: var(--blanco); border-radius: 20px; padding: 20px 15px; text-align: center; text-decoration: none; color: var(--texto-oscuro); font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; align-items: center; gap: 10px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease; }
        .nav-card:active { transform: scale(0.93); box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
        .nav-card:nth-child(odd):last-child { grid-column: span 2; }

        .rutinas-list { background: var(--blanco); border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; }
        .rutina-item { display: flex; justify-content: space-between; align-items: center; padding: 18px 20px; text-decoration: none; color: var(--texto-oscuro); border-bottom: 1px solid #f0f0f0; transition: background 0.2s, padding-left 0.2s; }
        .rutina-item:last-child { border-bottom: none; }
        .rutina-item:active { background: #f9fafb; padding-left: 25px; }
        .rutina-info h4 { margin: 0 0 6px 0; font-size: 16px; font-weight: 700; }
        .rutina-info span { display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: var(--texto-gris); background: var(--bg-app); padding: 4px 10px; border-radius: 10px; font-weight: 600; }
        .icon-arrow { color: #ccc; font-size: 20px; font-weight: bold; transition: transform 0.2s;}
        .rutina-item:active .icon-arrow { transform: translateX(5px); color: var(--azul-boton); }
        .rutina-vacia { text-align: center; padding: 30px 20px; color: var(--texto-gris); }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; justify-content: center; align-items: flex-end; }
        .modal-overlay.active { display: flex; animation: blurFadeIn 0.3s ease-out forwards; }
        .modal-box { background: var(--blanco); width: 100%; max-width: 500px; padding: 30px 20px 40px 20px; border-radius: 24px 24px 0 0; box-shadow: 0 -10px 25px rgba(0,0,0,0.1); box-sizing: border-box; animation: slideUpModal 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUpModal { 0% { transform: translateY(100%); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        .modal-box select { width: 100%; padding: 16px; border-radius: 16px; border: 2px solid #e5e7eb; font-size: 16px; margin-bottom: 25px; background: var(--bg-app); outline: none; -webkit-appearance: none; }
        .modal-box select:focus { border-color: var(--azul-boton); }
        .modal-botones { display: flex; gap: 15px; }
        .btn-cancelar { flex: 1; background: #e5e7eb; color: var(--texto-gris); border: none; padding: 16px; border-radius: 16px; font-weight: 700; font-size: 16px; cursor: pointer; transition: transform 0.1s;}
        .btn-confirmar { flex: 2; background: var(--verde-exito); color: var(--blanco); border: none; padding: 16px; border-radius: 16px; font-weight: 700; font-size: 16px; cursor: pointer; transition: transform 0.1s;}
        .btn-cancelar:active, .btn-confirmar:active { transform: scale(0.95); }

        .stat-icon { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .cta-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .nav-icon-svg { width: 28px; height: 28px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; margin-bottom: 5px; }
        .date-icon { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; }

        /* ESTILOS DE HÁBITOS PARA EL DASHBOARD */
        .habito-card { background: var(--blanco); padding: 18px; border-radius: 20px; margin-bottom: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 15px; transition: all 0.4s ease; animation: fadeSlideUp 0.5s ease backwards; }
        .habito-card.completado { opacity: 0; transform: scale(0.9) translateY(10px); }
        .habito-check { width: 28px; height: 28px; border-radius: 50%; border: 2px solid #d1d5db; cursor: pointer; display: flex; justify-content: center; align-items: center; transition: all 0.3s; }
        .habito-check.active { background: var(--verde-exito); border-color: var(--verde-exito); color: var(--blanco); }
        .habito-info { flex: 1; }
        .habito-nombre { font-size: 16px; font-weight: 700; margin-bottom: 2px; display: block; }
        .habito-meta { font-size: 13px; color: var(--texto-gris); font-weight: 600; transition: color 0.3s;}
        .habito-controles { display: flex; align-items: center; gap: 12px; }
        .btn-step { background: #f3f4f6; border: none; width: 32px; height: 32px; border-radius: 10px; cursor: pointer; color: var(--texto-oscuro); display: flex; justify-content: center; align-items: center; font-weight: 800; transition: transform 0.1s;}
        .btn-step:active { transform: scale(0.9); }
        .progress-container { height: 6px; background: #e5e7eb; border-radius: 3px; margin-top: 8px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--azul-boton); transition: width 0.4s ease, background 0.3s; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <header class="perfil-header">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
            
            <div class="perfil-info">
                <h3>¡Hola, {{ Auth::user()->nombre }}!</h3>
                <p>
                    <svg class="stat-icon" viewBox="0 0 24 24"><path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z"/></svg>
                    Listo para romperla hoy
                </p>
                <div class="perfil-stats">
                    <div>
                        <svg class="stat-icon" viewBox="0 0 24 24"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
                        {{auth()->user()->perfil->peso_inicial}} kg
                    </div>
                    <div>
                        <svg class="stat-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        {{auth()->user()->perfil->objetivo}}
                    </div>
                </div>
            </div>

            <a href="/configuracion" class="avatar-btn">
                <div class="avatar-circle">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Tu Avatar">
                    @else
                        <svg width="35" height="35" fill="#fff" viewBox="0 0 16 16" style="stroke: none;"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>  
                    @endif
                </div>
                <div class="ajustes-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
            </a>
        </header>

        <button onclick="abrirSelectorRutina()" class="cta-iniciar">
            <svg class="cta-icon" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            INICIAR ENTRENAMIENTO
            <svg class="cta-icon" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        </button>

        

        <h3 class="seccion-titulo" style="margin-top: 30px;">Explorar</h3>
        <nav class="nav-grid">
            <a href="/rutinas" class="nav-card">
                <svg class="nav-icon-svg" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 14h6"/><path d="M9 18h6"/><path d="M9 10h.01"/></svg>
                Tus Rutinas
            </a>
            <a href="/progreso" class="nav-card">
                <svg class="nav-icon-svg" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                Tu Progreso
            </a>
            <a href="/ejercicios" class="nav-card">
                <svg class="nav-icon-svg" viewBox="0 0 24 24"><path d="M14.4 14.4 9.6 9.6M18.6 2.1l3.3 3.3c.4.4.4 1 0 1.4l-1.9 1.9c-.4.4-1 .4-1.4 0l-3.3-3.3c-.4-.4-.4-1 0-1.4l1.9-1.9c.4-.4 1-.4 1.4 0zm-15 15l3.3 3.3c.4.4.4 1 0 1.4l-1.9 1.9c-.4.4-1 .4-1.4 0l-3.3-3.3c-.4-.4-.4-1 0-1.4l1.9-1.9c.4-.4 1-.4 1.4 0z"/><path d="m14 6-2-2M10 2l2 2M6 14l-2-2M2 10l2 2"/></svg>
                Biblioteca
            </a>
            <a href="/habitos" class="nav-card">
                <svg class="nav-icon-svg" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                Hábitos
            </a>
            <a href="/rutinas/papelera" class="nav-card" style="color: var(--rojo-papelera);">
                <svg class="nav-icon-svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                Papelera
            </a>
        </nav>

        <h3 class="seccion-titulo" style="margin-top: 30px;">Hábitos Rápidos</h3>
        
        <div id="habitos_dashboard_container">
            @if(isset($habitosDashboard) && $habitosDashboard->count() > 0)
                @foreach($habitosDashboard as $habito)
                    @php 
                        $registroHoy = $habito->registros->first();
                        $progresoActual = $registroHoy ? $registroHoy->progreso_actual : 0;
                        $porcentaje = ($habito->tipo == 'numerico' && $habito->meta_numerica > 0) ? ($progresoActual / $habito->meta_numerica) * 100 : 0;
                    @endphp

                    <div class="habito-card" id="habito_dash_{{ $habito->id_habito }}">
                        @if($habito->tipo == 'binario')
                            <div class="habito-check" onclick="guardarHabitoDash({{ $habito->id_habito }}, 0, 'binario', 0)">
                                <svg class="stat-icon" style="width:16px; height:16px;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="habito-info">
                                <span class="habito-nombre">{{ $habito->nombre }}</span>
                            </div>
                        @else
                            <div class="habito-info">
                                <span class="habito-nombre">{{ $habito->nombre }}</span>
                                <span class="habito-meta" id="meta_dash_{{ $habito->id_habito }}">{{ $progresoActual }} / {{ $habito->meta_numerica }} {{ $habito->unidad }}</span>
                                <div class="progress-container">
                                    <div class="progress-bar" id="barra_dash_{{ $habito->id_habito }}" style="width: {{ $porcentaje }}%;"></div>
                                </div>
                            </div>
                            <div class="habito-controles">
                                <button class="btn-step" onclick="guardarHabitoDash({{ $habito->id_habito }}, -1, 'numerico', {{ $habito->meta_numerica }})">-</button>
                                <button class="btn-step" onclick="guardarHabitoDash({{ $habito->id_habito }}, 1, 'numerico', {{ $habito->meta_numerica }})">+</button>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <div id="mensaje_sin_habitos_dash" style="display: {{ (isset($habitosDashboard) && $habitosDashboard->count() > 0) ? 'none' : 'block' }}; text-align:center; padding: 20px; background: #f0fdf4; border-radius: 20px; color: #166534; border: 1px solid #bbf7d0; box-shadow: 0 4px 10px rgba(22, 101, 52, 0.05); margin-bottom: 25px;">
            <svg style="width: 30px; height: 30px; margin-bottom: 10px; stroke: currentColor; fill: none; stroke-width: 2;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <p style="margin: 0; font-weight: bold; font-size: 16px;">¡Todo limpio!</p>
            <p style="margin: 4px 0 0 0; font-size: 14px;">No hay más hábitos pendientes por hoy.</p>
        </div>

        <h3 class="seccion-titulo">Recientes</h3>
        <div class="rutinas-list">
            @forelse($ultimasRutinas as $rutina)
                <a href="/rutinas/{{ $rutina->id_rutinas }}" class="rutina-item">
                    <div class="rutina-info">
                        <h4>{{$rutina->nombre}}</h4>
                        @if($rutina->dia_asignado)
                            <span>
                                <svg class="date-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{$rutina->dia_asignado}}
                            </span>
                        @endif
                    </div>
                    <div class="icon-arrow">›</div>
                </a>
            @empty
                <div class="rutina-vacia">
                    <p>Aún no tienes rutinas registradas.</p>
                    <a href="/rutinas/crear" style="color: var(--azul-boton); font-weight: bold; text-decoration: none;">+ Crea tu primera rutina aquí</a>
                </div>
            @endforelse
        </div>
    </div> 

    <div id="modal_selector" class="modal-overlay">
        <div class="modal-box">
            <h2 style="margin-top:0; font-size: 22px;">¿Qué vamos a entrenar hoy?</h2>
            <p style="color: var(--texto-gris); margin-bottom: 20px;">Selecciona la rutina para encender el cronómetro.</p>
            <select id="select_rutina_id">
                <option value="">-- Elige una rutina --</option>
                @foreach($rutinas as $rutina)
                    <option value="{{ $rutina->id_rutinas }}">{{ $rutina->nombre }}</option>
                @endforeach
            </select>
            <div class="modal-botones">
                <button onclick="cerrarSelectorRutina()" class="btn-cancelar">Cancelar</button>
                <button onclick="confirmarInicioRutina()" class="btn-confirmar">¡De una!</button>
            </div>
        </div>
    </div>

    <script>
        function abrirSelectorRutina() { document.getElementById('modal_selector').classList.add('active'); }
        function cerrarSelectorRutina() { document.getElementById('modal_selector').classList.remove('active'); }
        function confirmarInicioRutina() {
            const id = document.getElementById('select_rutina_id').value;
            if (!id) { alert("Por favor, selecciona una rutina primero."); return; }
            const select = document.getElementById('select_rutina_id');
            if (confirm(`¿Listo para iniciar: "${select.options[select.selectedIndex].text}"?`)) { window.location.href = `/rutinas/${id}/iniciar`; }
        }

        // ==========================================
        // LÓGICA DE HÁBITOS PARA EL DASHBOARD
        // ==========================================
        function guardarHabitoDash(habitoId, cambio, tipo, meta) {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/habitos/${habitoId}/progreso`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ cambio: cambio }) 
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    actualizarUIDash(habitoId, data.progreso_actual, data.completado, tipo, meta);
                }
            })
            .catch(error => console.error("Error al guardar hábito:", error));
        }

        function actualizarUIDash(id, progreso, completado, tipo, meta) {
            const card = document.getElementById('habito_dash_' + id);
            
            if(tipo === 'numerico') {
                const textoMeta = document.getElementById('meta_dash_' + id);
                const barra = document.getElementById('barra_dash_' + id);
                let unidadOriginal = textoMeta.innerText.split(" ").pop();
                textoMeta.innerText = `${progreso} / ${meta} ${unidadOriginal}`;
                barra.style.width = ((progreso / meta) * 100) + '%';
            }
            
            // SI SE COMPLETA, ANIMAMOS Y BORRAMOS
            if(completado) {
                if(tipo === 'binario') {
                    card.querySelector('.habito-check').classList.add('active');
                } else {
                    document.getElementById('meta_dash_' + id).style.color = 'var(--verde-exito)';
                    document.getElementById('barra_dash_' + id).style.background = 'var(--verde-exito)';
                }
                
                setTimeout(() => {
                    card.classList.add('completado'); // Activa la animación CSS de desaparecer
                    
                    setTimeout(() => {
                        card.remove(); 
                        revisarSiQuedanHabitos(); 
                    }, 400); // Borra el elemento después de la animación
                }, 400); // Pausa corta para que vea que se marcó en verde
            }
        }

        function revisarSiQuedanHabitos() {
            const contenedor = document.getElementById('habitos_dashboard_container');
            const mensaje = document.getElementById('mensaje_sin_habitos_dash');
            
            if (contenedor.querySelectorAll('.habito-card').length === 0) {
                mensaje.style.display = 'block';
                mensaje.style.animation = 'fadeSlideUp 0.5s ease forwards';
            }
        }
    </script>
</body>
</html>