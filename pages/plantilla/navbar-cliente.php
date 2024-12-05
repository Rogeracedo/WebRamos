<div class="sidebar">
    <h2>Panel Usuario</h2>
    <div class="user-info">
        <img src="../../imagenes/descarga.png" alt="User Avatar" class="user-avatar">
        <p>Usuario: <span id="username"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]  ?></span></p>
    </div>
    <nav>
        <ul>
            <li><a href="informacion.php">🏗 Nuevo Proyecto</a></li>
            <li><a href="estadodelproy.php">📊 Estado del proyecto</a></li>
            <li><a href="calendario.php">📅 Calendario</a></li>
            <li><a href="presupuestos.php">💰 Presupuestos</a></li>
            <!-- <li><a href="planos.php">📁 Planos y archivos</a></li> -->
            <!-- <li><a href="equipo.php">👷 Equipo de trabajo</a></li> -->
            <li><a href="solicitudes.php">💬 Solicitudes</a></li>
            <li><a href="../plantilla/logout.php">🔓 Cerrar sesión</a></li>

        </ul>
    </nav>
</div>