<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();

	$campoSuplemento = "";
	if($_POST['suplemento']!=0){
		$campoSuplemento = " and suplemento = '".$_POST['suplemento']."' ";
	}
		
$Secciones   = $model->listarTablaGeneral("id,nombres","secciones"," where medios_id = '".$_POST['medio']."' ".$campoSuplemento."  order by nombres ");

?>
<select id="seccionEditar<?php echo $_POST['indice'];?>[]" name="seccionEditar<?php echo $_POST['indice'];?>[]" class="form-control">
	<option value="0">Seleccionar Seccion/Progr.</option>	
<?php
  		for($i=0;$i<count($Secciones);$i++){
?>
		<option <?php if($_POST['select']==$Secciones[$i]["id"]){?>selected<?php }?>  value="<?php echo $Secciones[$i]["id"];?>">
		<?php echo utf8_encode($Secciones[$i]["nombres"]);?>
		</option>    
<?php 
	 }// End if	
?>

</select> 