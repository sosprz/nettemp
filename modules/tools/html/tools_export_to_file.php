<!-- Include Required Prerequisites -->

<script type="text/javascript" src="html/momentjs/moment.min.js"></script>

 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="html/datepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="html/datepicker/daterangepicker.css" />

<div class="panel panel-default">
<div class="panel-heading">Export db to file</div>

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
<th>Custom date</th>
<th>All data</th>
</tr>
</thead>


<?php 
    foreach ($row as $a) { 	
?>
<tr>
    <td class="col-md-1"><?php echo $a['name']?></td>
    <td class="col-md-1"><?php echo $a['rom']?></td>
    <td class="col-md-1">
    <form action="csv" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <input type="text" name="daterange" value=""  size="30" />
    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-save"></span> CSV</button>
    <input type="hidden" name="action" value="getc" />
    </form>
    </td>
    <td class="col-md-5">
    	<form action="csv" method="post" style="display:inline!important;">
    		<input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-save"></span> CSV</button>
    		<input type="hidden" name="action" value="get" />
    	</form>
    </td>
</tr>
<?php 
    }
?>
</table>
</div>
<script type="text/javascript">
$(function() {
	 var start = moment().subtract(29, 'days');
    var end = moment();
    $('input[name="daterange"]').daterangepicker({
         "ranges": {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
        locale: {
            format: 'YYYY-MM-DD H:mm'
        }
    });
});
</script>