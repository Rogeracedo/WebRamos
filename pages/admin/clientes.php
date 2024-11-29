<?php
include_once("../../models/Conexion.php");
session_start();
$cn = new Conexion();
$con = $cn->getConnection();
$id = 1;

try {
    $dataRespuesta = array();
    $query = "SELECT * FROM cliente where ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'nombre' => $row["Nombre"],
            'correo' => $row["Email"]
        );
    }
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    return null;
}
?>

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/clientes.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Bienvenido al Panel de Administración</h1>
        </header>
        <!-- Modal para agregar/editar clientes -->
        <div id="client-form-modal" class="modal">
            <div class="modal-content">
                <span id="close-modal-btn" class="close">&times;</span>
                <h3>Formulario de Cliente</h3>
                <form id="client-form">
                    <input type="hidden" name="id" />
                    <div>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" required />
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" required />
                    </div>
                    <div>
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" required />
                    </div>
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Clientes -->
        <section id="clients">
            <h2>Clientes</h2>
            <button id="add-client-btn">Agregar Cliente</button>
            <button id="refresh-btn">Actualizar Tabla</button>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Estado del Proyecto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="clients-table">
                    <?php
                    foreach ($dataRespuesta as $data):
                    ?>
                        <tr>
                            <td><?php echo $data["nombre"] ?></td>
                            <td><?php echo $data["correo"] ?></td>
                            <td>${client.telefono}</td>
                            <td><input type="text" class="estado-proyecto" data-id="${client.id}" value="${client.estadoProyecto}" /></td>
                            <td>
                                <button class="btn-edit" data-id="${client.id}">Editar</button>
                                <button class="btn-delete" data-id="${client.id}">Eliminar</button>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </section>

    </div>

    <!-- <script src="../../estilos/jsadmin/clientes.js"></script> -->
</body>

</html>