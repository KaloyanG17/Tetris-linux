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
?>