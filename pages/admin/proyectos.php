<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/proyectos.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Gestión de Proyectos</h1>
        </header>
        <section id="projects">
            <h2>Proyectos Actuales</h2>
            <button id="add-project-btn">Agregar Proyecto</button>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Proyecto</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="project-list">
                    <!-- Dinámico -->
                </tbody>
            </table>
        </section>
    </div>
    <script src="jsadmin/proyectos.js"></script>
</body>

</html>