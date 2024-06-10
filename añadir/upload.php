<?php
require '../vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$servername = "localhost";
$username = "id22057369_vicente";
$password = "#Calvar96";
$dbname = "id22057369_vicente";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
    $question_name = $_POST['question_name'];
    $description = $_POST['description'];
    $file = $_FILES['video'];

    $file_path = $file['tmp_name'];
    $file_name = $file['name'];

    // Configuración de Dropbox
    $app = new DropboxApp("5mrrh69i5pa6ycl", "puf20mjdllm99m6", "sl.B25nTIdbEarYuafCZPx8f95mdZPwocMu2EufNKD02TT_NLFQZYBceBk_r3NIU1GUfxGrHXp0g0VdAmxkxasx5IAa9Zgaq9IGAVLIQnFYONN8RDhbGoTHSLxhNw102DkaX2rw5PWoAB51");
    $dropbox = new Dropbox($app);

    // Subir el archivo a Dropbox
    $dropboxFile = new \Kunnu\Dropbox\DropboxFile($file_path);
    $uploadedFile = $dropbox->upload($dropboxFile, "/" . $file_name, ['autorename' => true]);

    // Obtener la URL compartida
    $sharedLink = $dropbox->createSharedLinkWithSettings("/" . $file_name);
    $url = str_replace("dl=0", "dl=1", $sharedLink->getUrl());

    // Guardar la URL en la base de datos
    $stmt = $conn->prepare("INSERT INTO videos (question_name, description, url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $question_name, $description, $url);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: success.php");
    exit();
}
?>
