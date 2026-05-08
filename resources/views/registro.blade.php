<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --rojo-error: #ef4444;
        }

        /* 2. RESET Y CENTRADO ABSOLUTO */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; padding: 20px;
            background-color: var(--bg-app); 
            color: var(--texto-oscuro);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            min-height: 100vh; box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        /* 3. LA TARJETA DEL FORMULARIO */
        .registro-card {
            background-color: var(--blanco);
            padding: 40px 30px;
            border-radius: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            width: 100%;
            max-width: 450px; 
            box-sizing: border-box;
        }

        .registro-logo {
            width: 85px; height: auto; margin-bottom: 20px;
            display: block; margin-left: auto; margin-right: auto;
        }

        .registro-title {
            color: var(--texto-oscuro); margin-top: 0; margin-bottom: 5px;
            font-size: 24px; font-weight: 800; text-align: center;
        }
        
        .registro-subtitle {
            color: var(--texto-gris); margin-top: 0; margin-bottom: 30px;
            font-size: 15px; font-weight: 500; text-align: center;
        }

        /* 4. ALERTA DE ERRORES */
        .alert-error {
            background-color: #fef2f2;
            color: var(--rojo-error);
            border: 2px solid #fecaca;
            padding: 15px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-error ul { margin: 0; padding-left: 20px; }

        /* 5. ESTILOS DE LOS INPUTS Y GRID */
        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block; font-weight: 700; margin-bottom: 8px;
            color: var(--texto-oscuro); font-size: 14px;
        }

        .form-control {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s, background 0.2s;
        }

        .form-control:focus {
            border-color: var(--azul-boton); background: var(--blanco);
        }

        .grid-apellidos {
            display: grid; grid-template-columns: 1fr; gap: 0px;
        }

        @media (min-width: 480px) {
            .grid-apellidos { grid-template-columns: 1fr 1fr; gap: 15px; }
        }

        /* === ESTILOS PARA LOS CONTENEDORES DE CONTRASEÑA === */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container input {
            padding-right: 50px; /* Evita que el texto tape el ícono */
        }

        .btn-eye {
            position: absolute;
            right: 15px;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            color: var(--texto-gris);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
            outline: none;
        }

        .btn-eye:hover, .btn-eye:focus {
            color: var(--azul-boton);
        }

        .btn-eye svg {
            width: 22px;
            height: 22px;
        }

        /* 6. BOTÓN PRIMARIO */
        .btn-primario {
            background-color: var(--azul-boton); color: var(--blanco); border: none;
            padding: 18px; border-radius: 20px; cursor: pointer;
            font-weight: 800; font-size: 16px; width: 100%; margin-top: 15px;
            transition: transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 8px 20px rgba(24, 119, 242, 0.2);
        }

        .btn-primario:active { transform: scale(0.97); }

        /* 7. ENLACES INFERIORES */
        .footer-text {
            margin-top: 30px; font-size: 15px; color: var(--texto-gris);
            text-align: center; font-weight: 500;
        }

        .footer-text a {
            color: var(--azul-boton); text-decoration: none; font-weight: 800;
        }
    </style>
</head>

<body>
    <div class="registro-card">
        <img src="/img/LOGOENERKOI.png" alt="Logo Enerkoi" class="registro-logo">
        
        <h1 class="registro-title">Crear Cuenta</h1>
        <p class="registro-subtitle">Únete a Enerkoi y transforma tu entrenamiento.</p>
        
        @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/registro" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nombre(s)</label>
                <input type="text" name="nombre" class="form-control" placeholder="Como te llamas?" required>
            </div>

            <div class="grid-apellidos">
                <div class="form-group">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" name="apellido_p" class="form-control" placeholder="Tu apellido?" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Apellido Materno</label>
                    <input type="text" name="apellido_m" class="form-control" placeholder="Tu otro apellido?" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="tu@correo.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password_input" name="password" class="form-control" placeholder="••••••••" required minlength="8">
                    <button type="button" id="toggle_password" class="btn-eye" aria-label="Mostrar contraseña">
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg class="eye-open" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password_confirm_input" name="password_confirmation" class="form-control" placeholder="••••••••" required minlength="8">
                    <button type="button" id="toggle_password_confirm" class="btn-eye" aria-label="Mostrar contraseña">
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg class="eye-open" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group" style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px;">
                <input type="checkbox" id="terminos" name="terminos" required style="transform: scale(1.2);">
                <label for="terminos" style="font-size: 13px; color: var(--texto-gris);">
                    Acepto los <a href="/terminos" target="_blank" style="color: var(--azul-boton); font-weight: 700;">Términos y Condiciones</a>.
                </label>
            </div>

            <div class="form-group" style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 20px;">
                <input type="checkbox" id="newsletter" name="newsletter" value="1" style="transform: scale(1.2);">
                <label for="newsletter" style="font-size: 13px; color: var(--texto-gris); line-height: 1.4;">
                    Deseo recibir noticias, actualizaciones y consejos de entrenamiento en mi correo electrónico.
                </label>
            </div>

            <button type="submit" class="btn-primario">Registrarme</button>
        </form>

        <p class="footer-text">¿Ya tienes una cuenta?<br><a href="/login">Inicia sesión aquí</a></p>
    </div>

    <script>
        function configurarOjoPassword(btnId, inputId) {
            const toggleBtn = document.getElementById(btnId);
            const inputField = document.getElementById(inputId);
            const eyeClosed = toggleBtn.querySelector('.eye-closed');
            const eyeOpen = toggleBtn.querySelector('.eye-open');

            toggleBtn.addEventListener('click', function () {
                const tipoActual = inputField.getAttribute('type');
                const nuevoTipo = tipoActual === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', nuevoTipo);

                if (nuevoTipo === 'text') {
                    eyeClosed.style.display = 'none';
                    eyeOpen.style.display = 'block';
                } else {
                    eyeClosed.style.display = 'block';
                    eyeOpen.style.display = 'none';
                }
            });
        }

        // Activamos la función para ambos campos
        configurarOjoPassword('toggle_password', 'password_input');
        configurarOjoPassword('toggle_password_confirm', 'password_confirm_input');
    </script>
</body>
</html>