<?php
session_start();
session_destroy();
header("Location: main.php"); // Redirect to the login page or any other appropriate page
exit();
?>