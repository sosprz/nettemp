<div class="panel panel-default">
<div class="panel-heading">DB edit</div>

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
<th>Delete older than:</th>
<th>Edit</th>
</tr>
</thead>


<?php 
    foreach ($row as $a) { 	
?>
<tr>
    <td class="col-md-1"><?php echo $a['name']?></td>
    <td class="col-md-1"><?php echo $a['rom']?></td>
	
	<td>
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success">1 month<span class="glyphicon glyphicon-trash"></span></button>
    <input type="hidden" name="delolder" value="month" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success">3 months<span class="glyphicon glyphicon-trash"></span></button>
    <input type="hidden" name="delolder" value="threemont" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success">6 months<span class="glyphicon glyphicon-trash"></span></button>
    <input type="hidden" name="delolder" value="sixmonth" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success">Year<span class="glyphicon glyphicon-trash"></span></button>
    <input type="hidden" name="delolder" value="year" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success">All<span class="glyphicon glyphicon-trash"></span></button>
    <input type="hidden" name="delolder" value="all" />
    </form>
    </td>
	
	
    <td class="col-md-5">
    <form action="?id=tools&type=dbedit2&file=<?php echo $a['rom']?>" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
    <input type="hidden" name="csv" value="get" />
    </form>
	</td>
</tr>
<?php 
    }
?>
</table>
</div>