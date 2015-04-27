<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td width="50%" align="left">Total de Registros :	[ <?php echo $total ?> ] - Total de P&aacute;ginas [ <?php echo $numPags ?> ]
	</td>
	<td width="40%" align='right' height='25' >
		<?php
	
		 if ($total > VAR_NROITEMS)
		 { 

		 	?>
	      P&aacute;gina.
	      <select name="pg" onChange="buscar();">
	    <?php
			  	for($pg=1; $pg<=$numPags; $pg++)
				{
					if($pg < VAR_NROITEMS) $pg = "0".$pg;
					echo "<option  value='$pg'"; 
					if($pg==$pag) echo " selected";
					echo">$pg</option>";
				}
			    ?>
	      </select>
		<?php } ?>
	</td>
	</tr>
</table>
