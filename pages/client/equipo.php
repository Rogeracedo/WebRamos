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
  <link rel="stylesheet" href="../../estilos/estiloscliente/equipo.css">
</head>

<body>
  <div class="main-container">
    <?php include_once("../plantilla/navbar-cliente.php") ?>
    <!-- Contenido principal -->
    <div class="team-container">
      <h2>Equipo de trabajo</h2>
      <div class="team-member-card">
        <img src="../../imagenes/gustavoo.png" alt="Supervisor">
        <span>Gustavo Yamunaque Montalban - Supervisor</span>
        <p>Supervisor del proyecto</p>
      </div>
      <div class="team-member-card">
        <img src="../../imagenes/shanmir.jpeg" alt="Sub Supervisor">
        <span>Shanmir Guaylupo Calle - Sub Supervisor</span>
        <p>Sub Supervisor del proyecto</p>
      </div>
    </div>
</body>