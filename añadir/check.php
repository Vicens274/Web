<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id22057369_vicente');
define('DB_PASSWORD', '#Calvar69');
define('DB_NAME', 'id22057369_vicente');
 
// Attempt to connect to MySQL database
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
