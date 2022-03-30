<?php
//Sets varriables for databse connection
$username = "root";
$password = "root";
$dbname = "tetris";
// Create connection
$conn = mysqli_connect('localhost', 'root' , 'root' , 'tetris' , 8888);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
mysqli_set_charset($conn, 'utf8');
?>