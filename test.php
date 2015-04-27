<?php 
	include("model/functions.php");
	$model            = new funcionesModel();
	$seguimiento      = $model->listarTablaGeneral("*","seguimiento_detalles","where periodista_id in (1456,1457,1458 , 1452,1454)");
 
    for($x=0;$x<count($seguimiento);$x++){

   		echo $seguimiento[$x]["periodista_id"]." ".$seguimiento[$x]["confirmo"]."<br />";

   			if($seguimiento[$x]["confirmo"]=='S'){
   				$confirmo['siconfirmo'][$x] += 1;
   			}// 



	}// End For

	echo "<pre>";
	print_r($confirmo['siconfirmo']);

	echo "</pre>"
?>