<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #10b981;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased;
        }

        .app-container {
            max-width: 600px; margin: 0 auto; padding: 20px; padding-bottom: 80px;
        }

        /* 2. HEADER DE NAVEGACIÓN */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.1s;
        }
        .btn-back:active { transform: scale(0.95); }
        .top-nav h1 { margin: 0; font-size: 24px; font-weight: 800; color: var(--texto-oscuro); }

        /* 3. TARJETAS DE CONFIGURACIÓN */
        .card-app {
            background: var(--blanco); border-radius: 24px; padding: 25px 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }

        .card-app h3 {
            margin: 0 0 20px 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro);
        }

        /* 4. SECCIÓN DEL AVATAR */
        .avatar-section {
            display: flex; flex-direction: column; align-items: center; gap: 15px;
        }

        .avatar-preview-container {
            position: relative; width: 120px; height: 120px;
        }

        .avatar-preview {
            width: 100%; height: 100%; border-radius: 50%; object-fit: cover;
            background-color: var(--bg-app); border: 4px solid var(--blanco);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .btn-edit-avatar {
            position: absolute; bottom: 0; right: 0;
            background: var(--azul-boton); color: var(--blanco); border: none;
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center; cursor: pointer;
            box-shadow: 0 4px 10px rgba(24, 119, 242, 0.3); transition: transform 0.1s;
        }
        .btn-edit-avatar:active { transform: scale(0.9); }

        /* Ocultamos el input de archivo real */
        input[type="file"] { display: none; }

        /* 5. FORMULARIOS NORMALES */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; color: var(--texto-oscuro); }
        .input-app {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s;
        }
        .input-app:focus { border-color: var(--azul-boton); background: var(--blanco); }

        /* 6. BOTÓN GUARDAR */
        .btn-primario {
            background: var(--verde-exito); color: var(--blanco); border: none; border-radius: 20px;
            padding: 20px; font-size: 18px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 10px;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25); transition: transform 0.1s;
            display: flex; justify-content: center; align-items: center; gap: 8px;
        }
        .btn-primario:active { transform: scale(0.97); }

        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <a href="/dashboard" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <h1>Ajustes de Perfil</h1>
        </nav>

        <form action="/perfil/actualizar" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="card-app">
                <div class="avatar-section">
                    <div class="avatar-preview-container">
                        <img id="vista_previa_avatar" 
                             src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('img/default-avatar.png') }}" 
                             alt="Tu Avatar" 
                             class="avatar-preview">
                        
                        <button type="button" class="btn-edit-avatar" onclick="document.getElementById('input_avatar').click()">
                            <svg style="width: 18px; height: 18px; stroke: currentColor; stroke-width: 2.5; fill: none;" viewBox="0 0 24 24">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </button>
                    </div>
                    <p style="margin:0; font-size: 14px; color: var(--texto-gris); font-weight: 500;">Toca el ícono para cambiar tu foto</p>
                    
                    <input type="file" id="input_avatar" name="avatar" accept="image/jpeg, image/png, image/jpg" onchange="previsualizarImagen(event)">
                </div>
            </div>

            <div class="card-app">
                <h3>Información Personal</h3>
                
                <div class="form-group">
                    <label class="form-label">Nombre(s)</label>
                    <input type="text" name="nombre" class="input-app" value="{{ auth()->user()->nombre }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="input-app" value="{{ auth()->user()->email }}" required>
                </div>
            </div>

            @if($errors->any())
                <div style="background: #fee2e2; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 15px; font-size: 14px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn-primario">
                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Guardar Cambios
            </button>
        </form>

    </div>

    <script>
        function previsualizarImagen(event) {
            const input = event.target;
            
            // Si el usuario seleccionó un archivo
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Cambiamos la propiedad 'src' de la etiqueta img
                    document.getElementById('vista_previa_avatar').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>