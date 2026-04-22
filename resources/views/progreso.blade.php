<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, intial-scale= 1.0">
        <title>Tu Progreso - Enerkoi</title>
        <link rel="icon" href="{{ asset('img/LOGOENERKOI.png') }}" type="image/png">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
        /* 1. SISTEMA DE DISEÑO ENERKOI */
        :root {
            --bg-oscuro : #3b4282;
            --bg-claro: #f4f4f4;
            --azul-boton: #1877f2;
            --texto-oscuro: #333;
            --texto-claro: #fff;
            --verde-exito: #28a745;
        }

        /* 2. RESET Y ESTRUCTURA */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-oscuro);
            color: var(--texto-claro);
            box-sizing: border-box;
        }

        .main-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .btn-volver {
            display: inline-block;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 15px;
            transition: color 0.3s;
        }

        .btn-volver:hover {
            color: var(--texto-claro);
            text-decoration: underline;
        }

        .header-section {
            margin-bottom: 30px;
        }

        .header-section h1 {
            margin: 0 0 5px 0;
            font-size: 32px;
        }

        .header-section p {
            color: #ccc;
            margin: 0;
            font-size: 16px;
        }

        /* 3. TARJETAS DE RESUMEN (KPIs) */
        .grid-kpis {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (min-width: 600px) {
            .grid-kpis {
                grid-template-columns: 1fr 1fr;
            }
        }

        .kpi-card {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 25px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .kpi-icono {
            font-size: 40px;
            background: rgba(255,255,255,0.2);
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .kpi-info h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #ddd;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kpi-info span {
            font-size: 28px;
            font-weight: bold;
            color: var(--texto-claro);
        }

        /* 4. PANEL DEL GRÁFICO */
        .chart-container {
            background-color: var(--bg-claro);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: var(--texto-oscuro);
        }

        .chart-header {
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .chart-header h3 {
            margin: 0;
            color: var(--bg-oscuro);
        }
        
        /* Contenedor responsivo para el Canvas */
        .canvas-wrapper {
            position: relative;
            height: 40vh; /* Ocupa el 40% de la altura de la pantalla */
            width: 100%;
        }
    </style>

    </head>
    <body>
        <div class="main-container">
            <a href="/dashboard" class="btn-volver">Volver al Dashboard</a>
            <div class="header-section">
                <h1>Tu historial de esfuerzo</h1>
                <p>Los datos no mienten , Esto es todo lo que has logrado {{auth()->user()->nombre}}</p>
            </div>

            <div class="grap-kpis">
                <div class="kpi-card">
                    <div class="kpi-icono">🔥</div>
                    <div class="kpi-info">
                        <h4>Entrenamientos</h4>
                        <span>{{ $totalEntrenamientos }} sesiones</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icono">⏱️</div>
                    <div class="kpi-info">
                        <h4>Tiempo Invertido</h4>
                        <span>{{$tiempoTotalFormato}}</span>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <h3>Minutos de entrenamiento por Dia</h3>
                </div>

                <div class="canvas-wrapper">
                    <canvas id="graficoProgreso"></canvas>
                </div>
            </div>

        
        </div>
        <script>
            //Recibimos datos formateados desde el controlador 
            const etiquetasFechas = {!! $fechasGraficoJS !!};
            const datosTiempo = {!! $tiemposGraficoJS !!};

            //se lo enviamso al canvas
            const ctx = document.getElementById('graficoProgreso').getContext('2d');

            //Primero vemos si hay datos ,de lo contrari le decimos al usario que primero empiece a entrenar 
            if (etiquetasFechas.length === 0){
                document.querySelector('.canvas-wrapper').innerHTML = `
                <div style = "display:flex; height: 100%; justify-content; align-items: center; flex-direction: column; color: #888;">
                    <span style = "font-size: 40px; margin-bottom: 10px;">📈</span>
                    <p style="font-size: 18px;">Aun no hay datos suficientes para graficar.</p>
                    <p style = "font-size: 14px;"> ¡Inicia tu primera rutina para ver la magia!</p>
                </div>
                `;


            }else{
                //se crea el grafico con el chart.js
                new Chart(ctx,{
                    type : 'line',
                    data:{
                        labels: etiquetasFechas,
                        datasets: [{
                            label: 'Minutos entrenados',
                            data: datosTiempo,
                            borderColor: '#1877f2',
                            backgroundColor: 'rgba(24,119,242,0.2)',
                            borderWidth: 3,
                            pointBackgroundColor: '#28a745',
                            pointRadius: 5,
                            fill: true,
                            tension: 0.3
                        }]

                    },
                    options:{
                        responsive: true,
                        mantainAspectRatio: false,
                        scales:{
                            y:{
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Minutos'
                                }
                            },
                            x: {
                                title:{
                                    display: true,
                                    text:'Fechas'
                                }
                            }
                        },
                        plugins:{
                            legend:{
                                display: false 
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>