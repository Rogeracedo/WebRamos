<?php
try {
    $query = "SELECT COUNT(estado) as resultado FROM `formulario` where Estado = 0 GROUP by Estado ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        $data = $row["resultado"];
    } else {
        $data = 0;
    }
    mysqli_free_result($result);
} catch (Exception $e) {
    return null;
}
?>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a class="notification-alert" href="solicitudes.php"><i class="fa-solid fa-bell"></i><?php echo $data ?></a>
    <nav>
        <ul>
            <li><a href="admin.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="solicitudes.php">Solicitudes</a></li>
            <li><a href="proyectos.php">Proyectos</a></li>
            <li><a href="presupuestos.php">Presupuestos</a></li>
            <li><a href="calendario.php">Calendario</a></li>
            <li><a href="../plantilla/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</div>