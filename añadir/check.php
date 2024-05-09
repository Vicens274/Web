<?php

    $con = mysqli_connect('localhost', 'vicente', 'abc123.', 'isadmins');

    if($con == false) {
        die('Error: No se puede conectar a la base de datos');
    }
    
?>