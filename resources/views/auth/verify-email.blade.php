<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu Correo - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --verde-exito: #10b981;
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
        .verificar-card {
            background-color: var(--blanco);
            padding: 40px 30px;
            border-radius: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            width: 100%;
            max-width: 450px; 
            box-sizing: border-box;
            text-align: center;
        }

        .verificar-logo {
            width: 70px; height: auto; margin-bottom: 10px;
            display: block; margin-left: auto; margin-right: auto;
        }

        .icono-correo {
            color: var(--azul-boton);
            width: 64px; height: 64px;
            margin-bottom: 20px;
            stroke-width: 1.5;
        }

        .verificar-title {
            color: var(--texto-oscuro); margin-top: 0; margin-bottom: 10px;
            font-size: 26px; font-weight: 800;
        }
        
        .verificar-subtitle {
            color: var(--texto-gris); margin-top: 0; margin-bottom: 30px;
            font-size: 15px; font-weight: 500; line-height: 1.5;
        }

        .verificar-subtitle strong { color: var(--texto-oscuro); }

        /* 4. ALERTA DE ÉXITO */
        .alerta-exito {
            background-color: #ecfdf5;
            color: #065f46;
            border: 2px solid #a7f3d0;
            padding: 15px;
            border-radius: 16px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        /* 5. BOTONES */
        .btn-primario {
            background-color: var(--azul-boton); color: var(--blanco); border: none;
            padding: 18px; border-radius: 20px; cursor: pointer;
            font-weight: 800; font-size: 16px; width: 100%;
            transition: transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 8px 20px rgba(24, 119, 242, 0.2);
            display: flex; justify-content: center; align-items: center; gap: 8px;
        }

        .btn-primario:active { transform: scale(0.97); }

        .btn-secundario {
            background-color: transparent;
            color: var(--texto-gris);
            border: none;
            padding: 15px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
            transition: color 0.2s;
        }

        .btn-secundario:hover { color: var(--texto-oscuro); text-decoration: underline; }
    </style>
</head>
<body>

    <div class="verificar-card">
        <img src="{{ asset('img/LOGOENERKOI.png') }}" alt="Logo Enerkoi" class="verificar-logo">
        
        <svg class="icono-correo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
        </svg>

        <h1 class="verificar-title">¡Casi listos!</h1>
        <p class="verificar-subtitle">
            Antes de empezar tu vida fit en Enerkoi, necesitamos verificar tu correo electrónico para darte la mejor experiencia.<br><br>
            Te acabamos de enviar un enlace seguro a <strong>{{auth()->user()->email}}</strong>.
        </p>

        @if(session('mensaje'))
        <div class="alerta-exito">
            <svg style="width: 18px; height: 18px; stroke: currentColor; fill:none; stroke-width: 2.5; stroke-linecap: round;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
            {{session('mensaje')}}
        </div>
        @endif

        <form method="POST" action="/email/verification-notification" style="width: 100%;">
            @csrf
            <button type="submit" class="btn-primario">
                <svg style="width: 20px; height: 20px; stroke: currentColor; fill:none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;" viewBox="0 0 24 24"><path d="M21 2v6h-6"></path><path d="M3 12a9 9 0 0 1 15-6.7L21 8"></path><path d="M3 22v-6h6"></path><path d="M21 12a9 9 0 0 1-15 6.7L3 16"></path></svg>
                Reenviar correo
            </button>
        </form>

        <form method="POST" action="/logout" style="width: 100%;">
            @csrf
            <button type="submit" class="btn-secundario">
                Cerrar Sesión
            </button>
        </form>
    </div>

</body>
</html>