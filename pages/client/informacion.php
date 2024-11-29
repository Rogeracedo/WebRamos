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
  <link rel="stylesheet" href="../../estilos/estiloscliente/info.css">
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
      </section>

    </main>
</body>