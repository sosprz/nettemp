<?php

$file1 = 'tmp/ownwidget1.php';
$file2 = 'tmp/ownwidget2.php';
$file3 = 'tmp/ownwidget3.php';

if (isset($_POST['text1']))
{
    file_put_contents($file1, $_POST['text1']);

    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

if (isset($_POST['text2']))
{
    file_put_contents($file2, $_POST['text2']);

    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

if (isset($_POST['text3']))
{
    file_put_contents($file3, $_POST['text3']);

    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

$text1 = file_get_contents($file1);
$text2 = file_get_contents($file2);
$text3 = file_get_contents($file3);
?>
  <style>
   textarea { width: 100%; height: 100%; }
  </style>

<div class="panel panel-default">
<div class="panel-heading">Widget example</div>
    <div class="panel-body">
<pre>
    &lt;div class="panel-heading"&gt;Widget&lt;/div&gt;
    &lt;div class="panel-body"&gt;
    &lt;?php 
	echo "My first nettemp widget";
    ?&gt;
    &lt;/div&gt;
</pre>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Widget 1</div>
  <div class="panel-body">

  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="text1"><?php echo htmlspecialchars($text1) ?></textarea><br />
    </div>
   <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Widget 2</div>
  <div class="panel-body">

  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="text2"><?php echo htmlspecialchars($text2) ?></textarea><br />
    </div>
   <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Widget 3</div>
  <div class="panel-body">

  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="text3"><?php echo htmlspecialchars($text3) ?></textarea><br />
    </div>
   <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
</div>
