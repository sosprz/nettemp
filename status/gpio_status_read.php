<tr>
    <td colspan=3>
	<?php
	exec('/usr/local/bin/gpio -g read '.$gpio, $state);
	    if ($state[0] == '1'){ 
	    echo '<span class="label label-success">';
	    } else {
	    echo '<span class="label label-danger">';
	    }
	    ?>
	    <img src="media/ico/SMD-64-pin-icon_24.png" alt=""/>
	    <?php echo $a['name'];
	    unset($state);
	    ?>
	</span>
    </td>
</tr>