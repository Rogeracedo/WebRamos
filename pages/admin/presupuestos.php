<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuestos - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/presupuestos.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Gestión de Presupuestos</h1>
        </header>
        <section id="budgets">
            <h2>Presupuestos Registrados</h2>
            <button id="add-budget-btn">Nuevo Presupuesto</button>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Proyecto</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="budget-list">
                    <!-- Dinámico -->
                </tbody>
            </table>
        </section>
    </div>
    <script src="jsadmin/presupuestos.js"></script>
</body>

</html>