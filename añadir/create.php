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
        .ocultar-menu {
          display: none;
        }
    </style>
        <style>
        .wrapper{
            display: flex;
        }
    </style>
 
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
    <div class="container-fluid">
      
      <a href="../index.html">
        <img class="logo navbar-brand" src="../Imagenes/logoGalileo.png"></img>
      </a>
        <button class="navbar-toggler" style="color: white !important; border-color: white !important; padding: 2px 3px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon-custom navbar-toggler-icon"></span>
      </button>
      <div class="menu-posicion collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="menu nav-link" aria-current="page" href="../index.html">Inicio</a>
          </li>
          <li class="nav-item ocultar-menu">
            <a class="menu nav-link" href="../categorias.html">Categorías</a>
          </li>
          <li class="nav-item">
            <a class="menu nav-link" href="../contactanos.html">Contáctanos</a>
          </li>
          
        </ul>
        <div>
          <a class="d-flex" style="text-decoration: none !important;" href="../categorias.html">
            <button type="button" class="mayuscula btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: #6BE5DA !important; color: #3552A6 !important; border-radius: 4px !important; border-color: #6BE5DA !important; font-weight: bold !important;">
                Identifícate
            </button>
            </a>
        </div>
      </div>

    </div>
</nav>


  <div class="row subir-banner" style="--bs-gutter-x: 0 !important; margin-top: 4em !important; margin-bottom: 1em !important;">
    <div class="col text-center">
        <h1 class="pb-3" style="color: #3552A6 !important; font-size: 44px !important;">Crear nuevo administrador</h1>
    </div>
  </div>   

  <?php
// Include config file
require_once "check.php";
 
// Define variables and initialize with empty values
$username = $password = $telefono = $email = $entidad = $estado = $rol = "";
$username_err = $password_err = $telefono_err = $email_err = $entidad_err = $estado_err = $rol_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Introduce un usuario.";
    } else{
        $username = $input_username;
    }
    
    // Validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Introduce una contraseña.";     
    } else{
        $password = $input_password;
    }
    
    // Validate telefono
    $input_telefono = trim($_POST["telefono"]);
    if(empty($input_telefono)){
        $telefono_err = "Introduce un teléfono.";     
    } else{
        $telefono = $input_telefono;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Introduce un email.";     
    } else{
        $email = $input_email;
    }

    // Validate entidad
    $input_entidad = trim($_POST["entidad"]);
    if(empty($input_entidad)){
        $entidad_err = "Introduce una entidad.";     
    } else{
        $entidad = $input_entidad;
    }

    // Validate estado
    $input_estado = trim($_POST["estado"]);
    if(empty($input_estado)){
        $estado_err = "Introduce un estado.";     
    } elseif($input_estado !== "activo" && $input_estado !== "inactivo") {
        $estado_err = "Valor inválido. Solo puede ser 'activo' e 'inactivo'.";
    } else{
        $estado = $input_estado;
    }

    // Validate rol
    $input_rol = trim($_POST["rol"]);
    if(empty($input_rol)){
        $rol_err = "Introduce un rol.";     
    } elseif($input_rol !== "administrador" && $input_rol !== "superadministrador") {
        $rol_err = "Valor inválido. Solo puede ser 'administrador' o 'superadministrador'.";
    } else{
        $rol = $input_rol;
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($telefono_err) && empty($email_err) && empty($entidad_err) && empty($estado_err) && empty($rol_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO administradores (Usuario, Contraseña, Telefono, Email, Entidad, Estado, Rol) VALUES (:username, :password, :telefono, :email, :entidad, :estado, :rol)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username);
            $stmt->bindParam(":password", $param_password);
            $stmt->bindParam(":telefono", $param_telefono);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":entidad", $param_entidad);
            $stmt->bindParam(":estado", $param_estado);
            $stmt->bindParam(":rol", $param_rol);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
            $param_telefono = $telefono;
            $param_email = $email;
            $param_entidad = $entidad;
            $param_estado = $estado;
            $param_rol = $rol;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: crud.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>

  <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>">
                            <span class="invalid-feedback"><?php echo $telefono_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Entidad</label>
                            <input type="text" name="entidad" class="form-control <?php echo (!empty($entidad_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $entidad; ?>">
                            <span class="invalid-feedback"><?php echo $entidad_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control <?php echo (!empty($estado_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $estado; ?>">
                            <span class="invalid-feedback"><?php echo $estado_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <input type="text" name="rol" class="form-control <?php echo (!empty($rol_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rol; ?>">
                            <span class="invalid-feedback"><?php echo $rol_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Crear">
                        <a href="crud.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <footer class="footerabajo footer pb-4">
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
                          <li><a href="#"  style="padding-top: 2px !important; text-decoration: none !important; color: white !important;">Contacto</a></li>
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

    <script src="../script.js"></script>

</body>
</html>


