<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "Admin") {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();

try {
    $dataRespuesta = array();
    $query = "SELECT * FROM proyecto p join presupuesto pr on p.idpresupuesto = pr.ID_Presupuesto; ";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $query2 = "SELECT * FROM cliente where ID_Cliente = ?";
        $stmt = mysqli_prepare($con, $query2);
        if (!$stmt) {
            throw new Exception('Error revisar conexion.');
        }
        mysqli_stmt_bind_param($stmt, "s", $row["idcliente"]);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);
        if ($row2 = mysqli_fetch_assoc($result2)) {
            $dataRespuesta[] = array(
                'cliente' => $row2["Nombre"] . " " . $row2["Apellido"],
                'proyecto' => $row["nombre"],
                'monto' => $row["Monto_Total"],
                'estado' => $row["estado"],
                'fecha' => $row['fechaInicio'],
                'idProyecto' => $row['idproyecto']
            );
        }
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
    <title>Presupuestos - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/presupuestos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Gestión de Presupuestos</h1>
        </header>
        <section id="budgets">
            <h2>Presupuestos Registrados</h2>
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
                    <?php foreach ($dataRespuesta as $data): ?>
                        <tr>
                            <td><?php echo $data["cliente"] ?></td>
                            <td><?php echo $data["proyecto"] ?></td>
                            <td><?php echo $data["monto"] ?></td>
                            <td><?php echo ($data['estado'] == 1) ? "Pendiente Aprobación"  : (($data['estado'] == 2) ? "En Progreso"  : (($data['estado'] == 3) ? "Finalizado"  : (($data['estado'] == 4) ? "Rechazado" : "Cancelado"))); ?></td>
                            <td><?php echo $data["fecha"] ?></td>
                            <td>
                                <button onclick="verDetalle(<?php echo $data['idProyecto']; ?>)" class="btn-edit"><i class="fa-solid fa-folder-open"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <script defer>
        function verDetalle($id) {
            location.href = `detalle.php?proyecto=${id}`;
        }
    </script>
</body>

</html>