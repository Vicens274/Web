<?php
require './vendor/autoload.php'; // Asegúrate de tener el SDK de Dropbox instalado vía Composer

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$servername = "localhost";
$username = "id22057369_vicente";
$password = "#Calvar69";
$dbname = "id22057369_vicente";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $video = $_FILES['video'];

    if ($video['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $video['tmp_name'];
        $name = basename($video['name']);

        // Subir a Dropbox
        $app = new DropboxApp("APP_KEY", "APP_SECRET", "ACCESS_TOKEN");
        $dropbox = new Dropbox($app);

        $dropboxFile = new \Kunnu\Dropbox\DropboxFile($tmp_name);
        $uploadedFile = $dropbox->upload($dropboxFile, "/videos/$name", ['autorename' => true]);

        // Obtener la URL compartida
        $sharedLink = $dropbox->createSharedLinkWithSettings($uploadedFile->getPathDisplay());
        $url = str_replace("?dl=0", "?dl=1", $sharedLink['url']);

        // Insertar en la base de datos
        $sql = "INSERT INTO videos (titulo, descripcion, url) VALUES ('$titulo', '$descripcion', '$url')";
        if ($conn->query($sql) === TRUE) {
            echo "Nuevo video subido exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error al subir el video.";
    }

    $conn->close();
}
?>