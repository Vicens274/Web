<?php
include('check.php');

$estado = "error"; // Por defecto, el estado es "error"

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
        $rol = $row['rol'];
        if ($rol == 'superadministrador') {
            $estado = true; // Redirigir a dashboard para superadministradores
        } elseif ($rol == 'administrador') {
            $estado = false; // Redirigir a categorias para administradores
        } else {
            $estado = "error"; // Si el rol no está definido o es otro, estado es "error"
        }
    } else {
        $estado = "error"; // Si las credenciales son incorrectas, estado es "error"
    }
}

// Enviar el estado como respuesta JSON
echo json_encode(array("estado" => $estado));
?>