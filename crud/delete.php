<?php
// Process delete operation after confirmation
if(isset($_POST["Usuario"]) && !empty($_POST["Usuario"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM administradores WHERE Usuario = :usuario";

    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":usuario", $param_usuario);
        

        // Set parameters
        $param_usuario = trim($_POST["Usuario"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: crud.php?Usuario=" . urlencode($_POST["Usuario"]));
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
            print_r($stmt->errorInfo());
        }
    }
     

    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Administrador</title>
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
                    <h2 class="mt-5 mb-3">Eliminar Administrador</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                        <input type="hidden" name="Usuario" value="<?php echo isset($_POST["Usuario"]) ? htmlspecialchars($_POST["Usuario"]) : ''; ?>"/>
                            <p>Seguro que deseas eliminar este administrador de la base de datos?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="crud.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
