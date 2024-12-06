<?php
include_once("../../models/Conexion.php");
session_start();
if (isset($_SESSION["rol"])) {
    if ($_SESSION["rol"] == "Cliente") {
        header("Location: ../client/index.php");
        exit();
    } else {
        header("Location: ../admin/admin.php");
        exit();
    }
}
session_unset();
session_destroy();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    $cn = new Conexion();
    $con = $cn->getConnection();

    try {
        // Primer INSERT en la tabla credenciales
        $query = "INSERT INTO `credenciales`( `usuario`, `password`, `rol`) VALUES (?,?,2)";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            throw new Exception('Error en la conexión o preparación de la consulta.');
        }
        mysqli_stmt_bind_param($stmt, "ss", $correo, $password);
        mysqli_stmt_execute($stmt);
        
        // Recuperar el ID del último registro insertado
        $id = mysqli_insert_id($con);

        if ($id) {
            // Segundo INSERT en la tabla cliente
            $query = "INSERT INTO `cliente`( `Nombre`, `Apellido`, `Email`, `Telefono`, `Direccion`, `Fecha_Registro`, `Historial_Contrataciones`, `idcredenciales`) 
                      VALUES (?,?,?,?,?,CURRENT_TIMESTAMP(),'',$id)";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                throw new Exception('Error en la conexión o preparación de la consulta.');
            }
            mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellido, $correo, $telefono, $direccion);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Redirigir si la inserción fue exitosa
                header("Location: login.php?created");
            } else {
                // Error en la inserción del cliente
                header("Location: login.php?fail");
            }
        } else {
            // Error en la inserción de las credenciales
            header("Location: login.php?fail");
        }

        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        // Aquí puedes agregar algún tipo de manejo de errores, por ejemplo, loguear el error
        header("Location: login.php?fail");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="../../estilos/index.css">
    <link rel="shortcut icon" href="../../imagenes/logo.jpg" type="image/x-icon" />
    <style>
        /* Contenedor del formulario */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }

        .form-box {
            background-color: white;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Imagen centrada sobre el formulario */
        .form-image {
            margin-bottom: 20px;
        }

        .form-image img {
            max-width: 100%;
            height: auto;
        }

        /* Título del formulario */
        .form-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Estilos del formulario */
        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Fila de columnas */
        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        /* Estilos del grupo de campos */
        .form-group {
            width: 48%;
        }

        /* Estilos de los campos */
        .form-label {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Estilos del botón */
        .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <header>

        <a href="index.php">
            <img src="../../imagenes/logo.jpg" alt="Imagen de la constructora" />
        </a>

        <h1>Constructora Ramos Drywall</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="servicios.html">Servicios</a></li>
                <li><a href="proyectos.html">Proyectos</a></li>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="inventario.html">Inventario</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <div class="form-box">
            <!-- Imagen centrada sobre el formulario -->
            <div class="form-image">
                <img src="../../imagenes/logo.jpg" style="width: 60px; height: auto;" alt="Logo" class="img-fluid">
            </div>

            <h2 class="form-title">Formulario de Registro</h2>
            <form action="#" method="POST" class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" id="correo" name="correo" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Registrarse</button>
            </form>
        </div>
    </div>
</body>

</html>