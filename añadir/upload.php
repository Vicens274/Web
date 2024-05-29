<?php
include('check.php');
require './vendor/autoload.php'; // Asegúrate de tener el SDK de Dropbox instalado vía Composer

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $video = $_FILES['video'];

    if ($video['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $video['tmp_name'];
        $name = basename($video['name']);

        // Configurar Dropbox
        $app = new DropboxApp("5mrrh69i5pa6ycl", "puf20mjdllm99m6", "sl.B2InqJ_utlaAfKB7sdewaCsu80R_e2LGQMSX4LtHPWaCkezwlsfHDYBLtbUABIjWvxN5wFa-xQFx15Wst0UavWW31RR3H6MCgjTy1opSJWxDzTv2x17JM-W34SboqJVZjQcS7RZEVx5Y");
        $dropbox = new Dropbox($app);

        // Subir archivo a Dropbox
        $dropboxFile = new DropboxFile($tmp_name);
        $uploadedFile = $dropbox->upload($dropboxFile, "/videos/$name", ['autorename' => true]);

        // Obtener la URL compartida
        $sharedLink = $dropbox->createSharedLinkWithSettings($uploadedFile->getPathDisplay());
        $url = str_replace("?dl=0", "?dl=1", $sharedLink['url']);

        // Insertar en la base de datos
        $sql = "INSERT INTO videos (url) VALUES ('$url')";
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