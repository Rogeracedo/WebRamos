<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Empresa Constructora</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Bienvenido al Panel de Administración</h1>
        </header>

        <!-- Inicio -->
        <section id="dashboard">
            <h2>Inicio</h2>
            <div class="summary">
                <div class="card">
                    <h3>Proyectos Activos</h3>
                    <p id="active-projects">0</p>
                </div>
                <div class="card">
                    <h3>Proyectos Finalizados</h3>
                    <p id="completed-projects">0</p>
                </div>
                <div class="card">
                    <h3>Clientes Totales</h3>
                    <p id="total-clients">0</p>
                </div>
            </div>
        </section>


    </div>

    <script src="jsadmin/admin.js"></script>

</html>