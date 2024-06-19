<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ./categorias.php'); // Redirigir al login si no está autenticado
    exit;
}


$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // Obtener el nombre de usuario de la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taquilleros</title>
    <link rel="stylesheet" href="./categorias.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="./Imagenes/favicon.png" type="image/png" sizes="16x16">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" crossorigin="anonymous"></script>


    <style>
        .ocultar-menu {
          display: none;
        }
        .sortable-ghost {
            opacity: 1;
            background-color: #e8e8e8;
        }
    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
        <div class="container-fluid">
            <a href="./index.php">
                <img class="logo navbar-brand" style="margin-right: -2em !important;" src="./Imagenes/logoGalileo.png"></img>
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
                        <a class="menu nav-link ocultar-menu" href="./menu.php">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu nav-link" href="./contactanos.php">Contáctanos</a>
                    </li>
                </ul>
                <div>
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
                </div>
            </div>
        </div>
    </nav>

    <div class="wrapper">

    <div class="container-fluid padding-abajo">
        <div class="row justify-content-center">
            <div class="banner" style="width: 67% !important; text-align: left !important;">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./index.php" style="text-decoration: none !important; color: #3552A6 !important;">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="./dashboard.php" style="text-decoration: none !important; color: #3552A6 !important;">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Taquilleros</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row subir-banner" style="--bs-gutter-x: 0 !important; margin-top: 4em !important; margin-bottom: 1em !important;">
        <div class="col text-center">
            <h1 class="pb-3" style="color: #3552A6 !important; font-size: 44px !important;">Taquilleros</h1>
        </div>
    </div>           

    <div class="padding-abajo"  style="margin-top: 2em !important;">
        <div class="row justify-content-center"  style="--bs-gutter-x: 0 !important;">
            <div class="col-12 col-md-9" id="sectionContainer">
                <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center" id="sortable">
                    
                    
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
        </div>
    </div>
    </div>
         <!-- Modal para editar seccion -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel" style="font-weight: bold;">Editar sección</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editFormControlInput1" class="form-label">Nombre de la sección</label>
                            <input type="text" class="form-control" id="editFormControlInput1" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="editFormControlTextarea1" class="form-label">Descripción de la sección</label>
                            <textarea class="form-control" id="editFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="text-center">
                            <button id="guardarCambios" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block d-flex mx-auto mb-3" style="background-color: #3552A6 !important; border-color: #3552A6 !important; text-transform: uppercase !important; font-weight: 600 !important;">Guardar</button>
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
                        <p>Learn4You, Una página dedicada a la organización de eventos y servicios deportivos. Nuestra misión es facilitar la planificación y gestión de actividades deportivas para individuos y organizaciones.</p>
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
        </div>

        <style>
        .smaller-image {
          max-width: 20em;
          max-height: 12em;
        }
        </style>

        <div class="container text-center" style="padding-top: 15px !important; border-top: 2px solid white !important;">
            <div class="row-cols-sm-2">
             <span class="">© 2024 Powered by Learn4You</span>
            </div>
            <div class="row-cols-sm-2">
              <i class="bi bi-facebook pe-2"></i>
              <i class="bi bi-instagram"></i>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sortable = document.getElementById('sortable');
            var categorias = [
                { nombre: 'Calendario de Sesiones', descripcion: 'Mantente al tanto de las sesiones, eventos y fechas importantes con nuestro calendario integrado.', link: './categorias/Admins/calendariosesiones.php' },
                { nombre: 'Escáner', descripcion: 'Explora y busca rápidamente información relevante con nuestra herramienta de escaneo avanzada.', link: './categorias/Admins/escaner.php' },
                { nombre: 'Ventas', descripcion: 'Controla y administra todas tus ventas y su estado desde nuestro panel para administradores.', link: './categorias/Admins/ventas.php' }
            ];

            function crearTarjeta(categoria, index) {
                var col = document.createElement('div');
                col.classList.add('col');
                
                var card = document.createElement('div');
                card.classList.add('card', 'h-100');

                var cardBody = document.createElement('div');
                cardBody.classList.add('card-body');

                var titulo = document.createElement('h3');
                titulo.classList.add('card-title');
                titulo.textContent = categoria.nombre;

                var descripcion = document.createElement('p');
                descripcion.classList.add('card-text');
                descripcion.textContent = categoria.descripcion;

                var link = document.createElement('a');
                link.href = categoria.link;
                link.style.textDecoration = 'none';

                <?php if ($rol === 'superadministrador') : ?>
                var editButton = document.createElement('button');
                editButton.classList.add('btn', 'btn-secondary', 'mt-2');
                editButton.textContent = 'Editar';
                editButton.dataset.index = index;
                editButton.setAttribute('data-bs-toggle', 'modal');
                editButton.setAttribute('data-bs-target', '#editModal');

                editButton.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevenir la redirección predeterminada al hacer clic en el botón
                    document.getElementById('editFormControlInput1').value = categoria.nombre;
                    document.getElementById('editFormControlTextarea1').value = categoria.descripcion;
                    document.getElementById('guardarCambios').dataset.index = this.dataset.index;
                });

                cardBody.appendChild(editButton);
                <?php endif; ?>


                cardBody.appendChild(titulo);
                cardBody.appendChild(descripcion);
                card.appendChild(cardBody);
                link.appendChild(card);
                col.appendChild(link);

                return col;
            }

            function actualizarLista() {
                sortable.innerHTML = '';
                categorias.forEach(function (categoria, index) {
                    var tarjeta = crearTarjeta(categoria, index);
                    sortable.appendChild(tarjeta);
                });
                Sortable.create(sortable, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function (evt) {
                        var item = categorias.splice(evt.oldIndex, 1)[0];
                        categorias.splice(evt.newIndex, 0, item);
                        actualizarLista();
                    }
                });
            }

            document.getElementById('crearSeccion').addEventListener('click', function () {
                var nombre = document.getElementById('exampleFormControlInput1').value;
                var descripcion = document.getElementById('exampleFormControlTextarea1').value;
                if (nombre && descripcion) {
                    categorias.push({ nombre: nombre, descripcion: descripcion, link: '#' });
                    actualizarLista();
                    document.getElementById('exampleFormControlInput1').value = '';
                    document.getElementById('exampleFormControlTextarea1').value = '';
                    var exampleModal = document.getElementById('example');
                    var modal = bootstrap.Modal.getInstance(exampleModal);
                    modal.hide();
                }
            });

            document.getElementById('guardarCambios').addEventListener('click', function () {
                var index = this.dataset.index;
                var nombre = document.getElementById('editFormControlInput1').value;
                var descripcion = document.getElementById('editFormControlTextarea1').value;
                if (nombre && descripcion) {
                    categorias[index].nombre = nombre;
                    categorias[index].descripcion = descripcion;
                    actualizarLista();
                    var editModal = document.getElementById('editModal');
                    var modal = bootstrap.Modal.getInstance(editModal);
                    modal.hide();
                }
            });

            actualizarLista();
        });
    </script>
    
</body>
</html>