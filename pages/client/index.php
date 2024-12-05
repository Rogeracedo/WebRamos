<?php
session_start();
if (!isset($_SESSION["idCliente"]) || $_SESSION["rol"] != "Cliente") {
  header("Location: ../landing/index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración - Empresa Constructora</title>
  <link rel="stylesheet" href="../../estilos/estiloscliente/styles.css">
</head>

<body>
  <div class="main-container">
    <?php include_once("../plantilla/navbar-cliente.php") ?>

    <!-- Contenido principal -->
</body>

</html>