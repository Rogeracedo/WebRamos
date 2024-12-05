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
    $query = "SELECT p.*,c.Nombre as cliente,c.Apellido as apellido, c.ID_Cliente as idCliente from proyecto p join cliente c on c.ID_Cliente = p.idcliente ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'id' => $row["idproyecto"],
            'nombre' => $row["nombre"],
            'apellido' => $row["apellido"],
            'fin' => $row["fechaFin"],
            'incio' => $row["fechaInicio"],
            'idcliente' => $row["idCliente"],
            'cliente' => $row["cliente"],
            'estado' => $row["estado"]
        );
    }

    mysqli_free_result($result);

    $dataSelect = array();
    $query = "SELECT * FROM cliente";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataSelect[] = array(
            'id' => $row["ID_Cliente"],
            'nombre' => $row["Nombre"],
            'apellido' => $row["Apellido"],
            'correo' => $row["Email"],
            'telefono' => $row["Telefono"]
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
            <h1>Gestión de Proyectos</h1>
        </header>
        <section id="projects">
            <!--<div style="display: flex;">
                <button class="btn-success">Solicitudes Pendientes</button>
                <div>
                    <select name="cliente">
                        <?php foreach ($dataSelect as $data): ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['nombre'] . " " . $data["apellido"]; ?></option>
                        <?php endforeach; ?>
                    </select><button class="btn-success"><i class="fa-solid fa-magnifying-glass" style="color:white"></i></button>
                </div>
                <div>
                    <span>Buscar Proyecto:</span> <input type="text" name="nombreProyecto"><button class="btn-success"><i class="fa-solid fa-magnifying-glass" style="color:white;"></i></button>
                </div>
            </div>-->
            <h2>Proyectos Actuales</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Proyecto</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id=" project-list">
                    <?php foreach ($dataRespuesta as $data): ?>
                        <tr>
                            <td><?php echo $data['nombre']; ?></td>
                            <td><?php echo $data['cliente'] . " " . $data["apellido"]; ?></td>
                            <td><?php echo ($data['estado'] == 1) ? "Pendiente Aprobación"  : (($data['estado'] == 2) ? "En Progreso"  : (($data['estado'] == 3) ? "Finalizado"  : (($data['estado'] == 4) ? "Rechazado" : "Cancelado"))); ?></td>
                            <td><?php echo $data['incio']; ?></td>
                            <td><?php echo $data['fin']; ?></td>
                            <td>
                                <button type="button"
                                    onclick=<?php
                                            echo ($data['estado'] == 0) ? "abrirPendiente(" . $data['id'] . ")" : (($data['estado'] == 1) ? "abrirEnProgreso(" . $data['id'] . ")" : "abrirTerminado(" . $data['id'] . ")");
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
    function abrirPendiente(id) {
        location.href = `informacion.php?proyecto=${id}`;
    }

    function abrirEnProgreso(id) {
        location.href = `detalle.php?proyecto=${id}`;
    }

    function abrirTerminado(id) {
        location.href = `detalle.php?proyecto=${id}`;
    }
</script>

</html>