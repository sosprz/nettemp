
<div class="panel panel-default">
<div class="panel-heading">DB check</div>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
?>
<table class="table table-striped table-hover small">
<thead>
<tr>
<th>Name</th>
<th>Rom</th>
<th>Action</th>
<th>Result</th>
</tr>
</thead>


<?php 
    foreach ($row as $a) { 	
?>
<tr>
    <td class="col-md-1"><?php echo $a['name']?></td>
    <td class="col-md-1"><?php echo $a['rom']?></td>
    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="file" value="<?php echo $a['rom']?>" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon"></span> Check</button>
		<input type="hidden" name="action" value="check" />
    </form>
    </td>
    <td class="col-md-5">
		<?php
		$file=$a['rom'];
		$fullfile='db/'.$file.'.sql';
		if (file_exists($fullfile) && ( 0 != filesize($fullfile))) {
			echo "file exist, ";
			
			$db = new PDO("sqlite:$fullfile");
			if ( $sth = $db->query("PRAGMA integrity_check") ){
				$row = $sth->fetchAll();
				foreach($row as $r) {
					echo "DB ".$r[0]."  ".$r[1];
				}
			}
		}
		else {
			echo "file not exist";
		}
				
		
		?>
    </td>
</tr>
<?php 
    }
?>
</table>
</div>

