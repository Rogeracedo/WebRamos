<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "Admin" || !isset($_GET["proyecto"])) {
    header("Location: ../landing/index.php");
}
$cn = new Conexion();
$con = $cn->getConnection();

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

//CONFIG POST MANEJO FORMS


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'updateProyecto') {
            try {
                $query = "UPDATE proyecto SET `nombre` = ?,`fechaInicio` = ?,`fechaFin` = ?, `estado` = ?, `progreso` = ? WHERE `idproyecto` = ?;";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "sssiii", $_POST["proyecto"], $_POST["inicio"], $_POST["fin"], $_POST["estado"], $_POST["progreso"], $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
            } catch (Exception $e) {
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                return null;
            }
        } else if ($_POST['accion'] === 'updatePresupuesto') {
            try {
                $query = "UPDATE presupuesto SET  `Monto_Total` = ? WHERE `ID_Presupuesto` = ?;";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "ii", $_POST["presupuesto"], $idPresupuesto);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
            } catch (Exception $e) {
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                return null;
            }
        } else if ($_POST['accion'] === 'addGasto') {
            try {
                $query = "INSERT INTO `gasto` (`montoGasto`, `fecha`, `idPresupuesto`) VALUES ( ?, current_timestamp(), ?) ";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "ii", $_POST["gasto"], $idPresupuesto);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
            } catch (Exception $e) {
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                return null;
            }
        } else if ($_POST['accion'] === 'estadoTerminado') {
            try {
                $query = "UPDATE `proyecto` SET `estado`= 3 where idproyecto = ? ";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
            } catch (Exception $e) {
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                return null;
            }
        } else if ($_POST['accion'] === 'estadoCancelado') {
            //ESTADO CANCELADO
            try {
                $query = "UPDATE `proyecto` SET `estado`= 5 where idproyecto = ? ";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception('Error revisar conexion.');
                }
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
            } catch (Exception $e) {
                header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                return null;
            }
        } else if ($_POST['accion'] === 'subirDoc') {
            if (isset($_FILES['documento'])) {
                $nombreArchivo = $_FILES['documento']['name'];
                $tipoArchivo = $_FILES['documento']['type'];
                $temporalArchivo = $_FILES['documento']['tmp_name'];

                $directorioDestino =  $_SERVER['DOCUMENT_ROOT'] . "/WeBramos/uploads/" . $id . "/" . $_POST['tipo_documento'];
                if (!file_exists($directorioDestino)) {
                    mkdir($directorioDestino, 0777, true);
                }
                $directorioDestino .= "/" . basename($nombreArchivo);
                $rutaSQL = "/WeBramos/uploads/" . $id . "/" . $_POST['tipo_documento'] ."/". $nombreArchivo;
                try {
                    $query = "INSERT INTO `documento` (`nombre`, `tipo`, `idproyecto`, `url`) VALUES (?, ?, ?, ?)  ";
                    $stmt = mysqli_prepare($con, $query);
                    if (!$stmt) {
                        throw new Exception('Error revisar conexion.');
                    }
                    mysqli_stmt_bind_param($stmt, "siis", $nombreArchivo, $_POST['tipo_documento'], $id, $rutaSQL);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_close($stmt);
                        if (move_uploaded_file($temporalArchivo, $directorioDestino)) {
                            header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=true");
                        } else {
                            header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                        }
                    } else {
                        echo "Error en la base de datos.";
                        header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                    }
                } catch (Exception $e) {
                    header("Location: detalle.php?proyecto=" . $_GET["proyecto"] . "&success=false");
                    return null;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Presupuesto</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../estilos/estilosadmin/stylesgestion.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
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
                        foreach ($dataDocs as $datad):
                        ?>
                            <div class="planos-card">
                                <div class="planos-header">
                                    <span><?php echo ($datad['tipo'] == 1) ? "Plano Arquitectónico" : (($datad['tipo'] == 2) ? "Plano Eléctrico" : " Documento"); ?></span>
                                </div>
                                <div class="planos-body">
                                    <?php
                                    echo $datad['nombre'];
                                    ?>
                                    <a download href="<?php echo $datad['url']; ?>" class="download-button">
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
            </div>

            <!-- Formulario de Actualización -->
            <div class="card">
                <h2 class="card-title">Actualizar Información</h2>
                <form action="detalle.php?proyecto=<?php echo $id ?>" id="budgetForm" method="post">
                    <!-- <div class="input-group">
                    <label for="nameInput">Nombre:</label>
                    <input type="text" id="nameInput" placeholder="Ejemplo: Juan Pérez">
                </div> -->
                    <div class="input-group">
                        <label for="projectInput">Proyecto:</label>
                        <input type="text" id="projectInput" name="proyecto" placeholder="Ejemplo: Nueva App" value="<?php echo $data["nombre"] ?>">
                    </div>
                    <div class="input-group">
                        <label for="projectInput">Progreso:</label>
                        <input type="number" min=0 max=100 step=1 id="projectInput" name="progreso" placeholder="Ejemplo: 0 - 100" value="<?php echo $data["progreso"] ?>">
                    </div>
                    <!-- <div class="input-group">
                    <label for="clientInput">Cliente:</label>
                    <input type="text" id="clientInput" placeholder="Ejemplo: Compañía XYZ">
                </div> -->
                    <div class="input-group">
                        <label for="statusInput">Estado del Proyecto:</label>
                        <select id="statusInput" name="estado">
                            <option value=0 disabled>Seleccionar...</option>
                            <option value=2 <?php echo ($data["estado"] == 2) ? "selected" : "" ?>>En Progreso</option>
                            <option value=3 <?php echo ($data["estado"] == 3) ? "selected" : "" ?>>Finalizado</option>
                            <option value=5 <?php echo ($data["estado"] == 5) ? "selected" : "" ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="startDateInput">Fecha de Inicio:</label>
                        <input type="date" id="startDateInput" name="inicio" value=<?php echo $data["inicio"] ?>>
                    </div>
                    <div class="input-group">
                        <label for="endDateInput">Fecha de Fin:</label>
                        <input type="date" id="endDateInput" name="fin" value=<?php echo $data["fin"] ?>>
                    </div>
                    <button type="submit" id="updateInfoButton" class="primary-button" name="accion" value="updateProyecto">Actualizar Información</button>
                </form>
            </div>

            <!-- Gestión del Presupuesto -->
            <div class="card">
                <h2 class="card-title">Gestión de Presupuesto</h2>
                <div style="display: grid; grid-template-columns: repeat(2,1fr); gap:2em">
                    <div class="input-group">
                        <form action="detalle.php?proyecto=<?php echo $id ?>" method="POST">
                            <label for="budgetInput">Actualizar Presupuesto Total:</label>
                            <input type="number" id="budgetInput" name="presupuesto" placeholder="Ejemplo: 5000" value=<?php echo $prespuestoTotal ?>>
                            <button type="submit" id="updateBudgetButton" name="accion" value="updatePresupuesto" class="primary-button">Actualizar Presupuesto</button>
                        </form>
                    </div>
                    <div class="input-group">
                        <form action="detalle.php?proyecto=<?php echo $id ?>" method="POST">
                            <label for="expenseInput">Agregar Gasto:</label>
                            <input type="number" id="expenseInput" name="gasto" placeholder="Ejemplo: 200">
                            <button type="submit" id="addExpenseButton" name="accion" value="addGasto" class="secondary-button">Agregar Gasto</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <h2 class="card-title">Documentos</h2>
                <div style="display: grid; grid-template-columns: repeat(2,1fr); gap:2em">
                    <div class="input-group">
                        <form action="detalle.php?proyecto=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                            <label for="documentInput">Subir Documento:</label>
                            <input style="color:black" type="file" id="documentInput" name="documento" accept=".pdf, .doc, .docx, .jpg, .png, .zip" required>
                            <fieldset>
                                <legend style="color:black;">Selecciona el tipo de documento:</legend>
                                <label>
                                    <input type="radio" name="tipo_documento" value=1 required>Plano Arquitectónico
                                </label>
                                <label>
                                    <input type="radio" name="tipo_documento" value=2>Plano Eléctrico
                                </label>
                                <label>
                                    <input type="radio" name="tipo_documento" value=3>Documento del Proyecto
                                </label>
                            </fieldset>
                            <button type="submit" id="uploadDocumentButton" name="accion" value="subirDoc" class="primary-button">Subir Documento</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Acciones del Proyecto -->
            <div class="card">
                <h2 class="card-title">Acciones del Proyecto</h2>
                <div class="project-actions">
                    <form action="detalle.php?proyecto=<?php echo $id ?>" method="POST">
                        <button type="submit" name="accion" value="estadoTerminado" id="finalizeProjectButton" class="finalize-button">Finalizar Proyecto</button>
                        <button type="submit" name="accion" value="estadoCancelado" id="cancelProjectButton" class="cancel-button">Cancelar Proyecto</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>