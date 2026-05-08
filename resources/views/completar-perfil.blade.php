<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil - Enerkoi</title>
    <link rel="icon" href="/img/LOGOENERKOI.png" type="image/png">
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --verde-exito: #10b981;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
            --peligro-borrar: #ef4444;
            --peligro-bg: #fee2e2;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            -webkit-font-smoothing: antialiased;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            min-height: 100vh; padding: 20px; box-sizing: border-box;
        }

        .app-container {
            width: 100%; max-width: 500px;
        }

        /* ========================================================
           ✨ ANIMACIONES CORE ✨
           ======================================================== */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .onboarding-header { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .card-app { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.15s forwards; }
        .btn-primario { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards; }
        /* ======================================================== */

        /* 2. CABECERA Y LOGO */
        .onboarding-header { text-align: center; margin-bottom: 25px; }
        .perfil-logo { width: 75px; height: auto; margin-bottom: 15px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1)); }
        .perfil-title { margin: 0 0 8px 0; font-size: 26px; font-weight: 800; color: var(--texto-oscuro); }
        .perfil-subtitle { margin: 0; font-size: 15px; color: var(--texto-gris); font-weight: 500; line-height: 1.4; }

        /* 3. TARJETA DEL FORMULARIO */
        .card-app {
            background: var(--blanco); border-radius: 24px; padding: 30px 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04); margin-bottom: 20px;
        }

        /* 4. ALERTA DE ERRORES */
        .alert-error {
            background-color: var(--peligro-bg); color: var(--peligro-borrar);
            padding: 15px 20px; border-radius: 16px; margin-bottom: 25px;
            font-size: 14px; font-weight: 600; display: flex; flex-direction: column; gap: 5px;
        }
        .alert-error ul { margin: 0; padding-left: 20px; }

        /* 5. INPUTS Y FORMULARIO */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; color: var(--texto-oscuro); }
        
        .input-app {
            width: 100%; padding: 16px; border: 2px solid #f0f0f0; border-radius: 16px;
            font-size: 15px; font-weight: 500; box-sizing: border-box; outline: none; 
            background: var(--bg-app); color: var(--texto-oscuro); transition: border-color 0.2s, background 0.2s;
            -webkit-appearance: none; /* Limpia estilos por defecto en móviles */
        }
        .input-app:focus { border-color: var(--azul-boton); background: var(--blanco); }
        .input-app::placeholder { color: #9ca3af; }

        /* Grid para juntar elementos en pantallas más grandes */
        .grid-2-cols { display: grid; grid-template-columns: 1fr; gap: 0; }
        @media (min-width: 480px) {
            .grid-2-cols { grid-template-columns: 1fr 1fr; gap: 15px; }
            .grid-2-cols .form-group { margin-bottom: 15px; }
        }

        /* 6. BOTÓN PRIMARIO */
        .btn-primario {
            background: var(--azul-boton); color: var(--blanco); border: none; border-radius: 20px;
            padding: 20px; font-size: 18px; font-weight: 800; cursor: pointer; width: 100%; 
            box-shadow: 0 8px 20px rgba(24, 119, 242, 0.25); transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-primario:active { transform: scale(0.96); box-shadow: 0 4px 10px rgba(24, 119, 242, 0.15); }
        
        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>

<body>
    <div class="app-container">
        
        <div class="onboarding-header">
            <img src="/img/LOGOENERKOI.png" alt="Logo Enerkoi" class="perfil-logo">
            <h1 class="perfil-title">¡Ya casi estamos, {{ auth()->user()->nombre }}!</h1>
            <p class="perfil-subtitle">Necesito unos datos clave para calibrar tu experiencia en Enerkoi.</p>
        </div>

        <div class="card-app">
            @if($errors->any())
            <div class="alert-error">
                <strong>Revisa los siguientes detalles:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/completar-perfil" method="POST">
                @csrf

                <div class="grid-2-cols">
                    <div class="form-group">
                        <label class="form-label">Estatura (cm)</label>
                        <input type="number" name="estatura" class="input-app" placeholder="Ej. 175" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Peso Inicial (kg)</label>
                        <input type="number" step="0.1" name="peso_inicial" class="input-app" placeholder="Ej. 70.5" required>
                    </div>
                </div>

                <div class="grid-2-cols">
                    <div class="form-group">
                        <label class="form-label">Sexo</label>
                        <select name="sexo" class="input-app" required>
                            <option value="" disabled selected>Selecciona...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="input-app" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 5px;">
                    <label class="form-label">¿Cuál es tu objetivo principal?</label>
                    <select name="objetivo" class="input-app" required>
                        <option value="" disabled selected>Selecciona una meta...</option>
                        <option value="Ganar masa muscular">Ganar masa muscular (Hipertrofia)</option>
                        <option value="Perder grasa">Perder porcentaje de grasa (Definición)</option>
                        <option value="Recomposición corporal">Recomposición corporal</option>
                        <option value="Mantenimiento">Mantenimiento / Salud</option>
                    </select>
                </div>
        </div>

        <button type="submit" class="btn-primario">
            Entrar a Enerkoi
            <svg class="svg-icon" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
        </form>

    </div>
</body>
</html>