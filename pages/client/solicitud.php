<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
    header("Location: ../landing/index.php");
}

if (!isset($_GET["solicitud"])) {
    header("Location: ../landing/index.php");
}

$cn = new Conexion();
$con = $cn->getConnection();

try {
    $dataRespuesta = array();
    $query = "SELECT f.*,c.*,s.Tipo as servicio, s.ID_Servicio as idservicio FROM formulario f join cliente c on c.ID_Cliente = f.ID_Cliente join servicio s on s.ID_Servicio = f.idServicio where f.ID_Formulario = ?; ";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $_GET["solicitud"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'servicio' => $row["servicio"],
            'nombre' => $row["Nombre"],
            'apellido' => $row["Apellido"],
            'fecha' => $row["Fecha_Envio"],
            'telefono' => $row["Telefono"],
            'email' => $row["Email"],
            'id' => $row["ID_Cliente"],
            'idservicio' => $row["idServicio"],
            'estado' => $row["Estado"],
            'comentario' => $row["Comentarios"]
        );
    }
} catch (Exception $e) {
    return null;
}


try {
    $dataSelect = array();
    $query = "SELECT * FROM asesor_de_ventas";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataSelect[] = array(
            'id' => $row["ID_Asesor"],
            'nombre' => $row["Nombre"],
            'apellido' => $row["Apellido"],
        );
    }
} catch (Exception $e) {
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'rechazar') {
            try {
                $query = "UPDATE `formulario` SET `Estado` = 2, `comentarioAdmin` = ? WHERE `ID_Formulario` = ?;";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "si", $_POST["descAdmi"], $_GET["solicitud"]);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: solicitud.php?solicitud=" . $_GET["solicitud"] . "&successB=true");
            } catch (Exception $e) {
                header("Location: solicitud.php?solicitud=" . $_GET["solicitud"] . "&successB=false");
                return null;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/adminsolicitud.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    <?php include_once("../plantilla/navbar-cliente.php") ?>
    <!-- Modal para solicitar un nuevo proyecto -->
    <div class="modal-container">
        <div class="modal-content">
            <header>
                <h1>Solicitud de Nuevo Proyecto</h1>
                <label style="font-size:2em;">Información</label>
            </header>
            <main>
                <?php foreach ($dataRespuesta as $data): ?>
                    <form action="solicitud.php?solicitud=<?php echo $_GET["solicitud"] ?>" method="post" class="project-form">
                        <div class="client-info">
                            <div>
                                <label for="project-name">Cliente</label>
                                <p><?php echo $data['nombre'] . " " . $data['apellido'] ?></p>
                            </div>
                            <div>
                                <label for="project-name">Telefono</label>
                                <p><?php echo $data['telefono'] ?></p>
                            </div>
                            <div>
                                <label for="project-name">Email</label>
                                <p><?php echo $data['email'] ?></p>
                            </div>
                        </div>

                        <!-- Campo select para categoría del proyecto -->
                        <label for="project-category">Servicio</label>
                        <select id="project-category" name="servicio">
                            <option value=<?php echo $data["idservicio"] ?>><?php echo $data["servicio"] ?></option>
                        </select>

                        <!-- Campo para la descripción (solo lectura) -->
                        <label for="description">Comentario Cliente</label>
                        <textarea id="description" name="description" rows="5" readonly disabled><?php echo $data['comentario'] ?></textarea>

                        <input type="text" style="display: none;" id="idCliente" name="idCliente" value=<?php echo $data['id'] ?>>
                        <!-- Botones de aceptar y rechazar -->
                        <?php if ($data["estado"] == 0) { ?>
                            <div class="modal-buttons">
                                <button type="submit" name="accion" value="rechazar" class="reject-btn">Cancelar</button>
                            </div>
                        <?php } ?>
                    </form>
                <?php endforeach; ?>
            </main>
        </div>
    </div>
</body>

</html>