<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();
$Clientes     = $model->listarTablaGeneral(" id,nombres ","clientes"," order by nombres asc ");
?>
<select id="clientesEditar<?php echo $_POST['indice'];?>[]" name="clientesEditar<?php echo $_POST['indice'];?>[]" class="form-control" >
<option value="0">[Seleccionar]</option>
<?php for($x=0;$x<count($Clientes);$x++){?>
<option <?php if($actividad_detalle[$w]['cliente_id']==$Clientes[$x]["id"]){?> selected <?php }?> value="<?php echo $Clientes[$x]["id"];?>"><?php echo utf8_encode($Clientes[$x]["nombres"]);?></option>    
<?php }?></select>