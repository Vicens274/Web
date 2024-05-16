<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$usuario = $contraseña = $telefono = $email = $entidad = $estado = $rol = "";
$usuario_err = $contraseña_err = $telefono_err = $email_err = $entidad_err = $estado_err = $rol_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate usuario
    $input_usuario = trim($_POST["usuario"]);
    if(empty($input_usuario)){
        $usuario_err = "Please enter a username.";
    } else{
        $usuario = $input_usuario;
    }
    
    // Validate contraseña
    $input_contraseña = trim($_POST["contraseña"]);
    if(empty($input_contraseña)){
        $contraseña_err = "Please enter a password.";     
    } else{
        $contraseña = $input_contraseña;
    }
    
    // Validate telefono
    $input_telefono = trim($_POST["telefono"]);
    if(empty($input_telefono)){
        $telefono_err = "Please enter a phone number.";     
    } else{
        $telefono = $input_telefono;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email address.";     
    } else{
        $email = $input_email;
    }

    // Validate entidad
    $input_entidad = trim($_POST["entidad"]);
    if(empty($input_entidad)){
        $entidad_err = "Please enter an entity.";     
    } else{
        $entidad = $input_entidad;
    }

    // Validate estado
    $input_estado = trim($_POST["estado"]);
    if(empty($input_estado)){
        $estado_err = "Please enter a state.";     
    } else{
        $estado = $input_estado;
    }

    // Validate rol
    $input_rol = trim($_POST["rol"]);
    if(empty($input_rol)){
        $rol_err = "Please enter a role.";     
    } else{
        $rol = $input_rol;
    }
    
    // Check input errors before inserting in database
    if(empty($usuario_err) && empty($contraseña_err) && empty($telefono_err) && empty($email_err) && empty($entidad_err) && empty($estado_err) && empty($rol_err)){
        // Prepare an update statement
        $sql = "UPDATE administradores SET Usuario=:usuario, Contraseña=:contraseña, Telefono=:telefono, Email=:email, Entidad=:entidad, Estado=:estado, Rol=:rol WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":usuario", $param_usuario);
            $stmt->bindParam(":contraseña", $param_contraseña);
            $stmt->bindParam(":telefono", $param_telefono);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":entidad", $param_entidad);
            $stmt->bindParam(":estado", $param_estado);
            $stmt->bindParam(":rol", $param_rol);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_usuario = $usuario;
            $param_contraseña = $contraseña;
            $param_telefono = $telefono;
            $param_email = $email;
            $param_entidad = $entidad;
            $param_estado = $estado;
            $param_rol = $rol;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM administradores WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $usuario = $row["Usuario"];
                    $contraseña = $row["Contraseña"];
                    $telefono = $row["Telefono"];
                    $email = $row["Email"];
                    $entidad = $row["Entidad"];
                    $estado = $row["Estado"];
                    $rol = $row["Rol"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the administrator record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="usuario" class="form-control <?php echo (!empty($usuario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usuario; ?>">
                            <span class="invalid-feedback"><?php echo $usuario_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="contraseña" class="form-control <?php echo (!empty($contraseña_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contraseña; ?>">
                            <span class="invalid-feedback"><?php echo $contraseña_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>">
                            <span class="invalid-feedback"><?php echo $telefono_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Entity</label>
                            <input type="text" name="entidad" class="form-control <?php echo (!empty($entidad_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $entidad; ?>">
                            <span class="invalid-feedback"><?php echo $entidad_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="estado" class="form-control <?php echo (!empty($estado_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $estado; ?>">
                            <span class="invalid-feedback"><?php echo $estado_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" name="rol" class="form-control <?php echo (!empty($rol_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rol; ?>">
                            <span class="invalid-feedback"><?php echo $rol_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
