<?php
include_once("../../models/Conexion.php");
session_start();
$cn = new Conexion();
$con = $cn->getConnection();
$id = 1;

try {
    $dataRespuesta = array();
    $query = "SELECT * FROM documento where idproyecto = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'iddocumento' => $row["iddocumento"],
            'nombre' => $row["nombre"],
            'tipo' => $row["tipo"],
            'idproyecto' => $row["idproyecto"],
            'url' => $row["url"]
        );
    }
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    return null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estiloscliente/styles.css">
    <link rel="stylesheet" href="../../estilos/estiloscliente/planos.css">
</head>

<body>
    <div class="main-container">
        <!-- Barra lateral -->
        <div class="sidebar">
            <h2>Panel Usuario</h2>
            <div class="user-info">
                <img src="../../imagenes/descarga.png" alt="User Avatar" class="user-avatar">
                <p>Usuario: <span id="username">NombreUsuario</span></p>
            </div>
            <nav>
                <ul>
                    <li><a href="informaciom.html">🏗 Proyecto</a></li>
                    <li><a href="estadodelproy.html">📊 Estado del proyecto</a></li>
                    <li><a href="calendario.html">📅 Calendario</a></li>
                    <li><a href="presupuestos.html">💰 Presupuestos</a></li>
                    <li><a href="planos.html">📁 Planos y archivos</a></li>
                    <li><a href="equipo.html">👷 Equipo de trabajo</a></li>
                    <li><a href="comentarios.html">💬 Comentarios</a></li>
                    <li><a href="../landing/index.html">🔓 Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>

        <!-- Contenido principal -->
        <section class="container planos-archivos">
            <h2>Planos y Archivos</h2>
            <?php
            foreach ($dataRespuesta as $data):
            ?>
                <div class="planos-cards">
                    <div class="planos-card">
                        <div class="planos-header">
                            <span>Plano Arquitectónico</span>
                        </div>
                        <div class="planos-body">
                            <?php
                            echo $data['nombre'];
                            ?>
                            <a download href="<?php echo $data['url']; ?>"  class="download-button">
                                <i class="fas fa-download"></i> Descargar PDF
                            </a>
                        </div>
                    </div>
                    <!-- <div class="planos-card">
                        <div class="planos-header">
                            <span>Planos Eléctricos</span>
                        </div>
                        <div class="planos-body">
                            <a href="/archivos/plano-electrico.pdf" target="_blank" class="download-button">
                                <i class="fas fa-download"></i> Descargar PDF
                            </a>
                        </div>
                    </div>
                    <div class="planos-card">
                        <div class="planos-header">
                            <span>Documentos del Proyecto</span>
                        </div>
                        <div class="planos-body">
                            <a href="/archivos/documentos-proyecto.zip" target="_blank" class="download-button">
                                <i class="fas fa-download"></i> Descargar Archivos
                            </a>
                        </div>
                    </div> -->
                </div>
            <?php
            endforeach; ?>
        </section>
</body>