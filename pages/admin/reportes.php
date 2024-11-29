<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/reportes.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Reportes Generales</h1>
        </header>
        <section id="reports">
            <h2>Datos Generales</h2>
            <p>Genera reportes sobre clientes, proyectos y presupuestos.</p>
            <button id="generate-report-btn">Generar Reporte</button>
            <div id="report-output"></div>
        </section>
    </div>
    <script src="jsadmin/reportes.js"></script>
</body>

</html>