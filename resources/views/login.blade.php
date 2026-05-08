<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Enerkoi</title>
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
        .login-card {
            background-color: var(--blanco);
            padding: 40px 30px;
            border-radius: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            width: 100%;
            max-width: 450px; 
            box-sizing: border-box;
            text-align: center;
        }

        .login-logo {
            width: 85px; height: auto; margin-bottom: 20px;
            display: block; margin-left: auto; margin-right: auto;
        }

        .login-title {
            color: var(--texto-oscuro); margin-top: 0; margin-bottom: 5px;
            font-size: 26px; font-weight: 800; text-align: center;
        }
        
        .login-subtitle {
            color: var(--texto-gris); margin-top: 0; margin-bottom: 30px;
            font-size: 15px; font-weight: 500; text-align: center; line-height: 1.4;
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
            text-align: left;
        }

        .alert-error p { margin: 5px 0; }
        .alert-error p:first-child { margin-top: 0; }
        .alert-error p:last-child { margin-bottom: 0; }

        /* 5. ESTILOS DE LOS INPUTS Y CONTENEDOR DE CONTRASEÑA */
        .form-group { margin-bottom: 16px; text-align: left; }

        .form-group label {
            display: block; font-weight: 700; margin-bottom: 8px;
            color: var(--texto-oscuro); font-size: 14px;
        }

        .form-group input {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s, background 0.2s;
        }

        .form-group input:focus {
            border-color: var(--azul-boton); background: var(--blanco);
        }

        /* Contenedor relativo para poder flotar el ojito */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container input {
            padding-right: 50px; /* Espacio reservado para que el texto no se monte en el icono */
        }

        /* Botón del ojito */
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
            text-align: center; font-weight: 500; line-height: 1.5;
        }

        .footer-text a {
            color: var(--azul-boton); text-decoration: none; font-weight: 800;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <img src="/img/LOGOENERKOI.png" alt="Logo Enerkoi" class="login-logo">
        
        <h1 class="login-title">¡Ey!</h1>
        <p class="login-subtitle">Hace tiempo no nos veíamos, bienvenido de vuelta a Enerkoi.</p>

        @if ($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
            <p>• {{$error}}</p>
            @endforeach
        </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email')}}" placeholder="tu@correo.com" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password_input" name="password" placeholder="••••••••" required>
                    <button type="button" id="toggle_password" class="btn-eye" aria-label="Mostrar contraseña">
                        <svg id="eye_closed_icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg id="eye_open_icon" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primario">Iniciar Sesión</button>
        </form>

        <p class="footer-text">¿QUÉ? ¿Aún no tienes cuenta? <br> <a href="/registro">¿Qué esperas?</a></p>
    </div>

    <script>
        const togglePassword = document.getElementById('toggle_password');
        const passwordInput = document.getElementById('password_input');
        const eyeClosedIcon = document.getElementById('eye_closed_icon');
        const eyeOpenIcon = document.getElementById('eye_open_icon');

        togglePassword.addEventListener('click', function () {
            // Alternar el tipo del input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Alternar la visibilidad de los íconos
            if (type === 'text') {
                eyeClosedIcon.style.display = 'none';
                eyeOpenIcon.style.display = 'block';
            } else {
                eyeClosedIcon.style.display = 'block';
                eyeOpenIcon.style.display = 'none';
            }
        });
    </script>
</body>
</html>