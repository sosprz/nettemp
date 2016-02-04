<?php 
    session_unset();
    session_destroy();
    header("Location: status"); 
    die("Redirecting to: status");
?>