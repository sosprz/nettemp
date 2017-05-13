<?php

if(!isset($_SESSION['user'])){ header("Location: denied"); }
if(!isset($NT_SETTINGS['dbUpdateEditPreparePage'])){ header("Location: denied"); }

if(isset($_POST['sql'])){
    $SQL_Array = preg_split('/;\r?\n?|\r?\n/s', $_POST['sql']."\n", -1, PREG_SPLIT_NO_EMPTY);
//Put warning if bad words happens
    if( preg_match('/commit|begin|rollback/i',$_POST['sql']) ){ $SQL_Warn = 1; }
}

?>

<div class="panel panel-default">
<div class="panel-heading">Nettemp DB Update Prepare</div>
<div class="panel-body">

<form action="" method="post">
  <div class="form-group">
    <label for="sql">SQL:</label>
    <textarea class="form-control" rows="5" id="sql" name="sql" ><?php echo isset($_POST['sql']) ? $_POST['sql'] : '' ?></textarea>
  </div>
  <button type="submit" name="submit" value="sql" class="btn btn-success">Make Update!</button>

</div>

<?php
  if(isset($SQL_Array)){
?>
    <div class="panel-body">
    <div class="panel panel-<?php echo isset($SQL_Warn) ? 'danger' : 'success'; ?>">
      <div class="panel-heading"><?php echo isset($SQL_Warn) ? 'SQL contains errors or bad words - you should not try it!' : 'SQL should be ok - you can try it..'; ?></div>
      <div class="panel-body">
<?php
  echo '<pre>';
  if(isset($SQL_Array)){
    $db_date=date('Y-m-d H:i:s');
    echo '$updates[\''.$db_date.'\'][]="';
    echo implode("\"\n".'$updates[\''.$db_date.'\'][]="',$SQL_Array);
    echo '"';
  }
  echo '</pre>';
?>
    </div>

      <div class="panel-footer">
        <button type="submit" name="submit" value="try" class="btn btn-<?php echo isset($SQL_Warn) ? 'danger' : 'warning'; ?>">Try Update!</button>
      </div>

    </div>
    </div>
<?php
  }
?>

</form>

<?php
//Try the update..
  if(isset($_POST['submit']) && $_POST['submit'] == 'try'){
?>

    <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">SQL test effect:</div>
      <div class="panel-body">
        <pre>
<?php
//SQL Test..

try {
    $dbupdate = new PDO("sqlite:$root/dbf/nettemp.db");
    $dbupdate->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $dbupdate->beginTransaction();
    foreach ( $SQL_Array as $sql ){
//        $dbupdate->exec($sql);
        if ( preg_match('/commit|rollback|begin/i', $sql) ){
            echo "STATEMENT NOT EXECUTED: ".$sql."\n";
        }else{
            $dbcount = $dbupdate->exec($sql);
            echo $dbcount . " rows affected by: ". $sql . "\n";
        }
    }
    echo "Update test was successfull\n";
    $error = 'no';
    $dbupdate->rollBack();
} catch (Exception $e) {
    $dbupdate->rollBack();
    echo "Update test was unsuccessfull at:\n\t$sql\n\n";
    echo "Error message:\n$e\n";
}
unset($dbupdate,$sql);
//SQL Test..
?>
        </pre>
      </div>
      <div class="panel-footer"><?php echo (isset($error) && $error=='no') ? 'You can add this update..' : 'There was error when testing the update..'; ?></div>
    </div>
    </div>

<?php
  }
//end trying update..
?>

</div>
</div>

<script type="text/javascript">
$("button").click(function() {
    var $btn = $(this);
    $btn.button('loading');
function submitform()
{
    $btn.button('reset');
}
});
</script>
