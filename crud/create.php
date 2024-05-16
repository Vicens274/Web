<?php
// Include config file
require_once "config.php";
 
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
        $estado_err = "Valor inválido. Solo puede ser 'Activo' e 'Inactivo'.";
    } else{
        $estado = $input_estado;
    }

    // Validate rol
    $input_rol = trim($_POST["rol"]);
    if(empty($input_rol)){
        $rol_err = "Introduce un rol.";     
    } elseif($input_rol !== "administrador" && $input_rol !== "superadministrador") {
        $rol_err = "Valor inválido. Solo puede ser 'Administrador' o 'Superadministrador'.";
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Crear Administrador</h2>
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
