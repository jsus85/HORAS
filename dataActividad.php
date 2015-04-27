<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();
$Secciones      = $model->listarTablaGeneral("id,nombres","secciones","");
$tipo_medios = $model->listarTablaGeneral("*","tipo_medios","");
$Cargos       = $model->listarTablaGeneral("id,nombres","cargos"," order by nombres asc");
$Clientes     = $model->listarTablaGeneral(" id,nombres ","clientes"," order by nombres asc ");
$TemaInteres  = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");

		$campos	 = array("periodista_id","fecha_registro","estado");
		$valores = array($_POST['periodista'],date("Y-m-d"),"1");
		$model->insertarRegistro("actividad_periodista",$campos,$valores);
		$id_actividad = mysql_insert_id();


?>

 <div id="HTML_ActividadNUEVO<?php echo $_POST['indice'];?>"> 

	<p><b>NUEVA ACTIVIDAD #<?php echo $_POST['indice'];?></b></p>
	<div style="text-align: right;padding: 10px;">
	<button onclick="xajax_EliminarActividad('<?php echo $id_actividad;?>','<?php echo $_POST['indice'];?>');" title="Eliminar Registro" type="button" style="background:red" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></button>
	</div>                              
	<div class="col-md-4">
    <b>Tipo Medio:</b> <br />
    
    <select id="tipo_medio_<?php echo $i;?>" onchange="xajax_mostrarMediosNuevo(this.value,'',<?php echo $_POST['indice'];?>);" name="tipo_medio_<?php echo $i;?>" class="form-control">
        <option value="0">[Todos]</option>
        <?php for($TPi=0;$TPi<count($tipo_medios);$TPi++){?>
        <option <?php if($lista[$i]["tipo_medio_id"]==$tipo_medios[$TPi]["id"]){?>selected<?php }?> value="<?php echo $tipo_medios[$TPi]["id"];?>"><?php echo utf8_encode($tipo_medios[$TPi]["nombres"]);?></option>    
        <?php }?>
    </select>
    <a href="#"><img src="assets/img/save.png" /></a>     
 </div> 

	<div class="col-md-4">
		Medio: <br />
		<span id="NuevoHTMLMEDIOS_<?php echo $_POST['indice'];?>">
		<select id="NuevoMedios_<?php echo $_POST['indice'];?>"  name="NuevoMedios_<?php echo $_POST['indice'];?>" class="form-control">
		<option value="0">[Ninguno]</option>
		</select>
		<a href="#"><img src="assets/img/save.png" /></a>
		</span>                            
	</div>

	<div class="col-md-4">
		Cargo: <br />
		<select id="cargos_<?php echo $_POST['indice'];?>" name="cargos_<?php echo $_POST['indice'];?>" class="form-control">
		<option value="0">[Todos]</option>
		<?php for($Ci=0;$Ci<count($Cargos);$Ci++){?>
		<option value="<?php echo $Cargos[$Ci]["id"];?>"><?php echo utf8_encode($Cargos[$Ci]["nombres"]);?></option>    
		<?php }?>
		</select>
		<a href="#"><img src="assets/img/save.png" /></a>
	</div>

	<div class="col-md-4">
		F. Ingreso: <br />
		<input type="text" name="fecha_inicio_<?php echo $_POST['indice'];?>" class="form-control fecha_inicio" value="" id="fecha_inicio_<?php echo $_POST['indice'];?>" />
		<a href="#"><img src="assets/img/save.png" /></a>
	</div>


	<div class="col-md-4">
		F. Salida: <br />
		<input type="text" name="fecha_final_<?php echo $_POST['indice'];?>" class="form-control fecha_final" id="fecha_final_<?php echo $_POST['indice'];?>" value="" />
		<a href="#"><img src="assets/img/save.png" /></a>
	</div>

<!--
	<div class="col-md-4">
		Anexo: <br />
		<input type="text" id="anexo_<?php echo $_POST['indice'];?>"   name="anexo_<?php echo $_POST['indice'];?>" value = "" class="form-control" />
		<a href="#"><img src="assets/img/save.png" /></a>                                
	</div>

	<div class="col-md-4">
		Telefonos: <br />                                 
		<input type="text" name="telefonos_<?php echo $_POST['indice'];?>" class="form-control" value="" id="telefonos_<?php echo $_POST['indice'];?>" />
		<a href="#"><img src="assets/img/save.png" /></a>
	</div>

-->

	<div class="col-md-4">
	T. Interes: <br /> 
		<select id="tema_interes_<?php echo $_POST['indice'];;?>"  name="tema_interes_<?php echo $_POST['indice'];;?>" class="form-control">
		<option value="0">[Todos]</option>
		<?php  for($z=0;$z<count($TemaInteres);$z++){?>
		<option  value="<?php echo $TemaInteres[$z]["id"];?>"><?php echo utf8_encode($TemaInteres[$z]["nombres"]);?></option>    

		<?php 
		$TemaInteres2 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$z]["id"]."' order by nombres asc");

		for($y=0;$y<count($TemaInteres2);$y++){
		?>
		<option  value="<?php echo $TemaInteres2[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres2[$y]["nombres"]);?></option> 

		<?php }// For 2?>

		<?php }// End For 1?>
		</select>    
	</div> 

	 <div style="clear: both;text-align: left;display: block;padding-top: 12px;margin-left: 20px;">
		<a style="cursor:pointer;text-decoration:underline" onclick="AgregasSeccionActividad('<?php echo $_POST['indice'];?>');" ><img src="assets/img/new.png" />
		<b>AGREGAR PROGRAMA / SECCIÓN</b>
		</a>
	 </div>
     <div id="HTMLSeccionNuevo_<?php echo $_POST['indice'];?>"></div>
	
     <!-- Cliente-->
	 <div style="clear: both;text-align: left;display: block;padding-top: 12px;margin-left: 20px;">
		<a style="cursor:pointer;text-decoration:underline" onclick="AgregasClienteActividad('<?php echo $_POST['indice'];?>');" ><img src="assets/img/new.png" />
		<b>AGREGAR CLIENTE</b>
		</a>
	 </div>
     <div id="HTMLClienteNuevo_<?php echo $_POST['indice'];?>"></div>

	 <div style="clear: both;text-align: left;display: block;padding-top: 12px;margin-left: 20px;">
		<a style="cursor:pointer;text-decoration:underline" onclick="AgregasTemaActividad('<?php echo $_POST['indice'];?>');" ><img src="assets/img/new.png" />
		<b>AGREGAR TEMA INTERES</b>
		</a>
	 </div>
     <div id="HTMLTemaNuevo_<?php echo $_POST['indice'];?>"></div>

	 <hr clear="both" />

</div>