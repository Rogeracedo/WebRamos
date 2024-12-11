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

$cn = new Conexion();
$con = $cn->getConnection();

session_unset();
session_destroy();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "login") {
      $usuario = $_POST["correo"];
      $password = $_POST["contrasena"];

      try {
        $query = "SELECT * FROM `credenciales` where usuario = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
          throw new Exception('Error revisar conexion.');
        }
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
          if ($row["rol"] == "2") {
            $query = "SELECT * FROM `credenciales` c inner join cliente cl on cl.idcredenciales=c.idcredenciales where usuario = ?";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
              throw new Exception('Error revisar conexion.');
            }
            mysqli_stmt_bind_param($stmt, "s", $usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
              if ($row["password"] != $_POST["contrasena"]) {
                header("Location: login.php?fail");
                exit();
              }
              session_start();
              $_SESSION["idCliente"] = $row["ID_Cliente"];
              $_SESSION["rol"] =  "Cliente";
              $_SESSION["nombre"] = $row["Nombre"];
              $_SESSION["apellido"] = $row["Apellido"];
              header("Location: ../client/informacion.php");
            }
          } else if ($row["rol"] == "1") {
            $query = "SELECT * FROM `credenciales` where usuario = ?";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
              throw new Exception('Error revisar conexion.');
            }
            mysqli_stmt_bind_param($stmt, "s", $usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
              if ($row["password"] != $_POST["contrasena"]) {
                header("Location: login.php?fail");
                exit();
              }
              session_start();
              $_SESSION["usuario"] = $row["usuario"];
              $_SESSION["rol"] = "Admin";
              header("Location: ../admin/admin.php");
            }
          }
        } else {
          header("Location: login.php?fail");
          exit();
        }
        mysqli_stmt_close($stmt);
      } catch (Exception $e) {
        return null;
      }
    } else if ($_POST['accion'] == "register" && !(empty($_POST["correo"]) || empty($_POST["contrasena"]))) {

      $nombre = $_POST["nombre"];
      $apellido = $_POST["apellido"];
      $telefono = $_POST["telefono"];
      // $direccion = $_POST["direccion"];
      $correo = $_POST["correo"];
      $password = $_POST["contrasena"];


      try {
        $query = "INSERT INTO `credenciales`( `usuario`, `password`, `rol`) VALUES (?,?,2)";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
          throw new Exception('Error en la conexión o preparación de la consulta.');
        }
        mysqli_stmt_bind_param($stmt, "ss", $correo, $password);
        mysqli_stmt_execute($stmt);

        $id = mysqli_insert_id($con);

        if ($id) {
          $query = "INSERT INTO `cliente`( `Nombre`, `Apellido`, `Email`, `Telefono`, `Direccion`, `Fecha_Registro`, `Historial_Contrataciones`, `idcredenciales`) 
                    VALUES (?,?,?,?,'',CURRENT_TIMESTAMP(),'',$id)";
          $stmt = mysqli_prepare($con, $query);
          if (!$stmt) {
            throw new Exception('Error en la conexión o preparación de la consulta.');
          }
          mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellido, $correo, $telefono);
          $result = mysqli_stmt_execute($stmt);

          if ($result) {
            header("Location: login.php?created=true");
          } else {
            header("Location: login.php?fail");
          }
        } else {
          header("Location: login.php?fail");
        }

        mysqli_stmt_close($stmt);
      } catch (Exception $e) {
        header("Location: login.php?fail");
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FORMULARIO DE REGISTRO E INICIO SESIÓN</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../../estilos/landing/login.css">
  <link rel="shortcut icon" href="../../imagenes/landing/logo.jpg" type="image/x-icon">
</head>

<body>
  <main>
    <div style="background: position 10px;">
      <div class="container-form register">
        <div class="information">
          <div class="info-childs">
            <h2>Bienvenido</h2>
            <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
            <input type="button" value="Iniciar Sesión" id="sign-in">
          </div>
        </div>
        <div class="form-information">
          <div class="form-information-childs">
            <h2>Crear una Cuenta</h2>
            <p> Usa tu email para registrarte</p>
            <form action="login.php" class="form form-register" method="post" enctype="multipart/form-data">
              <div>
                <label for="nombre">
                  <i class='bx bx-user'></i>
                  <input type="text" placeholder="Nombre" name="nombre">
                </label>
              </div>
              <div>
                <label for="apellido">
                  <i class='bx bx-user'></i>
                  <input type="text" placeholder="Apellido" name="apellido">
                </label>
              </div>
              <div>
                <label for="telefono">
                  <i class='bx bx-phone'></i>
                  <input type="tel" placeholder="Número de Teléfono" name="telefono" pattern="[9][0-9]{8}" required>
                </label>
              </div>
              <div>
                <label for="correo">
                  <i class='bx bx-envelope'></i>
                  <input type="email" placeholder="Correo Electronico" name="correo" required>
                </label>
              </div>
              <div>
                <label for="contrasena">
                  <i class='bx bx-lock-alt'></i>
                  <input type="password" placeholder="Contraseña" name="contrasena" required>
                </label>
              </div>
              <button class="form-button-post" name="accion" value="register" type="submit">Registrarse</button>
              <div class="alerta-error">Todos los campos son obligatorios</div>
              <?php
              if (isset($_GET["created"]) && $_GET["created"] == true) { ?>
                <div class="alertSuccess">Te registraste correctamente</div>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>


      <div class="container-form login hide">
        <div class="information">
          <div class="info-childs">
            <h2>¡¡Bienvenido nuevamente!!</h2>
            <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
            <input type="button" value="Registrarse" id="sign-up">
          </div>
        </div>
        <div class="form-information">
          <div class="form-information-childs">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" class="form form-login" method="POST" novalidate>
              <div>
                <label>
                  <i class='bx bx-envelope'></i>
                  <input type="email" placeholder="Correo Electronico" name="correo">
                </label>
              </div>
              <div>
                <label>
                  <i class='bx bx-lock-alt'></i>
                  <input type="password" placeholder="Contrasena" name="contrasena">
                </label>
              </div>
              <button class="form-button-post" name="accion" value="login" type="submit">Iniciar Sesión</button>
              <div class="alerta-error">Todos los campos son obligatorios</div>
              <div class="alerta-exito">Iniciaste sesión correctamente</div>
            </form>
          </div>
        </div>
      </div>

      <a href="index.php" class="boton-casita">
        <i class='bx bx-home'></i>
      </a>
      <script defer src="../../js/landing/register.js" type="module"></script>
      <script defer src="../../js/landing/login.js"></script>
</body>

</html>