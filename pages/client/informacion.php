<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();

try {
    $dataRespuesta = array();
    $query = "SELECT * from servicio";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'id' => $row["ID_Servicio"],
            'tipo' => $row["Tipo"],
            'desc' => $row["Descripcion"],
        );
    }
} catch (Exception $e) {
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["servicio"])) {
    try {
        $query = "INSERT INTO `formulario` (`ID_Cliente`, `Fecha_Envio`, `Estado`, `Comentarios`, `idServicio`) VALUES ( ?, current_timestamp(), 0, ?, ?) ";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            throw new Exception('Error revisar conexion.');
        }
        mysqli_stmt_bind_param($stmt, "isi", $_SESSION["idCliente"], $_POST["comentario"], $_POST["servicio"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: informacion.php?success=true");
    } catch (Exception $e) {
        header("Location: informacion.php?success=false");
        return null;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estiloscliente/styles.css">
    <link rel="stylesheet" href="../../estilos/estiloscliente/info.css">
    <link rel="stylesheet" href="../../estilos/info.css">
</head>

<body>
    <div class="main-container">
        <?php include_once("../plantilla/navbar-cliente.php") ?>
        <!-- Contenido principal -->
        <main>
            <section class="project-info">
                <h1>Departamento</h1>
                <p>Un departamento es una solución habitacional práctica y moderna, perfecta para quienes desean un estilo de
                    vida urbano y conveniente.</p>
                <div class="galeria">
                    <img src="../../imagenes/proyectos_en_drywall (18).jpg" alt="Imagen 1">
                    <img src="../../imagenes/hq720.jpg" alt="Imagen 2">
                    <img src="../../imagenes/depaaa.jpeg" alt="Imagen 3">
                    <img src="../../imagenes/depa22.jpg" alt="Imagen 4">
                    <img src="../../imagenes/1.jpg" alt="Imagen 5">
                </div>
                <!-- Botón para abrir el modal -->
                <div class="new-project-button">
                    <button onclick="toggleModal()">Solicitar Nuevo Proyecto</button>
                </div>
                <div>
                    <?php
                    if (isset($_GET["success"])) {
                        if ($_GET["success"] == "true") { ?>
                            <p class="success-message">Solicitud enviada con éxito!</p>
                        <?php } else { ?>
                            <p class="error-message">Error al registrar solicitud. Vuelva a intentarlo</p>
                    <?php }
                    } ?>
                </div>
            </section>
        </main>

        <!-- Modal para solicitar un nuevo proyecto -->
        <div class="modal" id="projectModal">
            <div class="modal-content">
                <button class="close-button" onclick="toggleModal()">×</button>
                <header>
                    <h1>¿Quieres comenzar un nuevo Proyecto?</h1>
                    <p>Completa el formulario y conoce todas nuestras opciones.</p>
                </header>
                <main>
                    <form action="informacion.php" method="post" class="project-form">
                        <!-- Campo select para categoría del proyecto -->
                        <label for="project-category">Servicios</label>
                        <select id="project-category" name="servicio" required>
                            <option value="" disabled selected>Seleccione un servicio</option>
                            <?php foreach ($dataRespuesta as $data): ?>
                                <option value="<?php echo $data['id']; ?>" data-description="<?php echo $data['desc']; ?>"><?php echo $data['tipo']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="description">Descripción Servicio</label>
                        <textarea id="description" rows="2" disabled></textarea>

                        <label for="description">Comentarios</label>
                        <textarea id="description" name="comentario" rows="5" placeholder="Describe brevemente el proyecto" required></textarea>

                        <button type="submit" class="submit-button">Enviar Solicitud</button>
                    </form>
                </main>
            </div>
        </div>

    </div>

    <script>
        // Función para alternar entre abrir y cerrar el modal
        function toggleModal() {
            const modal = document.getElementById('projectModal');
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }

        // LLenar descripcion de cada uno
        const select = document.getElementById('project-category');
        const textarea = document.getElementById('description');

        select.addEventListener('change', function() {
            const description = select.options[select.selectedIndex].getAttribute('data-description');
            textarea.value = description;
        });
    </script>
</body>

</html>