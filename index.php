<?php
session_start();

// Verificar si el usuario está autenticado
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$rol = $is_logged_in ? $_SESSION['rol'] : '';
$usuario = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki</title>
    <link rel="stylesheet" href="./estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="./Imagenes/favicon.png" type="image/png" sizes="16x16">
 
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
        <div class="container-fluid">
            <a href="./index.php">
                <img class="logo navbar-brand" src="./Imagenes/logoGalileo.png"></img>
            </a>
            <button class="navbar-toggler" style="color: white !important; border-color: white !important; padding: 2px 3px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon-custom navbar-toggler-icon"></span>
            </button>
            <div class="menu-posicion collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="menu nav-link" aria-current="page" href="./index.php">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="menu nav-link" href="./contactanos.php">Contáctanos</a>
                    </li>
                </ul>
                <div>
                    <?php if ($is_logged_in) : ?>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white !important;">
                                    <?php echo $usuario; ?> 
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Rol: <?php echo $rol; ?></a></li>
                                    <?php if ($rol === 'superadministrador') : ?>
                                    <li><a class="dropdown-item" href="./añadir/crud.php">Administradores</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="./añadir/logout.php">Cerrar Sesión</a></li>
                                    <?php else : ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="./añadir/logout.php">Cerrar Sesión</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    <?php else : ?>
                        <a class="d-flex" style="text-decoration: none !important;" href="./categorias.php">
                        <button type="button" class="mayuscula btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: #6BE5DA !important; color: #3552A6 !important; border-radius: 4px !important; border-color: #6BE5DA !important; font-weight: bold !important;">
                            Identifícate
                        </button>
                        </a>
                        <form id="loginForm"></form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="wrapper">
      

    <div class="row subir-banner" style="--bs-gutter-x: 0 !important; background-color: #3552A6;">
        <div class="col banner text-center">
            <h1 class="text-white pb-3" style="color: white !important; font-size: 44px !important;">¿Qué deseas buscar?</h1>
            <form class="d-flex justify-content-center">
                <div class="input-group estirado">
                    <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
                    <button class="btn btn-primary boton-busqueda d-none d-md-inline" type="submit" style="text-transform: uppercase !important;">Buscar</button>
                    <span class="btn btn-primary boton-busqueda d-md-none" type="submit"><i class="bi bi-search"></i></span>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center" style="padding-top: 5em !important;">
        <h1 class="d-flex justify-content-center pb-5"  style="color: #3552A6 !important; font-size: 44px !important;">Base de conocimentos</h1>
    </div>

        <div class="contenido-estirado">
      <div class="padding-abajo">
          <div class="row justify-content-center" style="--bs-gutter-x: 0 !important;">      
              <div class="col-12 col-md-9">
                  <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                  <div class="col">
                    <a href="./usuariogeneral.php" style="text-decoration: none !important;">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Usuario</h3>
                            <p class="card-text">Guía paso a paso para acceder y navegar por la tienda pública.</p>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col">
                    <a href="./categorias.php" style="text-decoration: none !important;">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Administradores</h3>
                            <p class="card-text">Accede al panel de administradores.</p>
                        </div>
                    </div>
                    </a>
                </div>
                </div>
              </div>
          </div>
      </div>
    </div>

    </div>

    <footer class="footer w-100 stickyfooter">
        <div class="row px-5 py-5" style="--bs-gutter-x: 0 !important;">
          <div class="container">
            <div class="row">
                <div class="col-sm-4  d-flex justify-content-center pad-abajo"> 
                    <img src="./Imagenes/Diseño_sin_título__5___1_-removebg-preview.png" alt="Logo" class="img-fluid smaller-image">
                </div>
                <div class="col-sm-4 pad-abajo">
                    <h5>¿Quiénes somos?</h5>
                    <p>Learn4You, una paginas dedicada a la organización de eventos y servicios deportivos. Nuestra misión es facilitar la planificación y gestión de actividades deportivas para individuos y organizaciones.</p>
                </div>
                <div class="col-sm-4 pad-abajo">
                    <h5>Links Rápidos</h5>
                    <ul>
                        <li><a href="#" style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Servicios</a></li>
                        <li><a href="#"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Eventos</a></li>
                        <li><a href="./contactanos.php"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <style>
        .smaller-image {
          max-width: 20em;
          max-height: 12em;
        }
        </style>

      </div>
        <div class="container text-center pb-5" style="padding-top: 15px !important; border-top: 2px solid white !important;">
            <div class="row-cols-sm-2">
            <span class="">© 2024 Powered by Learn4You</span>
            </div>
            <div class="row-cols-sm-2">
              <i class="bi bi-facebook pe-2"></i>
              <i class="bi bi-instagram"></i>
            </div>
        </div>
    </footer>
</body>
</html>
