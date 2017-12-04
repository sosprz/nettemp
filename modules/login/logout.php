<?php 
    session_unset();
    session_destroy();
    setcookie('stay_login', null, -1, '/');
    header("Location: status"); 
    die("Redirecting to: status");
?>
