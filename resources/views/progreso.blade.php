<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tu Progreso - Enerkoi</title>
        <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            /* 1. SISTEMA DE DISEÑO ENERKOI (Mobile-First) */
            :root {
                --bg-app: #f4f6f9; 
                --blanco: #ffffff;
                --azul-boton: #1877f2;
                --verde-exito: #10b981;
                --texto-oscuro: #1f2937;
                --texto-gris: #6b7280;
                --gradiente-kpi: linear-gradient(135deg, #3b4282, #1877f2);
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                margin: 0; background-color: var(--bg-app); color: var(--texto-oscuro);
                -webkit-font-smoothing: antialiased; 
            }

            .app-container {
                max-width: 600px; margin: 0 auto; 
                padding: 20px; padding-bottom: 80px;
                overflow-x: hidden;
            }

            /* ========================================================
               ✨ ANIMACIONES CORE ✨
               ======================================================== */
            @keyframes fadeInUp {
                0% { opacity: 0; transform: translateY(25px); }
                100% { opacity: 1; transform: translateY(0); }
            }

            @keyframes pulseIcon {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }

            /* Entrada escalonada */
            .top-nav { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
            .grid-kpis { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.15s forwards; }
            .chart-card { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards; }
            /* ======================================================== */

            /* 2. HEADER DE NAVEGACIÓN */
            .top-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
            
            .btn-back { 
                background: var(--blanco); border: none; width: 45px; height: 45px; 
                border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
                display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--texto-oscuro);
                transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .btn-back:active { transform: scale(0.9); }
            
            .top-nav-text h1 { margin: 0; font-size: 22px; font-weight: 800; color: var(--texto-oscuro); }
            .top-nav-text p { margin: 3px 0 0 0; font-size: 13px; color: var(--texto-gris); font-weight: 500;}

            /* 3. TARJETAS DE RESUMEN (KPIs tipo Widgets) */
            .grid-kpis {
                display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;
            }

            .kpi-card {
                background: var(--blanco); padding: 20px; border-radius: 24px;
                box-shadow: 0 6px 15px rgba(0,0,0,0.03); display: flex;
                flex-direction: column; align-items: flex-start; gap: 12px;
                transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .kpi-card:active { transform: scale(0.97); }

            .kpi-icono {
                background: var(--gradiente-kpi); color: var(--blanco);
                width: 45px; height: 45px; display: flex; justify-content: center; align-items: center;
                border-radius: 14px; box-shadow: 0 4px 10px rgba(24, 119, 242, 0.2);
            }
            
            .kpi-icono svg { animation: pulseIcon 3s infinite ease-in-out; }

            .kpi-info { display: flex; flex-direction: column; gap: 2px; }
            .kpi-info span { font-size: 24px; font-weight: 800; color: var(--texto-oscuro); font-variant-numeric: tabular-nums;}
            .kpi-info h4 { margin: 0; font-size: 13px; color: var(--texto-gris); font-weight: 600; }

            /* 4. PANEL DEL GRÁFICO */
            .chart-card {
                background: var(--blanco); padding: 25px 20px; border-radius: 24px;
                box-shadow: 0 6px 15px rgba(0,0,0,0.03);
            }

            .chart-header { margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
            .chart-header h3 { margin: 0; font-size: 18px; font-weight: 800; color: var(--texto-oscuro); }
            
            .canvas-wrapper { position: relative; height: 300px; width: 100%; }

            /* ESTADOS Y SVGs */
            .estado-vacio { text-align: center; color: var(--texto-gris); padding: 40px 20px; }
            .estado-vacio svg { animation: pulseIcon 3s infinite ease-in-out; }
            .svg-icon { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        </style>
    </head>
    <body>
        <div class="app-container">
            
            <nav class="top-nav">
                <a href="/dashboard" class="btn-back">
                    <svg class="svg-icon" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <div class="top-nav-text">
                    <h1>Tu Progreso</h1>
                    <p>Los datos no mienten, {{auth()->user()->nombre}}</p>
                </div>
            </nav>

            <div class="grid-kpis">
                <div class="kpi-card">
                    <div class="kpi-icono">
                        <svg class="svg-icon" viewBox="0 0 24 24"><path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z"/></svg>
                    </div>
                    <div class="kpi-info">
                        <span>{{ $totalEntrenamientos }}</span>
                        <h4>Sesiones completadas</h4>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icono">
                        <svg class="svg-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="kpi-info">
                        <span>{{$tiempoTotalFormato}}</span>
                        <h4>Tiempo invertido</h4>
                    </div>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <svg class="svg-icon" style="color: var(--azul-boton);" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <h3>Minutos entrenados</h3>
                </div>

                <div class="canvas-wrapper">
                    <canvas id="graficoProgreso"></canvas>
                </div>
            </div>

        </div>
        
        <script>
            // Recibimos datos formateados desde el controlador 
            const etiquetasFechas = {!! $fechasGraficoJS !!};
            const datosTiempo = {!! $tiemposGraficoJS !!};

            const ctx = document.getElementById('graficoProgreso').getContext('2d');

            // Si no hay datos, inyectamos el HTML de Empty State estilizado
            if (etiquetasFechas.length === 0){
                document.querySelector('.canvas-wrapper').innerHTML = `
                <div class="estado-vacio">
                    <svg style="width: 50px; height: 50px; stroke: #cbd5e1; fill:none; stroke-width:1.5; margin-bottom: 15px;" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                    <h3 style="margin:0 0 5px 0; color:#1f2937;">Sin datos suficientes</h3>
                    <p style="margin:0;">¡Inicia tu primera rutina para ver la magia y llenar este gráfico!</p>
                </div>
                `;
            }else{
                // Configuramos Chart.js con un look de App Nativa y curva suave
                new Chart(ctx,{
                    type : 'line',
                    data:{
                        labels: etiquetasFechas,
                        datasets: [{
                            label: 'Minutos',
                            data: datosTiempo,
                            borderColor: '#1877f2', 
                            backgroundColor: 'rgba(24,119,242,0.15)', 
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#1877f2',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4 // Curva suave
                        }]
                    },
                    options:{
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            y: { duration: 1500, easing: 'easeOutQuart' } // Animación de carga nativa del chart
                        },
                        interaction: { mode: 'index', intersect: false },
                        scales:{
                            y:{
                                beginAtZero: true,
                                grid: { color: '#f3f4f6', drawBorder: false },
                                ticks: { color: '#9ca3af', font: { family: '-apple-system', size: 12, weight: '600' } }
                            },
                            x: {
                                grid: { display: false, drawBorder: false }, 
                                ticks: { color: '#9ca3af', font: { family: '-apple-system', size: 12, weight: '600' } }
                            }
                        },
                        plugins:{
                            legend:{ display: false },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleFont: { size: 13, family: '-apple-system' },
                                bodyFont: { size: 14, weight: 'bold', family: '-apple-system' },
                                padding: 12, cornerRadius: 8, displayColors: false
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>