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
    <title>Productos</title>
    <link rel="stylesheet" href="./admins.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="../../Imagenes/favicon.png" type="image/png" sizes="16x16">
    <script src="https://cdn.tiny.cloud/1/ss8n4v14605wifuydbdfxrnz03f8s6y1gscbtelvjnyrejd6/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <script>
      tinymce.init({
          selector: '#exampleFormControlTextarea1, #editFormControlTextarea1',
          plugins: 'link',
          toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | link',
          menubar: false
      });

      document.addEventListener('DOMContentLoaded', function () {
          var accordion = document.getElementById('accordionExample');
          Sortable.create(accordion, {
              handle: '.accordion-header',
              animation: 150
          });

          function addDeleteEvent(button) {
              button.addEventListener('click', function () {
                  var item = button.closest('.accordion-item');
                  item.parentNode.removeChild(item);
              });
          }

          function addEditEvent(button) {
              button.addEventListener('click', function () {
                  var item = button.closest('.accordion-item');
                  var nombrePregunta = item.querySelector('.accordion-button').innerText;
                  var descripcionPregunta = item.querySelector('.accordion-body').innerHTML;
                  var videoElement = item.querySelector('video source');
                  var videoURL = videoElement ? videoElement.src : '';

                  // Prellenar el modal de edición
                  document.getElementById('editFormControlInput1').value = nombrePregunta;
                  tinymce.get('editFormControlTextarea1').setContent(descripcionPregunta);
                  document.getElementById('editVideoUpload').value = '';

                  // Mostrar el modal de edición
                  var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
                  editModal.show();

                  // Guardar cambios
                  document.getElementById('guardarCambios').onclick = function () {
                      var nuevoNombre = document.getElementById('editFormControlInput1').value;
                      var nuevaDescripcion = tinymce.get('editFormControlTextarea1').getContent();
                      var nuevoVideoFile = document.getElementById('editVideoUpload').files[0];
                      var nuevoVideoURL = nuevoVideoFile ? URL.createObjectURL(nuevoVideoFile) : videoURL;

                      item.querySelector('.accordion-button').innerText = nuevoNombre;
                      item.querySelector('.accordion-body').innerHTML = nuevaDescripcion;

                      var nuevoVideoFile = document.getElementById('editVideoUpload').files[0];
                        if (nuevoVideoFile) {
                            var nuevoVideoURL = URL.createObjectURL(nuevoVideoFile);
                            item.querySelector('video source').src = nuevoVideoURL;
                            item.querySelector('video').style.display = 'block';  // Asegurarse de que el vídeo se muestre si hay uno nuevo
                        } else if (!videoURL) {
                            // Si no hay un archivo nuevo y tampoco había un vídeo antes, ocultamos el contenedor del vídeo si existe
                            var videoContainer = item.querySelector('video');
                            if (videoContainer) {
                                videoContainer.style.display = 'none';
                            }
                        } else {
                            // Si no hay un archivo nuevo pero sí había un vídeo antes, no cambiamos el src
                            // Aquí no necesitas hacer nada porque el src ya tiene la URL anterior
                        }

                  };
              });
          }

          document.querySelectorAll('.btn-delete').forEach(addDeleteEvent);
          document.querySelectorAll('.btn-edit').forEach(addEditEvent);

          document.getElementById('crearPregunta').addEventListener('click', function (e) {
            e.preventDefault(); // Evitar el comportamiento predeterminado del formulario
            var nombrePregunta = document.getElementById('exampleFormControlInput1').value;
            var descripcionPregunta = tinymce.get('exampleFormControlTextarea1').getContent();
            var videoFile = document.getElementById('videoUpload').files[0];
            var videoElement = '';

            if (videoFile) {
                var videoURL = URL.createObjectURL(videoFile);
                videoElement = `<video controls class="video-pregunta"><source src="${videoURL}" type="video/mp4">Your browser does not support the video tag.</video>`;
            }

            var newCollapseId = 'collapse' + Date.now(); // Genera un ID único
            var newItem = document.createElement('div');
            newItem.classList.add('accordion-item');
            newItem.innerHTML = `
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${newCollapseId}" aria-expanded="false">
                        ${nombrePregunta}
                    </button>
                    <button class="btn-edit btn btn-primary ms-2" style="background-color: #3552A6 !important; border-color: #3552A6 !important;">Editar</button>
                    <button class="btn-delete btn btn-danger ms-2" style="background-color: #db4437 !important; border-color: #db4437 !important;">Eliminar</button>
                </h2>
                <div id="${newCollapseId}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        ${descripcionPregunta}
                        ${videoElement}
                    </div>
                </div>
            `;

            accordion.appendChild(newItem);

            addDeleteEvent(newItem.querySelector('.btn-delete'));
            addEditEvent(newItem.querySelector('.btn-edit'));

            document.getElementById('exampleFormControlInput1').value = '';
            tinymce.get('exampleFormControlTextarea1').setContent('');
            document.getElementById('videoUpload').value = '';

            var modal = document.getElementById('exampleCrear');
            var modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        });
      });
  </script>
    <style>
      .ocultar-menu {
        display: none;
      }
      .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-delete, .btn-edit {
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
        }
        .btn-edit {
            background-color: blue;
        }
        .video-pregunta {
            width: 100%; /* o el tamaño que prefieras */
            max-width: 500px; /* esto limitará el tamaño máximo */
            height: auto; /* mantiene la relación de aspecto del video */
            border: 2px solid #3552A6 !important;
            border-radius: 5px !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
        <div class="container-fluid">
            <a href="../../index.php">
                <img class="logo navbar-brand" style="margin-right: -2em !important;" src="../../Imagenes/logoGalileo.png"></img>
            </a>
            <button class="navbar-toggler" style="color: white !important; border-color: white !important; padding: 2px 3px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon-custom navbar-toggler-icon"></span>
            </button>
            <div class="menu-posicion collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="menu nav-link" href="../../index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu nav-link ocultar-menu" href="../../menu.php">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu nav-link" href="../../contactanos.php">Contáctanos</a>
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
                                    <li><a class="dropdown-item" href="../../añadir/crud.php">Administradores</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../../añadir/logout.php">Cerrar Sesión</a></li>
                                    <?php else : ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../../añadir/logout.php">Cerrar Sesión</a></li>
                                    <?php endif; ?>
                                </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid padding-abajo">
        <div class="row justify-content-center">
            <div class="banner" style="width: 67% !important; text-align: left !important;">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../../index.php" style="text-decoration: none !important; color: #3552A6 !important;">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="../../dashboard.php" style="text-decoration: none !important; color: #3552A6 !important;">Roles</a></li>
                        <li class="breadcrumb-item"><a href="../../administradores.php" style="text-decoration: none !important; color: #3552A6 !important;">Administradores</a></li>
                        <li class="breadcrumb-item"><a href="productos.php" style="text-decoration: none !important; color: #212529BF !important;">Productos</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="margenpri accordion container-fluid" id="accordionExample" style="--bs-accordion-active-bg: #3552A6 !important; --bs-accordion-btn-focus-box-shadow: #ffffff !important; --bs-accordion-active-color: #ffffff !important; --bs-accordion-btn-color-active: #ffffff !important;">
      <div class="accordion-item">
          <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                  Pregunta 1
              </button>
              <?php if ($rol === 'superadministrador') : ?>
                <button class="btn-edit btn btn-primary ms-2" style="background-color: #3552A6 !important; border-color: #3552A6 !important;">Editar</button>
                <button class="btn-delete btn btn-danger ms-2" style="background-color: #db4437 !important; border-color: #db4437 !important;">Eliminar</button>
            <?php endif; ?>
        
        </h2>
          <div id="collapse1" class="accordion-collapse collapse">
              <div class="accordion-body">
                  Contenido de la pregunta 1.
                  <video controls style="border: 2px solid #3552A6 !important; border-radius: 5px !important; width: 500px !important; display: block !important; margin-left: 0 !important;">
                    <source src="" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
              </div>
          </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                Pregunta 1
            </button>
            <?php if ($rol === 'superadministrador') : ?>
                <button class="btn-edit btn btn-primary ms-2" style="background-color: #3552A6 !important; border-color: #3552A6 !important;">Editar</button>
                <button class="btn-delete btn btn-danger ms-2" style="background-color: #db4437 !important; border-color: #db4437 !important;">Eliminar</button>
            <?php endif; ?>
        
        </h2>
        <div id="collapse2" class="accordion-collapse collapse">
            <div class="accordion-body">
                Contenido de la pregunta 1.
                <video controls style="border: 2px solid #3552A6 !important; border-radius: 5px !important; width: 500px !important; display: block !important; margin-left: 0 !important;">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
              Pregunta 1
          </button>
          <?php if ($rol === 'superadministrador') : ?>
                <button class="btn-edit btn btn-primary ms-2" style="background-color: #3552A6 !important; border-color: #3552A6 !important;">Editar</button>
                <button class="btn-delete btn btn-danger ms-2" style="background-color: #db4437 !important; border-color: #db4437 !important;">Eliminar</button>
            <?php endif; ?>
        
        </h2>
      <div id="collapse3" class="accordion-collapse collapse">
          <div class="accordion-body">
              Contenido de la pregunta 1.
              <video controls style="border: 2px solid #3552A6 !important; border-radius: 5px !important; width: 500px !important; display: block !important; margin-left: 0 !important;">
                  <source src="" type="video/mp4">
                  Your browser does not support the video tag.
              </video>
          </div>
      </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
            Pregunta 1
        </button>
        <?php if ($rol === 'superadministrador') : ?>
                <button class="btn-edit btn btn-primary ms-2" style="background-color: #3552A6 !important; border-color: #3552A6 !important;">Editar</button>
                <button class="btn-delete btn btn-danger ms-2" style="background-color: #db4437 !important; border-color: #db4437 !important;">Eliminar</button>
            <?php endif; ?>        
    </h2>
    <div id="collapse4" class="accordion-collapse collapse">
        <div class="accordion-body">
            <div class="question-content">
                Contenido de la pregunta 1.
                <video controls style="border: 2px solid #3552A6 !important; border-radius: 5px !important; width: 500px !important; display: block !important; margin-left: 0 !important;">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
</div>


<?php if ($rol === 'superadministrador') : ?>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block d-flex mx-auto mb-3" data-bs-toggle="modal" data-bs-target="#exampleCrear" style="background-color: #6BE5DA !important; color: #3552A6 !important; border-radius: 4px !important; border-color: #6BE5DA !important; font-weight: bold !important; margin-top: 3em !important; text-transform: uppercase !important;">Añadir Pregunta</button> 
        </div>
<?php endif; ?>

<div class="modal fade" id="exampleCrear" tabindex="-1" aria-labelledby="exampleCrearLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleCrearLabel" style="font-weight: bold;">Añade una nueva pregunta.</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Nombre de la pregunta</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
              </div>
              <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Descripción de la pregunta</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"></textarea>
              </div>
              <div class="mb-3">
                  <label for="videoUpload" class="form-label">Subir video (opcional)</label>
                  <input type="file" class="form-control" id="videoUpload" accept="video/mp4, video/webm, video/ogg">
              </div>
              <div class="text-center">
                  <button id="crearPregunta" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block d-flex mx-auto mb-3" style="background-color: #3552A6 !important; border-color: #3552A6 !important; text-transform: uppercase !important; font-weight: 600 !important;">Añadir</button>
              </div>
          </div>
      </div>
  </div>
</div>


<!-- Modal para editar pregunta -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel" style="font-weight: bold;">Editar pregunta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editFormControlInput1" class="form-label">Nombre de la pregunta</label>
                    <input type="text" class="form-control" id="editFormControlInput1" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="editFormControlTextarea1" class="form-label">Descripción de la pregunta</label>
                    <textarea class="form-control" id="editFormControlTextarea1" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="editVideoUpload" class="form-label">Subir video</label>
                    <input type="file" class="form-control" id="editVideoUpload" accept="video/mp4, video/webm, video/ogg">
                </div>
                <div class="text-center">
                    <button id="guardarCambios" type="submit" class="btn btn-primary btn-block d-flex mx-auto mb-3" style="background-color: #3552A6 !important; border-color: #3552A6 !important; text-transform: uppercase !important; font-weight: 600 !important;">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>


        <style>
          .smaller-image {
            max-width: 12em; /* Ancho máximo de la imagen */
            max-height: 12em; /* Altura máxima de la imagen */
          }
      </style>

    <footer class="footer w-100">
        <div class="row px-5 py-5" style="--bs-gutter-x: 0 !important;">
          <div class="container">
            <div class="row">
                <div class="col-sm-4  d-flex justify-content-center pad-abajo"> 
                    <img src="../../Imagenes/Diseño_sin_título__5___1_-removebg-preview.png" alt="Logo" class="img-fluid smaller-image">
                </div>
                <div class="col-sm-4 pad-abajo">
                    <h5>¿Quiénes somos?</h5>
                    <p>Somos Suadeter, una aplicación dedicada a la organización de eventos y servicios deportivos. Nuestra misión es facilitar la planificación y gestión de actividades deportivas para individuos y organizaciones.</p>
                </div>
                <div class="col-sm-4 pad-abajo">
                    <h5>Links Rápidos</h5>
                    <ul>
                        <li><a href="#" style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Servicios</a></li>
                        <li><a href="#"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;"">Eventos</a></li>
                        <li><a href="../../contactanos.html"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;"">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
