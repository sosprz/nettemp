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
    float: left;
    max-width: 160px;
    margin: 0;
    padding: 1em;
    
}

nav ul {
    list-style-type: none;
    padding: 0;
}
   
nav ul a {
    text-decoration: none;
}

article {
    margin-left: 25%;
    padding: 1em;
    overflow: hidden;
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

