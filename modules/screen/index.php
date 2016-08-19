<!DOCTYPE html>
<html>
<head>
<style>
div.container {
    width: 100%;
}

footer {
    padding: 1em;
    clear: left;
    text-align: center;
   
}

nav {
    max-width:50%;
    float: left;
    padding: 1em;
    
}


article {
    padding: 1em;
    overflow: hidden;
    float: right;
}
</style>
</head>
<body>

<div class="container">
  
<nav>
<?php
include('status/status.php');
?> 
</nav>

<article>
<?php
include('status/map_status.php');
?> 
</article>

<footer>
<?php
include('status/charts_status.php');
?> 
</footer>

</div>

</body>
</html>

