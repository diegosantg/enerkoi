<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        
        :root {
            --bg-oscuro : #3b4282;
            --bg-oscuro-resalte: #4a5296; 
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --verde-exito: #28a745;
            --texto-oscuro: #333;
            --texto-claro: #fff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .dashboard-container {
                grid-template-columns: 300px 1fr; /* Barra lateral de 300px, el resto para el contenido */
            }
        }

        
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-logo {
            width: 120px;
            height: auto;
            margin: 0 auto 10px auto;
            display: block;
        }

        .perfil-card {
            background-color: rgba(255, 255, 255, 0.08); /* Efecto cristal sutil */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .avatar {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* 4. NAVEGACIÓN MENÚ */
        .menu-nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-btn {
            background-color: rgba(255, 255, 255, 0.05); 
            color: var(--texto-claro);
            padding: 16px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s, padding-left 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
            padding-left: 25px; 
        }

        /* 5. CONTENIDO PRINCIPAL */
        .panel-principal {
            background: var(--bg-claro);
            padding: 30px;
            border-radius: 12px;
            color: var(--texto-oscuro);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .top-actions {
            margin-bottom: 25px;    
        }

        .action-btn {
            background-color: var(--verde-exito); 
            color: white;
            padding: 16px 25px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s, background 0.3s;
            width: 100%;
        }

        .action-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        /* 6. LISTA DE RUTINAS */
        .rutina-reciente {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 12px;
            text-decoration: none;
            color: var(--texto-oscuro);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .rutina-reciente:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.08);
            border-color: var(--azul-boton);
        }

        .rutina-vacia {
            background-color: transparent;
            border: 2px dashed #ccc;
            padding: 40px 20px;
            text-align: center;
            border-radius: 8px;
            color: #888;
        }

        /* 7. ESTILOS DEL MODAL (Código limpio, sin inline-styles) */
        .modal-overlay {
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.7); 
            z-index: 1000; 
            justify-content: center; 
            align-items: center;
            backdrop-filter: blur(3px); /* Efecto borroso de fondo */
        }

        .modal-box {
            background: white; 
            padding: 30px; 
            border-radius: 16px; 
            width: 90%; 
            max-width: 400px; 
            text-align: center; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            color: var(--texto-oscuro);
        }

        .modal-box select {
            width: 100%; 
            padding: 14px; 
            border-radius: 8px; 
            border: 2px solid #ddd; 
            font-size: 16px; 
            margin-bottom: 25px;
            box-sizing: border-box;
            outline: none;
        }
        .modal-box select:focus { border-color: var(--azul-boton); }

        .modal-botones {
            display: flex; 
            gap: 15px;
        }

        .btn-cancelar {
            flex: 1; 
            background: #eee; 
            color: #555;
            border: none; 
            padding: 14px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-cancelar:hover { background: #ddd; }

        .btn-confirmar {
            flex: 2; 
            background: var(--verde-exito); 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold;
            transition: opacity 0.2s;
        }
        .btn-confirmar:hover { opacity: 0.9; }

    </style>
</head>
<body>
    <div class="dashboard-container">
        
        <aside class="sidebar">
            

            <div class="perfil-card">
                <div>
                    <h3 style="margin: 0 0 5px 0; font-size: 20px;">¡Hola, {{ Auth::user()->nombre }}!</h3>
                    <p style="margin: 0 0 15px 0; font-size: 14px; color: #ccc;">¿Qué toca hoy?</p>
                    <small style="color: #aaa; display:block; margin-bottom: 3px;">Peso: <strong>{{auth()->user()->perfil->peso_inicial}} kg</strong></small>
                    <small style="color: #aaa; display:block; margin-bottom: 3px;">Estatura: <strong>{{auth()->user()->perfil->estatura}} cm</strong></small>
                    <small style="color: #aaa; display:block;">Objetivo: <strong style="color: #fff;">{{auth()->user()->perfil->objetivo }}</strong></small>
                    <br><form action="/logout" method="POST">
                        @csrf
                        <button type="submit">
                        Cerrar Sesion
                        </button>
                    </form>
                </div>

                 

                <div class="avatar">
                    <svg width="35" height="35" fill="#fff" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>  
                </div>
            </div>
            
            <nav class="menu-nav">
                <a href="/rutinas" class="menu-btn">Tus Rutinas</a>
                <a href="/ejercicios" class="menu-btn">Biblioteca de Ejercicios</a>
                <a href="/progreso" class="menu-btn">Tu Progreso</a>

                <a href="/rutinas/papelera" class="menu-btn" style="display: flex; justify-content: space-between; align-items: center;">
                    Papelera de Reciclaje <span>🗑️</span>
                </a>
            </nav>
        </aside>
        
        <main>
            <div class="top-actions">
                <button onclick="abrirSelectorRutina()" class="action-btn">
                    INICIAR RUTINA
                </button>
            </div> 
            
            <div class="panel-principal">
                <h3 style="margin-top: 0; color: var(--bg-oscuro); border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
                    Tus Últimas Rutinas
                </h3>  

                @forelse($ultimasRutinas as $rutina)
                <a href="/rutinas/{{ $rutina->id_rutinas }}" class="rutina-reciente">
                    <h4 style="margin: 0; font-size: 18px;">
                        {{$rutina->nombre}}
                    </h4>
                    @if($rutina->dia_asignado)
                    <small style="color: #666; background: #eee; padding: 4px 10px; border-radius: 12px;">
                        {{$rutina->dia_asignado}}
                    </small>
                    @endif
                </a>
                @empty
                <div class="rutina-vacia">
                    <p style="font-size: 18px; margin-bottom: 10px;">Aún no tienes rutinas registradas.</p>
                    <a href="/rutinas/crear" style="color: var(--azul-boton); font-weight: bold; text-decoration: none;">+ Crea tu primera rutina aquí</a>
                </div>
                @endforelse
            </div>
        </main>
    </div> 

    <div id="modal_selector" class="modal-overlay">
        <div class="modal-box">
            <h2 style="color: var(--bg-oscuro); margin-top:0;">¿Qué vamos a entrenar hoy?</h2>
            <p style="color:#666; margin-bottom: 20px;">Selecciona la rutina que quieres iniciar:</p>

            <select id="select_rutina_id">
                <option value="">-- Elige una rutina --</option>
                @foreach($rutinas as $rutina)
                    <option value="{{ $rutina->id_rutinas }}">{{ $rutina->nombre }}</option>
                @endforeach
            </select>

            <div class="modal-botones">
                <button onclick="cerrarSelectorRutina()" class="btn-cancelar">Cancelar</button>
                <button onclick="confirmarInicioRutina()" class="btn-confirmar">De una!</button>
            </div>
        </div>
    </div>

    <script>
        function abrirSelectorRutina() {
            document.getElementById('modal_selector').style.display = 'flex';
        }

        function cerrarSelectorRutina() {
            document.getElementById('modal_selector').style.display = 'none';
        }

        function confirmarInicioRutina() {
            const id = document.getElementById('select_rutina_id').value;

            if (!id) {
                alert("Por favor, selecciona una rutina primero.");
                return;
            }

            const select = document.getElementById('select_rutina_id');
            const nombreRutina = select.options[select.selectedIndex].text;

            if (confirm(`¿Estás listo para iniciar tu rutina: "${nombreRutina}"? El cronómetro empezará a correr.`)) {
                window.location.href = `/rutinas/${id}/iniciar`;
            }
        }
    </script>
</body>
</html>