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



<?php
foreach (range(1, 10) as $v) {

$file = "tmp/ownwidget".$v.".php";
$text = file_get_contents($file);

if (isset($_POST['text'.$v]))
{
    file_put_contents($file, $_POST['text'.$v]);

    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

?>

<div class="panel panel-default">
  <div class="panel-heading"><?php echo "Widget ".$v;?></div>
  <div class="panel-body">

  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="<?php echo text.$v?>"><?php echo htmlspecialchars($text) ?></textarea><br />
    </div>
   <button class="btn btn-xs btn-success" type="submit">Save</button>
  </form>
</div>
</div>

<?php
unset($v);
    }
?>