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
            header('Location: ../dashboard.html');
        } else {
            header('Location: ../categorias.html');           
            $response = "Error: Credenciales incorrectas";
        }
    }

    echo $response;
?>