<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enerkoi - Domina tu entrenamiento</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-app: #f4f6f9; 
            --bg-oscuro: #2c336b;
            --bg-gradiente: linear-gradient(135deg, #3b4282, #1877f2);
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
            display: flex; flex-direction: column; align-items: center; min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .app-container {
            max-width: 500px; width: 100%; margin: 0 auto; padding: 30px 20px;
            display: flex; flex-direction: column; justify-content: center; min-height: 90vh;
            box-sizing: border-box;
        }

        /* HERO SECTION (El gancho principal) */
        .hero-section { text-align: center; margin-bottom: 40px; }
        
        .hero-logo { 
            width: 110px; height: auto; margin-bottom: 25px; 
            filter: drop-shadow(0px 10px 15px rgba(24, 119, 242, 0.2));
            animation: float 4s ease-in-out infinite; 
        }
        
        @keyframes float { 
            0% { transform: translateY(0px); } 
            50% { transform: translateY(-10px); } 
            100% { transform: translateY(0px); } 
        }

        .hero-title { font-size: 36px; font-weight: 900; color: var(--bg-oscuro); margin: 0 0 15px 0; line-height: 1.1;}
        .hero-subtitle { font-size: 16px; color: var(--texto-gris); margin: 0; line-height: 1.5; font-weight: 500; padding: 0 10px;}
        
        /* TARJETITAS DE INFORMACIÓN */
        .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 40px; }
        .feature-card { 
            background: var(--blanco); padding: 25px 15px; border-radius: 24px; 
            box-shadow: 0 6px 20px rgba(0,0,0,0.03); text-align: center; 
        }
        .feature-icon { width: 35px; height: 35px; color: var(--azul-boton); margin-bottom: 10px; display: inline-block; stroke-width: 2;}
        .feature-title { font-size: 15px; font-weight: 800; margin: 0 0 5px 0; color: var(--texto-oscuro); }
        .feature-desc { font-size: 13px; color: var(--texto-gris); margin: 0; line-height: 1.4; }

        /* BOTONES DE ACCIÓN */
        .action-buttons { display: flex; flex-direction: column; gap: 15px; }
        
        .btn { 
            padding: 20px; border-radius: 20px; font-size: 16px; font-weight: 800; 
            text-align: center; text-decoration: none; transition: transform 0.1s, box-shadow 0.2s; 
            display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn:active { transform: scale(0.97); }
        
        .btn-primario { 
            background: var(--bg-gradiente); color: var(--blanco); 
            box-shadow: 0 10px 25px rgba(24, 119, 242, 0.3); 
        }
        .btn-secundario { 
            background: var(--blanco); color: var(--azul-boton); 
            border: 2px solid var(--azul-boton); box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="app-container">
        
        <div class="hero-section">
            <img src="/img/LOGOENERKOI.png" alt="Logo Enerkoi" class="hero-logo">
            <h1 class="hero-title">Domina tu entrenamiento.</h1>
            <p class="hero-subtitle">Tu gimnasio, tus reglas. Diseña rutinas, registra tus series y mide tu progreso real cada día.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 10h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"/><path d="M2 10h3v4H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Z"/><path d="M5 8h3v8H5Z"/><path d="M16 8h3v8h-3Z"/><path d="M8 11h8v2H8Z"/>
                </svg>
                <h3 class="feature-title">Rutinas a medida</h3>
                <p class="feature-desc">Construye tus bloques de ejercicios.</p>
            </div>
            <div class="feature-card">
                <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                <h3 class="feature-title">Sigue el progreso</h3>
                <p class="feature-desc">El cronómetro y los datos no mienten.</p>
            </div>
        </div>

        <div class="action-buttons">
            <a href="/registro" class="btn btn-primario">
                Crear mi cuenta gratis
                <svg style="width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 3; stroke-linecap: round;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="/login" class="btn btn-secundario">
                Ya tengo cuenta (Ingresar)
            </a>
        </div>

    </div>
</body>
</html>