<?php 
    unset($_SESSION['user']);
    header("Location: status"); 
    die("Redirecting to: status");
?>