<?php 
//Creates a Log out program and returns the user to the same page
session_start();
session_destroy();
header("Location:index.php");
?>
