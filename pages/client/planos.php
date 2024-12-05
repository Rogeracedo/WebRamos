<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();
$id = $_GET["proyecto"];

try {
    $dataRespuesta = array();
    $query = "SELECT p.*,d.*,d.nombre as nombredoc FROM `proyecto` p join documento d on p.idproyecto = d.idproyecto where p.idproyecto = ?;";
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
            'nombre' => $row["nombredoc"],
            'tipo' => $row["tipo"],
            'idproyecto' => $row["idproyecto"],
            'url' => $row["url"],
            'proyecto' => $row["nombre"]
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>
        <!-- Contenido principal -->
        <div class="planos-cards">
            <section class="container planos-archivos">
                <?php
                foreach ($dataRespuesta as $data):
                ?>
                    <div class="planos-card">
                        <div class="planos-header">
                            <span><?php echo ($data['tipo'] == 1) ? "Plano Arquitectónico" : (($data['tipo'] == 2) ? "Plano Eléctrico" : " Documento del Proyecto"); ?></span>
                        </div>
                        <div class="planos-body">
                            <?php
                            echo $data['nombre'];
                            ?>
                            <a download href="<?php echo $data['url']; ?>" class="download-button">
                                <i class="fas fa-download"></i>Descargar</a>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </section>
        </div>
    </div>
</body>