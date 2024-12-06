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
    $query = "SELECT * FROM cliente";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
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
        <!-- <div id="client-form-modal" class="modal">
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
        </div> -->

        <!-- Clientes -->
        <section id="clients">
            <h2>Clientes</h2>
            <!-- <button id="add-client-btn">Agregar Cliente</button>
            <button id="refresh-btn">Actualizar Tabla</button> -->
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Estado del Proyecto</th>
                    </tr>
                </thead>
                <tbody id="clients-table">
                    <?php
                    foreach ($dataRespuesta as $data):
                    ?>
                        <tr>
                            <td><?php echo $data["nombre"] . " " . $data["apellido"] ?></td>
                            <td><?php echo $data["correo"] ?></td>
                            <td><?php echo $data["telefono"] ?></td>
                            <td><button type="button" id="add-client-btn" onclick="abrirDetalle()">Ver proyectos</button></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </section>

    </div>

    <!-- <script src="../../estilos/jsadmin/clientes.js"></script> -->
    <script defer>
        function abrirDetalle() {
            window.location= "proyectos.php";
        }
    </script>
</body>

</html>