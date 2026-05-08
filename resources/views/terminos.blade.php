<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - Enerkoi</title>
    <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">
    
    <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-app: #f4f6f9; 
            --blanco: #ffffff;
            --azul-boton: #1877f2;
            --texto-oscuro: #1f2937;
            --texto-gris: #6b7280;
        }

        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-app); 
            color: var(--texto-oscuro);
            margin: 0; padding: 15px; box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        .app-container { 
            max-width: 600px; margin: 0 auto; padding-bottom: 40px;
        }

        /* 2. HEADER DE NAVEGACIÓN */
        .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .btn-back { 
            background: var(--blanco); border: none; width: 45px; height: 45px; 
            border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
            transition: transform 0.15s;
        }
        .btn-back:active { transform: scale(0.9); }
        .top-nav h1 { margin: 0; font-size: 22px; font-weight: 800; color: var(--texto-oscuro); }

        /* 3. TARJETA DE CONTENIDO LEGAL */
        .card-app { 
            background: var(--blanco); padding: 30px 25px; 
            border-radius: 24px; box-shadow: 0 6px 15px rgba(0,0,0,0.03);
        }

        .card-header {
            display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
            padding-bottom: 15px; border-bottom: 2px solid #f3f4f6;
        }
        .card-header h2 { margin: 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro); }
        .fecha-actualizacion { font-size: 13px; color: var(--texto-gris); font-weight: 600; margin-bottom: 20px; display: block; }

        /* 4. TIPOGRAFÍA LEGAL */
        .legal-text { color: var(--texto-gris); font-size: 15px; line-height: 1.6; }
        .legal-text h4 { 
            color: var(--texto-oscuro); font-size: 16px; font-weight: 800; 
            margin: 25px 0 10px 0;
        }
        .legal-text p { margin: 0 0 15px 0; }
        .legal-text ul { margin: 0 0 15px 0; padding-left: 20px; }
        .legal-text li { margin-bottom: 8px; }

        .btn-primario {
            width: 100%; background: var(--azul-boton); color: var(--blanco); border: none; border-radius: 20px;
            padding: 20px; font-size: 18px; font-weight: 800; cursor: pointer; transition: transform 0.1s;
            display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 25px;
        }
        .btn-primario:active { transform: scale(0.97); }

        .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <div class="app-container">
        
        <nav class="top-nav">
            <button onclick="window.close() || history.back()" class="btn-back">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <h1>Documentos Legales</h1>
        </nav>

        <div class="card-app">
            <div class="card-header">
                <svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <h2>Términos y Condiciones</h2>
            </div>

            <span class="fecha-actualizacion">Última actualización: Abril de 2026</span>

            <div class="legal-text">
                <p>Bienvenido a Enerkoi. Al crear una cuenta y utilizar nuestra aplicación, aceptas estar sujeto a los siguientes términos y condiciones. Por favor, léelos cuidadosamente antes de continuar.</p>

                <h4>1. Naturaleza del Servicio</h4>
                <p>Enerkoi es una herramienta de software diseñada de forma independiente para el registro, seguimiento y gestión personal de rutinas de ejercicio. <strong>En ningún caso Enerkoi, ni sus desarrolladores, actúan como proveedores de servicios médicos, fisioterapeutas o entrenadores personales certificados.</strong></p>

                <h4>2. Exención de Responsabilidad Física y de Salud</h4>
                <p>El uso de esta aplicación y la ejecución de cualquier ejercicio, rutina, o movimiento registrado o sugerido visualmente en la misma (incluyendo GIFs y demostraciones) se realiza <strong>bajo el propio y exclusivo riesgo del usuario</strong>. El desarrollador de Enerkoi no asume ninguna responsabilidad por:</p>
                <ul>
                    <li>Lesiones musculares, articulares o de cualquier índole.</li>
                    <li>Problemas de salud derivados del sobreesfuerzo o mala técnica.</li>
                    <li>Daños físicos o materiales ocasionados durante el uso de la aplicación.</li>
                </ul>
                <p>Se recomienda encarecidamente consultar a un médico profesional y a un entrenador físico certificado antes de iniciar o modificar cualquier programa de actividad física o dieta.</p>

                <h4>3. Exención de Responsabilidad Técnica (Software "Tal Cual")</h4>
                <p>Enerkoi se proporciona "tal cual" (<em>as is</em>) y "según disponibilidad". Como proyecto de software independiente, no se ofrecen garantías explícitas o implícitas de que el servicio será ininterrumpido, 100% seguro o libre de errores. No nos hacemos responsables por la pérdida accidental de información, historial de progreso o rutinas debido a fallos del servidor, actualizaciones o errores técnicos.</p>

                <h4>4. Propiedad Intelectual y Uso Aceptable</h4>
                <p>Todo el código fuente, diseño, logotipos y estructura de la base de datos de Enerkoi están protegidos bajo las leyes de propiedad intelectual. El usuario se compromete a:</p>
                <ul>
                    <li>No intentar vulnerar la seguridad de la aplicación (hackeo).</li>
                    <li>No realizar ingeniería inversa del código.</li>
                    <li>No utilizar la plataforma para fines comerciales de terceros sin autorización expresa del creador.</li>
                </ul>

                <h4>5. Privacidad y Gestión de Datos</h4>
                <p>Recopilamos información básica (como nombre, correo electrónico y métricas de ejercicio) única y exclusivamente para permitir el funcionamiento de tu cuenta y mostrarte tu progreso personal. Nos comprometemos a no vender, alquilar ni distribuir tus datos personales a empresas de terceros.</p>

                <h4>6. Modificación de los Términos</h4>
                <p>Nos reservamos el derecho de modificar estos términos en cualquier momento para adaptarnos a nuevas legislaciones o características de la aplicación. Es responsabilidad del usuario revisar periódicamente este documento.</p>
            </div>

            <button onclick="window.close() || history.back()" class="btn-primario">
                <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Entendido
            </button>
        </div>

    </div>
</body>
</html>