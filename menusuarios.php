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
    <title>Wiki Galileo</title>
    <link rel="stylesheet" href="./estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="./Imagenes/favicon.png" type="image/png" sizes="16x16">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

 
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
                        <a class="menu nav-link" href="./menu.php">Información</a>
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


    <div class="container-fluid padding-abajo" style="padding-top: 5em !important;">
        <div class="row justify-content-center">
            <div class="" style="width: 67% !important; text-align: left !important;">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./index.php" style="text-decoration: none !important; color: #3552A6 !important;">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="./menu.php" style="text-decoration: none !important; color: #3552A6 !important;">¿Qué eres?</a></li>
                        <li class="breadcrumb-item"><a href="./menusuarios.php" style="text-decoration: none !important; color: #212529BF !important;">Usuarios</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h1 class="d-flex justify-content-center pb-5"  style="color: #3552A6 !important; font-size: 44px !important;">Categorías Usuario</h1>
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
                            <h3 class="card-title">Tienda Pública</h3>
                            <p class="card-text">Guía paso a paso para acceder y navegar por la tienda pública.</p>
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

    <?php if ($rol === 'superadministrador') : ?>
    <div class="d-flex justify-content-center align-items-center">
        <button id="btnAñadirSeccion" type="button" class="mayuscula btn btn-primary " data-bs-toggle="modal" data-bs-target="#example" style="background-color: #6BE5DA !important; color: #3552A6 !important; border-radius: 4px !important; border-color: #6BE5DA !important; font-weight: bold !important; margin-top: 3em !important;">
            Añadir Seccion
        </button>
        <?php endif; ?>

        <div class="modal fade" id="example" tabindex="-1" aria-labelledby="exampleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleLabel" style="font-weight: bold;">Añade una nueva sección.</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nombre de la sección</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Descripción de la sección</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="text-center">
                            <button id="crearSeccion" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block d-flex mx-auto mb-3" style="background-color: #3552A6 !important; border-color: #3552A6 !important; text-transform: uppercase !important; font-weight: 600 !important;">Crear</button>
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
                    <p>Somos Suadeter, una aplicación dedicada a la organización de eventos y servicios deportivos. Nuestra misión es facilitar la planificación y gestión de actividades deportivas para individuos y organizaciones.</p>
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
          max-width: 12em;
          max-height: 12em;
        }
        </style>

      </div>
        <div class="container text-center pb-5" style="padding-top: 15px !important; border-top: 2px solid white !important;">
            <div class="row-cols-sm-2">
             <span class="">© 2024 Powered by Saudeter</span>
            </div>
            <div class="row-cols-sm-2">
              <i class="bi bi-facebook pe-2"></i>
              <i class="bi bi-instagram"></i>
            </div>
        </div>
    </footer>
</body>
</html>
