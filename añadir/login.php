<?php
session_start(); // Iniciar la sesión
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
            $_SESSION['rol'] = $row['Rol']; // Guardar el rol en la sesión
            $_SESSION['username'] = $row['Usuario']; // Guardar el nombre de usuario en la sesión
            $_SESSION['loggedin'] = true; // Marcar como autenticado
            $estado = "success";
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}

if ($estado === "success") {
    header('Location: ../dashboard.php');
} else {
    header('Location: ../categorias.html?estado=error');
}
?>
