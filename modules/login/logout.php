<?php 
    unset($_SESSION['user']);
    unset($_SESSION['perms']);
    unset($_SESSION['accesscam']);
    header("Location: status"); 
    die("Redirecting to: status");
?>