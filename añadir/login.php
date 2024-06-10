<?php
include('check.php');

$estado = "error";
$rol = ""; 

if(isset($_POST['submit'])) {
    $user = $_POST['username'];
    $password = $_POST['password'];

    // Eliminar posibles caracteres peligrosos
    $user = stripslashes($user);
    $password = stripslashes($password);

    // Usar PDO para evitar SQL Injection
    $stmt = $pdo->prepare("SELECT Usuario, Contraseña, Rol FROM administradores WHERE Usuario = :user");
    $stmt->bindParam(':user', $user);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comprobar la contraseña
        if ($row['Contraseña'] === $password) {  // Solo si las contraseñas están en texto plano
            $rol = $row['Rol'];
            
            if ($rol == 'superadministrador' || $rol == 'administrador') {
                $estado = "success"; 
            }
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}

if ($estado === "success" && $rol === "superadministrador") {
    header('Location: ../dashboard.html?estado=success&rol=superadministrador');
} elseif ($estado === "success" && $rol === "administrador") {
    header('Location: ../dashboard.html?estado=success&rol=administrador');
} else {
    header('Location: ../categorias.html?estado=error');
}
?>
