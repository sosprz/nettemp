<style type="text/css">

* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}


/* ---- grid ---- */

.grid {
	<?php if($id=='screen') { ?>
   	width: 800px;
   <?php } ?>
}

/* clearfix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
}

</style>

<div class="grid">
<div class="grid-sizer"></div>
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">UPS NT Status</div>
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td >DC Input</td>
												<td></td>
												<td></td>
												</tr>

										</tbody>
								</table>

				</div>
		</div>
		
		
		
		
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">UPS NT Status</div>
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td >DC Input</td>
												<td></td>
												<td></td>
												</tr>

										</tbody>
								</table>

				</div>
		</div>


</div>