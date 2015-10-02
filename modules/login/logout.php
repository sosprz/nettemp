<?php 
    unset($_SESSION['user']);
    unset($_SESSION['perms']);
    header("Location: status"); 
    die("Redirecting to: status");
?>