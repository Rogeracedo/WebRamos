<?php

include_once("../../models/Conexion.php");
session_start();
$cn = new Conexion();
$con = $cn->getConnection();

try {
    $dataRespuesta = array();
    $query = "SELECT * FROM proyecto p inner join presupuesto pr on pr.ID_Presupuesto=p.idpresupuesto where idcliente = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["idCliente"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'idpresupuesto' => $row["ID_Presupuesto"],
            'idservicio' => $row["ID_Servicio"],
            'monto' => $row["Monto_Total"],
            'fecha' => $row["Fecha_Creacion"],
            'detalle' => $row["Detalle"],
            'idproyecto' => $row["idproyecto"],
            'nombre' => $row["nombre"],
            'detalle' => $row["idasesor"]
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
    <link rel="stylesheet" href="../../estilos/estiloscliente/presupuesto.css">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>
        <section class="container budget">
            <h2>Presupuestos</h2>
            <?php
            foreach ($dataRespuesta as $data):
            ?>
                <div class="budget-cards">
                    <div class="budget-card">
                        <div class="budget-header">
                            <span>Presupuesto Total</span>
                        </div>
                        <div class="budget-body">
                            <span class="budget-value"><?php echo $data["monto"]; ?></span>
                        </div>
                    </div>
                    <div class="budget-card">
                        <div class="budget-header">
                            <span>Presupuesto Utilizado</span>
                        </div>
                        <div class="budget-body">
                            <span class="budget-value">$375,000 USD (75%)</span>
                        </div>
                    </div>
                    <div class="budget-card">
                        <div class="budget-header">
                            <span>Presupuesto Restante</span>
                        </div>
                        <div class="budget-body">
                            <span class="budget-value">$125,000 USD (25%)</span>
                        </div>
                    </div>
                </div>
            <?php endforeach;  ?>
            <p class="budget-note">Este presupuesto está sujeto a cambios según el progreso del proyecto y ajustes en
                los costos.</p>
        </section>
    </div>
</body>