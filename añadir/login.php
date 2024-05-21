<?php
include('check.php');

$estado = "error";
$rol = ""; 

if(isset($_POST['submit'])) {
    $user  = $_POST['username'];
    $password = $_POST['password'];

    echo "Usuario: " . $user . "<br>";
    echo "Contraseña: " . $password . "<br>";

    $user = stripslashes($user);
    $password = stripslashes($password);

    $user = mysqli_real_escape_string($con, $user);
    $password = mysqli_real_escape_string($con, $password);

    $query = "SELECT Usuario, Contraseña FROM administradores WHERE Usuario ='$user' AND Contraseña ='$password'";
    $result = mysqli_query($con, $query);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rol = $row['Rol'];
        
        if ($rol == 'Superadministrador') {
            $estado = "success"; 
        } elseif ($rol == 'Administrador') {
            $estado = "success"; 
        } else {
            $estado = "error"; 
        }
    } else {
        $estado = "error"; 
    }
}

if ($estado === "success" && $rol === "Superadministrador") {
    header('Location: ../dashboard.html?estado=success&rol=superadministrador');
} elseif ($estado === "success" && $rol === "Administrador") {
    header('Location: ../dashboard.html?estado=success&rol=administrador');
} else {
    header('Location: ../categorias.html?estado=error');
}
?>