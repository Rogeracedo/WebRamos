<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "Admin") {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();

try {
    $query = "SELECT COUNT(estado) as resultado FROM `formulario` where Estado = 0 GROUP by Estado ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        $pendiente = $row["resultado"];
    } else {
        $pendiente = 0;
    }
    mysqli_free_result($result);
    $query = "SELECT COUNT(estado) as resultado FROM `proyecto` where estado = 2 GROUP by estado ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        $activo = $row["resultado"];
    } else {
        $activo = 0;
    }
    mysqli_free_result($result);
    $query = "SELECT COUNT(estado) as resultado FROM `proyecto` where estado = 3 GROUP by estado ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        $finalizado = $row["resultado"];
    } else {
        $finalizado = 0;
    }
} catch (Exception $e) {
    return null;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Empresa Constructora</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                <a href="solicitudes.php">
                    <div class="card">
                        <h3>Proyectos Pendientes</h3>
                        <p id="active-projects"><?php echo $pendiente; ?></p>
                    </div>
                </a>
                <a href="proyectos.php">
                    <div class="card">
                        <h3>Proyectos En Progreso</h3>
                        <p id="completed-projects"><?php echo $activo; ?></p>
                    </div>
                </a>
                <a href="proyectos.php">
                    <div class="card">
                        <h3>Proyectos Finalizado</h3>
                        <p id="total-clients"><?php echo $finalizado; ?></p>
                    </div>
                </a>
            </div>
        </section>
    </div>

</html>