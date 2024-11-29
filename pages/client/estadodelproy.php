<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estiloscliente/styles.css">
    <link rel="stylesheet" href="../../estilos/estiloscliente/estado.css">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>

        <!-- Contenido principal -->
        <div class="content">
            <section class="project-details">
                <h3>Estado Actual</h3>

                <!-- Progreso General -->
                <div class="status">
                    <div class="progress-bar">
                        <span>Progreso General: 85%</span>
                        <div class="bar">
                            <div class="fill" style="width: 85%;"></div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="chart">
                            <svg viewBox="0 0 36 36">
                                <path class="circle-bg" d="M18 2.0845
                                       a 15.9155 15.9155 0 0 1 0 31.831
                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="circle" stroke-dasharray="85, 100" d="M18 2.0845
                                       a 15.9155 15.9155 0 0 1 0 31.831
                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="percentage">85%</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Ajusta el progreso general dinámicamente
        const porcentaje = 85; // Cambia este valor según sea necesario

        // Actualizar barra de progreso principal
        const progressBar = document.querySelector('.progress-bar .fill');
        const percentageText = document.querySelector('.progress-bar span');
        progressBar.style.width = porcentaje + '%';
        percentageText.textContent = 'Progreso General: ' + porcentaje + '%';

        // Actualizar gráfico circular
        const circle = document.querySelector('.circle');
        circle.setAttribute('stroke-dasharray', `${porcentaje}, 100`);
    </script>
</body>

</html>