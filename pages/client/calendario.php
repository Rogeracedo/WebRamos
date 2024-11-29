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
    <link rel="stylesheet" href="../../estilos/estiloscliente/calendario.css">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>

        <!-- Contenido principal -->
        <div class="content">
            <header>
                <h1>Calendario de Actividades</h1>
            </header>
            <section id="calendar">
                <div id="calendar-header">
                    <button id="prev-month">◀</button>
                    <h2 id="month-year"></h2>
                    <button id="next-month">▶</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                            <th>Domingo</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Dinámico -->
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
<script src="../../js/client/calendario.js"></script>

</html>