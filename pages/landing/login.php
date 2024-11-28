<?php

include_once("../../models/Conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST["email"];
  $cn = new Conexion();
  $con = $cn->getConnection();

  try {
    $query = "SELECT * FROM `credenciales` c inner join cliente cl on cl.idcredenciales=c.idcredenciales where usuario = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
      throw new Exception('Error revisar conexion.');
    }
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      if ($row["rol"] == "2") {
        session_start();
        $_SESSION["idCliente"] = $row["ID_Cliente"];
        header("Location: ../client/presupuestos.php");
      } else {
        header("Location: ../admin/admin.html");
      }
    }
    mysqli_stmt_close($stmt);
  } catch (Exception $e) {
    return null;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Ramos Drywall</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="../../estilos/login.css">
  <link rel="shortcut icon" href="../../imagenes/logo.jpg" type="image/x-icon" />
</head>

<body>
  <header>
    <a href="index.html">
      <img src="../../imagenes/logo.jpg" alt="Imagen de la constructora" />
    </a>
    <h1>Constructora Ramos Drywall</h1>
    <nav>
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="servicios.html">Servicios</a></li>
        <li><a href="proyectos.html">Proyectos</a></li>
        <li><a href="contacto.html">Contacto</a></li>
        <li><a href="inventario.html">Inventario</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div>
      <form action="login.php" method="post" id="loginForm">
        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email" id="email" class="form-control" name="email" />
          <label class="form-label" for="form2Example1">Email</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" class="form-control" name="password" />
          <label class="form-label" for="form2Example2">Constraseña</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
          <div class="col d-flex justify-content-center">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form2Example34" checked />
              <label class="form-check-label" for="form2Example34"> Recuerdame</label>
            </div>
          </div>

          <div class="col">
            <!-- Simple link -->
            <a href="#!">Recuperar contraseña?</a>
          </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block mb-4">Iniciar sesión</button>


      </form>
    </div>
  </main>
  <footer>
    <p>&copy; 2024 Constructora Ramos Drywall. Todos los derechos reservados.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>

  <!-- <script src="../../js/app.js"></script> -->
</body>

</html>