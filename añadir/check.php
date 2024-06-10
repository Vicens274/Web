<?php
// check.php

// Configuración de la conexión a la base de datos
$host = 'localhost';
$db_name = 'id22057369_vicente';
$username = 'id22057369_vicente';
$password = '#Calvar96';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejar errores de conexión
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}
?>
