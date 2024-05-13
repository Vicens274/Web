<?php
include('check.php');

$estado = "error"; // Por defecto, el estado es "error"
$rol = ""; // Por defecto, el rol es vacío

if(isset($_POST['submit'])) {
    $user  = $_POST['username'];
    $password = $_POST['password'];

    $user = stripslashes($user);
    $password = stripslashes($password);

    $user = mysqli_real_escape_string($con, $user);
    $password = mysqli_real_escape_string($con, $password);

    $query = "SELECT * FROM administradores WHERE Usuario ='$user' AND Contraseña ='$password'";
    $result = mysqli_query($con, $query);
    
    if($result->num_rows > 0) {
        // Obtener el rol del usuario
        $row = $result->fetch_assoc();
        $rol = $row['Rol'];
        
        if ($rol == 'superadministrador') {
            $estado = "success"; // Redirigir a dashboard para superadministradores
        } elseif ($rol == 'administrador') {
            $estado = "success"; // Redirigir a categorias para administradores
        } else {
            $estado = "error"; // Si el rol no está definido o es otro, estado es "error"
        }
    } else {
        $estado = "error"; // Si las credenciales son incorrectas, estado es "error"
    }
}

// Redirigir según el estado y pasar datos en la URL si no hay redirección
if ($estado === "success" && $rol === "superadministrador") {
    header('Location: ../dashboard.html?estado=success&rol=superadministrador');
} elseif ($estado === "success" && $rol === "administrador") {
    header('Location: ../dashboard.html?estado=success&rol=administrador');
} else {
    // No se ejecutará la redirección si hubo un error o el rol no estaba definido
    header('Location: ../categorias.html?estado=error');
}
?>
