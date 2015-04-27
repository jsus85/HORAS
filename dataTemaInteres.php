<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();
$TemaInteres  = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");
?>
<br />
    <select id="TemaEditar<?php echo $_POST['indice'];?>[]"  name="TemaEditar<?php echo $_POST['indice'];?>[]" class="form-control">
    <option value="0">[Todos]</option>
    <?php  for($z=0;$z<count($TemaInteres);$z++){?>
    <option <?php if($actividad_detalle[$w]['tema_interes_id']==$TemaInteres[$z]["id"]){?> selected <?php }?> value="<?php echo $TemaInteres[$z]["id"];?>"><?php echo utf8_encode($TemaInteres[$z]["nombres"]);?></option>    

    <?php 
    $TemaInteres2 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$z]["id"]."' order by nombres asc");

    for($y=0;$y<count($TemaInteres2);$y++){
    ?>
    <option <?php if($actividad_detalle[$w]['tema_interes_id']==$TemaInteres2[$y]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres2[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres2[$y]["nombres"]);?></option> 

    <?php }// For 2?>

    <?php }// End For 1?>
    </select>