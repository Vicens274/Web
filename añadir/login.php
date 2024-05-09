<?php
include('check.php');
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
            header('Location: ../dashboard.html'); // Redirigir a dashboard para superadministradores
        } elseif ($rol == 'administrador') {
            header('Location: ../dashboard.html'); // Redirigir a categorias para administradores
        } else {
            header('Location: ../categorias.html'); // Redirigir a página de inicio de sesión si el rol no está definido o es otro
        }
    } else {
        header('Location: ../categorias.html'); // Redirigir a página de inicio de sesión si las credenciales son incorrectas
    }
}
?>