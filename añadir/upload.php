<?php
$servername = "localhost";
$username = "id22057369_vicente";
$password = "#Calvar69";
$dbname = "id22057369_vicente";

// Crea conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexión
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Lee los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$titulo = $data['titulo'];
$descripcion = $data['descripcion'];
$videoUrl = $data['videoUrl'];

// Inserta el artículo
$sql = "INSERT INTO articles (name, description) VALUES ('$titulo', '$descripcion')";

if ($conn->query($sql) === TRUE) {
  $articleId = $conn->insert_id;
  
  // Inserta el video
  $sql = "INSERT INTO videos (article_id, url) VALUES ('$articleId', '$videoUrl')";
  if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el video: ' . $conn->error]);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Error al guardar el artículo: ' . $conn->error]);
}

$conn->close();
?>