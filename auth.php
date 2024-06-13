<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Verificar si el usuario tiene el rol adecuado (en este caso, 'administrador' o 'superadministrador')
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'administrador' && $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: ./categorias.php');
    exit;
}
?>