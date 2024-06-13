<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
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
    <title>Wiki Galileo</title>
    <link rel="stylesheet" href="../contactanos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="../Imagenes/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            display: flex;
        }
    </style>
    <style>
        .ocultar-menu {
          display: none;
        }
    </style>
 
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
    <div class="container-fluid">
      
      <a href="../index.php">
        <img class="logo navbar-brand" src="../Imagenes/logoGalileo.png"></img>
      </a>
        <button class="navbar-toggler" style="color: white !important; border-color: white !important; padding: 2px 3px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon-custom navbar-toggler-icon"></span>
      </button>
      <div class="menu-posicion collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="menu nav-link" aria-current="page" href="../index.php">Inicio</a>
          </li>
          <li class="nav-item ocultar-menu">
            <a class="menu nav-link" href="../categorias.php">Categorías</a>
          </li>
          <li class="nav-item">
            <a class="menu nav-link" href="../contactanos.php">Contáctanos</a>
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
                                <li><a class="dropdown-item" href="../dashboard.php">Volver</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../index.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
      </div>
    </div>
</nav>

  <div class="row subir-banner" style="--bs-gutter-x: 0 !important; margin-top: 4em !important; margin-bottom: 1em !important;">
    <div class="col text-center">
        <h1 class="pb-3" style="color: #3552A6 !important; font-size: 44px !important;">Eliminar Administrador</h1>
    </div>
  </div>   

  <?php
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Include config file
        require_once "check.php";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["confirm"]) && $_POST["confirm"] == "Si") {
                // Prepare a delete statement
                $sql = "DELETE FROM administradores WHERE Usuario = :Usuario";
                
                if($stmt = $pdo->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":Usuario", $param_Usuario);
                    
                    // Set parameters 
                    $param_Usuario = trim($_GET["id"]);

                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Records deleted successfully. Redirect to landing page
                        header("location: crud.php");
                        exit();
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
                
                // Close statement
                unset($stmt);
            } else {
                // Redirect to CRUD page if user cancels
                header("location: crud.php");
                exit();
            }
        }
        
        // Close connection
        unset($pdo);
    } else{
        // Check existence of id parameter
        if(empty(trim($_GET["id"]))){
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET["id"]; ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="Usuario" value="<?php echo isset($_POST["Usuario"]) ? htmlspecialchars($_POST["Usuario"]) : ''; ?>">
                            <p>¿Seguro que quieres eliminar este administrador de la base de datos?</p>
                            <p>
                                <input type="submit" name="confirm" value="Si" class="btn btn-danger">
                                <a href="crud.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <footer class=" footer pb-4 fixed-bottom">
      <div class="row px-5 py-5" style="--bs-gutter-x: 0 !important;">
          <div class="container">
              <div class="row">
                  <div class="col-sm-4  d-flex justify-content-center pad-abajo"> 
                      <img src="../Imagenes/Diseño_sin_título__5___1_-removebg-preview.png" alt="Logo" class="img-fluid smaller-image">
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
                          <li><a href="../contactanos.php"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Contacto</a></li>
                      </ul>
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


      <div class="container text-center" style="padding-top: 15px !important; border-top: 2px solid white !important;">
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



