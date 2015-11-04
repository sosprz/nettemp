<?php

// configuration
//$url = 'http://domain.com/backend/editor.php';
$file = 'tmp/ownwidget.php';

// check if form has been submitted
if (isset($_POST['text']))
{
    // save the text contents
    file_put_contents($file, $_POST['text']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

?>
<html>
 <head>
  <style>
   textarea { width: 100%; height: 100%; }
  </style>
 </head>
 <body>
  <!-- HTML form -->
  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="text"><?php echo htmlspecialchars($text) ?></textarea><br />
    </div>
   <input type="submit" value="Save" />
  </form>
 </body>
</html>