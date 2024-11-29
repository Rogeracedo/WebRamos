<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendario - Panel de Administración</title>
  <link rel="stylesheet" href="../../estilos/estiloscliente/styles.css">
  <link rel="stylesheet" href="../../estilos/estiloscliente/comentarios.css">
</head>

<body>
  <div class="main-container">
    <?php include_once("../plantilla/navbar-cliente.php") ?>
    <!-- Contenido principal -->
    <section class="feedback">
      <h2>Comentarios y Retroalimentación</h2>
      <textarea placeholder="Deja tu comentariosas aquí..."></textarea>
      <button>Enviar</button>
    </section>
  </div>
</body>