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
    $query = "SELECT f.*,c.*,s.Tipo as servicio, s.ID_Servicio as idservicio FROM formulario f join cliente c on c.ID_Cliente = f.ID_Cliente join servicio s on s.ID_Servicio = f.idServicio where f.Estado=0 order by f.ID_Formulario DESC; ";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'servicio' => $row["servicio"],
            'nombre' => $row["Nombre"],
            'apellido' => $row["Apellido"],
            'fecha' => $row["Fecha_Envio"],
            'id' => $row["ID_Cliente"],
            'idservicio' => $row["idServicio"],
            'idForm' => $row["ID_Formulario"]
        );
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
    <title>Proyectos - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/proyectos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Gestión de Solicitudes</h1>
        </header>
        <section id="projects">
            <h2>Solicitudes Pendientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Cliente</th>
                        <th>Fecha de Solicitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id=" project-list">
                    <?php foreach ($dataRespuesta as $data): ?>
                        <tr>
                            <td><?php echo $data['servicio']; ?></td>
                            <td><?php echo $data['nombre'] . " " . $data["apellido"]; ?></td>
                            <td><?php echo $data['fecha']; ?></td>
                            <td>
                                <button type="button"
                                    onclick=<?php
                                            echo "abrirPendiente(" . $data["idForm"] . ")"
                                            ?>
                                    class="btn-edit"><i class="fa-solid fa-folder-open"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
<script defer>
    function abrirPendiente(idForm) {
        location.href = `solicitud.php?solicitud=${idForm}`;
    }
</script>

</html>