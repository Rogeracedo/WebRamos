<?php
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
    header("Location: ../landing/index.php");
}
include_once("../../models/Conexion.php");
$cn = new Conexion();
$con = $cn->getConnection();


try {
    $dataRespuesta = array();
    $query = "SELECT p.*,c.Nombre as cliente,c.Apellido as apellido, c.ID_Cliente as idCliente from proyecto p join cliente c on c.ID_Cliente = p.idcliente where ID_Cliente = ? order by p.idproyecto desc;";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["idCliente"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'id' => $row["idproyecto"],
            'nombre' => $row["nombre"],
            'apellido' => $row["apellido"],
            'fin' => $row["fechaFin"],
            'incio' => $row["fechaInicio"],
            'idcliente' => $row["idCliente"],
            'cliente' => $row["cliente"],
            'estado' => $row["estado"],
            'progreso' => $row["progreso"]
        );
    }
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
    <link rel="stylesheet" href="../../estilos/estiloscliente/estado.css">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>
        <div class="content">
            <?php if (count($dataRespuesta) == 0) {
                echo '<p>Aún no tienes proyectos aprobados. Solicita alguno en el menu "Nuevo Proyecto".</p>';
            }
            ?>
            <?php foreach ($dataRespuesta as $data): ?>
                <section class="project-details">
                    <h3 style="margin-bottom: 0;"><?php echo $data['nombre'] ?> - <?php echo ($data['estado'] == 1) ? "Pendiente Aprobación"  : (($data['estado'] == 2) ? "En Progreso"  : (($data['estado'] == 3) ? "Finalizado"  : (($data['estado'] == 4) ? "Rechazado" : "Cancelado"))); ?></h3>
                    <div class="status">
                        <div class="progress-bar">
                            <span>Progreso General: <?php echo $data["progreso"]; ?>%</span>
                            <div class="bar">
                                <div class="fill" style="width: <?php echo $data["progreso"]; ?>%"></div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="chart">
                                <svg viewBox="0 0 36 36">
                                    <path class="circle-bg" d="M18 2.0845
                                       a 15.9155 15.9155 0 0 1 0 31.831
                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="circle" stroke-dasharray="<?php echo $data["progreso"]; ?>, 100" d="M18 2.0845
                                       a 15.9155 15.9155 0 0 1 0 31.831
                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <div class="percentage"><?php echo $data["progreso"]; ?>%</div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Ajusta el progreso general dinámicamente
        //     const porcentaje = 50; // Cambia este valor según sea necesario

        //     // Actualizar barra de progreso principal
        //     const progressBar = document.querySelector('.progress-bar .fill');
        //     const percentageText = document.querySelector('.progress-bar span');
        //     progressBar.style.width = porcentaje + '%';
        //     percentageText.textContent = 'Progreso General: ' + porcentaje + '%';

        //     // Actualizar gráfico circular
        //     const circle = document.querySelector('.circle');
        //     circle.setAttribute('stroke-dasharray', `${porcentaje}, 100`);
    </script>
</body>

</html>