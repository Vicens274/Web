<?php
require_once "check.php";

// Inicializar variables con valores vacíos
$Usuario = $Contraseña = $Telefono = $Email = $Entidad = $Estado = $Rol = "";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener valores del formulario
    $Usuario = $_POST["Usuario"];
    $Contraseña = $_POST["Contraseña"];
    $Telefono = $_POST["Telefono"];
    $Email = $_POST["Email"];
    $Entidad = $_POST["Entidad"];
    $Estado = $_POST["Estado"];
    $Rol = $_POST["Rol"];

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE administradores 
            SET Contraseña = :Contraseña, 
                Telefono = :Telefono, 
                Email = :Email, 
                Entidad = :Entidad, 
                Estado = :Estado, 
                Rol = :Rol 
            WHERE Usuario = :Usuario";

    // Preparar la declaración
    $stmt = $pdo->prepare($sql);

    // Verificar y ejecutar la declaración
    try {
        $stmt->bindParam(":Contraseña", $Contraseña);
        $stmt->bindParam(":Telefono", $Telefono);
        $stmt->bindParam(":Email", $Email);
        $stmt->bindParam(":Entidad", $Entidad);
        $stmt->bindParam(":Estado", $Estado);
        $stmt->bindParam(":Rol", $Rol);
        $stmt->bindParam(":Usuario", $Usuario);
        
        // Ejecutar la declaración
        $stmt->execute();

        // Redirigir a la página de CRUD después de la actualización exitosa
        header("Location: crud.php");
        exit();
    } catch (PDOException $e) {
        // Mostrar mensaje de error si ocurre una excepción
        echo "Error: " . $e->getMessage();
    }
} else {
    // Verificar si se recibe el parámetro de ID por GET
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Consulta SQL para obtener los datos del registro específico
        $sql = "SELECT * FROM administradores WHERE Usuario = :Usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":Usuario", $param_Usuario);
        $param_Usuario = trim($_GET["id"]);

        // Ejecutar la declaración y verificar si se obtuvo un registro
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                // Obtener los datos del registro en un array asociativo
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $Usuario = $row["Usuario"];
                $Contraseña = $row["Contraseña"];
                $Telefono = $row["Telefono"];
                $Email = $row["Email"];
                $Entidad = $row["Entidad"];
                $Estado = $row["Estado"];
                $Rol = $row["Rol"];
            } else {
                // Redirigir a la página de error si no se encuentra el registro
                header("location: error.php");
                exit();
            }
        } else {
            // Mostrar mensaje de error si ocurre un problema al ejecutar la consulta
            echo "Oops! Algo salió mal. Por favor, intente nuevamente más tarde.";
        }
    } else {
        // Redirigir a la página de error si no se recibe el parámetro de ID
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Administrador</title>
    <link rel="stylesheet" href="../contactanos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .ocultar-menu {
            display: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3">
                        <h2>Actualizar Administrador</h2>
                        <p>Por favor, complete este formulario para actualizar la información del administrador.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET["id"]; ?>" method="post">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" name="Usuario" class="form-control" value="<?php echo htmlspecialchars($Usuario); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="text" name="Contraseña" class="form-control" value="<?php echo htmlspecialchars($Contraseña); ?>">
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="Telefono" class="form-control" value="<?php echo htmlspecialchars($Telefono); ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="Email" class="form-control" value="<?php echo htmlspecialchars($Email); ?>">
                            </div>
                            <div class="form-group">
                                <label>Entidad</label>
                                <input type="text" name="Entidad" class="form-control" value="<?php echo htmlspecialchars($Entidad); ?>">
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="Estado" class="form-control" value="<?php echo htmlspecialchars($Estado); ?>">
                            </div>
                            <div class="form-group">
                                <label>Rol</label>
                                <input type="text" name="Rol" class="form-control" value="<?php echo htmlspecialchars($Rol); ?>">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <a href="crud.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
