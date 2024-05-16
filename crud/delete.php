<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["confirm"] == "Yes") {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
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
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET["id"]; ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="Usuario" value="<?php echo isset($_POST["Usuario"]) ? htmlspecialchars($_POST["Usuario"]) : ''; ?>">
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" name="confirm" value="Yes" class="btn btn-danger">
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
