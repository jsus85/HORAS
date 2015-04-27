<?php

function deleteSecciones($form_data){


	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	foreach ($form_data['idSecciones'] as $key => $value) {

		$model->eliminarRegistro("secciones" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");

		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("secciones",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query
	}

	$respuesta->alert('Registro Eliminado...');

	return $respuesta;

	

}// END FUNCTION 

   



function nuevoSecciones($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";
	if(strlen($form_data['nombres'])<=3){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}



	if($bError == true){

		$respuesta->alert($MsgError);

	}else{

		$campos	 = array("nombres" ,"suplemento", "medios_id","fecha_registro");
		$valores = array($form_data['nombres'],$form_data['suplemento'],$form_data['medios_1'],date('Y-m-d'));
		$model->insertarRegistro("secciones",$campos,$valores);
		$id_secciones = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("secciones",$id_secciones,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query		

		$respuesta->alert('Registro Guardado...');
		$respuesta->Script("window.location= 'secciones.php'");
	}



	return $respuesta;

}



function editarSecciones($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$bError = false;	


	$MsgError = "";
	 if(strlen($form_data['nombres'])<=3){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}



	if($bError == true){
		$respuesta->alert($MsgError);

	}else{
	
		$campos	 = array("nombres","suplemento","medios_id");
		$valores = array($form_data['nombres'],$form_data['suplemento'],$form_data['medios_1']);
		$model->actualizarRegistro("secciones" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("secciones",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'secciones.php'");

	}		

	return $respuesta;
}


// ------------------- permite mostrar los medios desdel secciones.php   ------------
function mostrarMedioslist($tipoMedio,$id_medio,$indice)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$HTML = '';
	$Medios = $model->listarTablaGeneral("id,nombres","medios"," where tipo_medios_id = '".$tipoMedio."' and estado = 1 order by nombres asc ");
	
	$HTML .= '<select id="medios_'.$indice.'"  name="medios_'.$indice.'" onchange="MostrarSeccion(this.value);"><option value="0">[Todos]</option>';
	for($i=0;$i<count($Medios);$i++){
		$select = "";
		if($id_medio == $Medios[$i]["id"]){
			$select = "selected";
		}

			$HTML .= '<option '.$select.'  value='.$Medios[$i]['id'].'>'.utf8_encode($Medios[$i]["nombres"]).'</option>';    
		}
	$HTML .= '</select>';

	

	$respuesta->assign("HTMLMEDIOS_".$indice,"innerHTML",$HTML);

	return $respuesta;
	
}// END FUNCTION 




require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteSecciones");
$xajax->registerFunction("nuevoSecciones");
$xajax->registerFunction("editarSecciones");
$xajax->registerFunction("mostrarMedioslist");
$xajax->processRequest();

?>