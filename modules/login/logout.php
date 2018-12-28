<?php 
    session_unset();
    session_destroy();
    setcookie('stay_login', null, -1, '/');
    header("Location: index.php?id=status"); 
    die("Redirecting to: index.php?id=status");
?>
