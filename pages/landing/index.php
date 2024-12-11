<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructora Ramos Drywall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../estilos/landing/index.css">
    <link rel="shortcut icon" href="../../imagenes/landing/logo.jpg" type="image/x-icon">
</head>

<body>
    <header>
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../../imagenes/landing/logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
                    Ramos Drywall
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="servicios.html">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link" href="proyectos.html">Proyectos</a></li>
                        <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100"
                            src="https://images.unsplash.com/photo-1606225948173-47c1d329c054?q=80&w=1770&auto=format&fit=crop"
                            alt="Primera imagen">
                        <div class="carousel-caption">
                            <h5>Innovación en Construcción</h5>
                            <p>Ofrecemos soluciones de construcción modernas y eficientes.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100"
                            src="https://images.unsplash.com/photo-1531973576160-7125cd663d86?q=80&w=1770&auto=format&fit=crop"
                            alt="Segunda imagen">
                        <div class="carousel-caption">
                            <h5>Calidad y Compromiso</h5>
                            <p>Nos esforzamos en cada proyecto para lograr la máxima calidad.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100"
                            src="https://images.pexels.com/photos/6474133/pexels-photo-6474133.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Tercera imagen">
                        <div class="carousel-caption">
                            <h5>Construcción Responsable</h5>
                            <p>Construimos con respeto hacia el medio ambiente y la comunidad.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Visión y Misión -->
        <section id="vision-mision" class="container my-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-4 text-center shadow-sm">
                        <h2 class="card-title">Visión</h2>
                        <p class="card-text">Ser reconocidos como la empresa líder en soluciones constructivas
                            integrales, destacándonos por nuestra excelencia, innovación y responsabilidad social.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 text-center shadow-sm">
                        <h2 class="card-title">Misión</h2>
                        <p class="card-text">Transformar ideas en realidades tangibles, construyendo espacios duraderos
                            y funcionales que superen las expectativas de nuestros clientes.</p>
                    </div>
                </div>
            </div>
        </section>

        <main>
            <!-- Sección de Proyectos -->
            <section id="proyectos" class="text-center my-5">
                <h2>Nuestros Proyectos</h2>
                <img src="https://comoli.es/wp-content/uploads/2020/09/empresas-constructoras-800x445.jpg"
                    alt="Proyectos" class="img-fluid rounded my-3">
                <p>Explora algunos de nuestros proyectos exitosos que reflejan nuestra experiencia y dedicación.</p>
                <a href="proyectos.html" class="btn btn-dark">Ver Proyectos</a>
            </section>

            <!-- Sección de Contadores -->
            <section id="overlay">
                <div class="background-image"></div>
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="counter">
                                <h6 class="count-up" data-from="0" data-to="98">0</h6>
                                <p>Clientes Felices</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="counter">
                                <h6 class="count-up" data-from="0" data-to="98">0</h6>
                                <p>Descargas Totales</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="counter">
                                <h6 class="count-up" data-from="0" data-to="100">0</h6>
                                <p>Premios Ganados</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="counter">
                                <h6 class="count-up" data-from="0" data-to="350">0</h6>
                                <p>Usuarios Activos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="footer mt-auto py-4 bg-dark text-white">
                <div class="container">
                    <div class="row">
                        <!-- Información de contacto -->
                        <div class="col-md-4 mb-3">
                            <h5>Contacto</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt"></i> Dirección: Calle 123, Ciudad, País</li>
                                <li><i class="fas fa-phone"></i> Teléfono: +1 (555) 123-4567</li>
                                <li><i class="fas fa-envelope"></i> Email: contacto@ramosdrywall.com</li>
                            </ul>
                        </div>
                        <!-- Enlaces rápidos -->
                        <div class="col-md-4 mb-3">
                            <h5>Enlaces rápidos</h5>
                            <ul class="list-unstyled">
                                <li><a href="index.php" class="text-white">Inicio</a></li>
                                <li><a href="servicios.html" class="text-white">Servicios</a></li>
                                <li><a href="proyectos.html" class="text-white">Proyectos</a></li>
                                <li><a href="contacto.html" class="text-white">Contacto</a></li>
                            </ul>
                        </div>
                        <!-- Redes sociales -->
                        <div class="col-md-4 mb-3">
                            <h5>Síguenos</h5>
                            <div class="d-flex justify-content-start">
                                <a href="https://www.facebook.com/" class="me-3 text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://x.com/" class="me-3 text-white"><i class="fab fa-x"></i></a>
                                <a href="https://www.instagram.com/" class="me-3 text-white"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.linkedin.com/" class="me-3 text-white"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p class="mb-0">&copy; 2024 Ramos Drywall. Todos los derechos reservados.</p>
                    </div>
                </div>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../../js/landing/menu-scroll.js"></script>
            <script src="../../js/landing/contador.js"></script>

</body>

</html>