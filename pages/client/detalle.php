<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();
$id = $_GET["proyecto"];

//CONFIG VISTA
if (isset($_GET['proyecto'])) {
    $id = $_GET['proyecto'];
    try {
        $dataRespuesta = array();
        $query = "SELECT p.*,c.Nombre as cliente,c.Apellido as apellido, c.ID_Cliente as idCliente from proyecto p join cliente c on c.ID_Cliente = p.idcliente where p.idproyecto =$id  ;";
        $result = mysqli_query($con, $query);
        if (!$result) {
            throw new Exception('Error en la consulta: ' . mysqli_error($con));
        }
        if ($row = mysqli_fetch_assoc($result)) {
            $dataRespuesta[] = array(
                'id' => $row["idproyecto"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"],
                'fin' => $row["fechaFin"],
                'inicio' => $row["fechaInicio"],
                'idcliente' => $row["idCliente"],
                'cliente' => $row["cliente"],
                'estado' => $row["estado"],
                'progreso' => $row["progreso"]
            );
            $idPresupuesto = $row["idpresupuesto"];
            $idCliente = $row["idCliente"];
        }

        mysqli_free_result($result);

        $query = "SELECT * from presupuesto where ID_Presupuesto = $idPresupuesto ;";
        $result = mysqli_query($con, $query);
        if (!$result) {
            throw new Exception('Error en la consulta: ' . mysqli_error($con));
        }
        if ($row = mysqli_fetch_assoc($result)) {
            $prespuestoTotal = $row["Monto_Total"];
        }

        mysqli_free_result($result);

        $gastos = array();
        $query = "SELECT * from gasto where idpresupuesto =$idPresupuesto ;";
        $result = mysqli_query($con, $query);
        if (!$result) {
            throw new Exception('Error en la consulta: ' . mysqli_error($con));
        }
        $gastoTotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $gastos[] = array('gasto' => $row["montoGasto"], 'fecha' => $row["fecha"]);
            $gastoTotal = $gastoTotal + $row["montoGasto"];
        }
        mysqli_free_result($result);
    } catch (Exception $e) {
        return null;
    }
}

try {
    $dataDocs = array();
    $query = "SELECT * from documento  where idproyecto = ?;";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataDocs[] = array(
            'iddocumento' => $row["iddocumento"],
            'nombre' => $row["nombre"],
            'tipo' => $row["tipo"],
            'idproyecto' => $row["idproyecto"],
            'url' => $row["url"],
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
    <link rel="stylesheet" href="../../estilos/estilosadmin/stylesgestion.css">
    <link rel="stylesheet" href="../../estilos/estiloscliente/planos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>
        <!-- Contenido principal -->
        <div class="content" style="width: 80vw; margin: 40px;">
            <?php foreach ($dataRespuesta as $data): ?>
                <h1 class="title">Gestión de Presupuesto</h1>
                <!-- Información General -->
                <div class="card">
                    <h2 class="card-title">Información General</h2>
                    <div class="info-grid">
                        <!-- <p style="color:black"><strong>Nombre:</strong> <span id="projectName"><?php echo $data["nombre"] ?></span></p> -->
                        <p style="color:black"><strong>Proyecto:</strong> <span id="projectTitle"><?php echo $data["nombre"] ?></span></p>
                        <p style="color:black"><strong>Cliente:</strong> <span id="projectClient"><?php echo $data["cliente"] . " " . $data["apellido"] ?></span></p>
                        <p style="color:black"><strong>Estado:</strong> <span id="projectStatus"><?php echo ($data['estado'] == 1) ? "Pendiente Aprobación"  : (($data['estado'] == 2) ? "En Progreso"  : (($data['estado'] == 3) ? "Finalizado"  : (($data['estado'] == 4) ? "Rechazado" : "Cancelado"))); ?></span></p>
                        <p style="color:black"><strong>Progreso:</strong> <span id="projectClient"><?php echo $data['progreso']  ?></span></p>
                        <p style="color:black"><strong>Fecha de Inicio:</strong> <span id="startDate"><?php echo $data["inicio"] ?></span></p>
                        <p style="color:black"><strong>Fecha de Fin:</strong> <span id="endDate"><?php echo $data["fin"] ?></span></p>
                        <p style="color:black"><strong>Presupuesto Total Actual:</strong> <span id="totalBudget"><?php echo $prespuestoTotal ?></span></p>
                        <p style="color:black"><strong>Gastos Totales:</strong> <span id="totalExpenses"><?php echo $gastoTotal ?></span></p>
                    </div>
                </div>
                <div class="card">
                    <h2 class="card-title">Documentos</h2>
                    <div class="planos-cards">
                        <section class="container planos-archivos">
                            <?php
                            foreach ($dataDocs as $data):
                            ?>
                                <div class="planos-card">
                                    <div class="planos-header">
                                        <span><?php echo ($data['tipo'] == 1) ? "Plano Arquitectónico" : (($data['tipo'] == 2) ? "Plano Eléctrico" : " Documento"); ?></span>
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
                <div class="card">
                    <h2 class="card-title">Gastos</h2>
                    <table class="tabla-gastos">
                        <thead>
                            <tr>
                                <th style="color:black; font-weight:bold">Fecha</th>
                                <th style="color:black; font-weight:bold">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gastos as $gasto): ?>
                                <tr>
                                    <td class="fecha"><?php echo $gasto["fecha"] ?> </td>
                                    <td class="monto-rojo">$<?php echo $gasto["gasto"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="total-container">
                        <span class="total-label">Total:</span>
                        <span class="total-amount" id="totalMonto"><?php echo $gastoTotal ?></span>
                    </div>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>