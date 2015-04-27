<?php
function deleteMedios($form_data)
{


	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	foreach ($form_data['idMedio'] as $key => $value) {

		$model->eliminarRegistro("medios" , " id = '".($value)."' ");

		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("medios",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query


		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");

	}

	$respuesta->alert('Registro Eliminado...');

	return $respuesta;

}// END FUNCTION 

function nuevoMedios($form_data){

 
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


	$bError = false;	
	$MsgError = "";

	if(strlen($form_data['tipo_medio'])==0){

		$MsgError  = " * Error en Tipo Medio , seleccione un valor.";

		$respuesta->assign("tipo","focus()","");

		$bError = true;

	}else if(strlen($form_data['nombres'])<=3){

		$MsgError  = " * Error en Nombres , ingresar un valor.";

		$respuesta->assign("nombres","focus()","");

		$bError = true;

	}



	if($bError == true){



		$respuesta->alert($MsgError);

	

	}else{



		$campos	 = array("nombres","direccion","cobertura","periocidad","lectoria","tiraje","audiencia","resumen","fecha_registro","tipo_medios_id");
		$valores = array($form_data['nombres'],$form_data['direccion'],$form_data['cobertura'],$form_data['periocidad'],$form_data['lectoria'],$form_data['tiraje'],$form_data['audiencia'],$form_data['resumen'],date('Y-m-d'),$form_data['tipo_medio']);
		$model->insertarRegistro("medios",$campos,$valores);
		$id_medios = mysql_insert_id();
		
		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("medios",$id_medios,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');
		$respuesta->Script("window.location= 'medios.php'");

	}



	return $respuesta;

}





function editarMedios($form_data){

	

	$respuesta = new xajaxResponse();

	$model     = new funcionesModel();

	$bError = false;	

	

	$MsgError = "";

	if(strlen($form_data['tipo_medio'])==0){
		$MsgError  = " * Error en Tipo Medio , seleccione un valor.";
		$respuesta->assign("tipo","focus()","");
		$bError = true;
	}else if(strlen($form_data['nombres'])<=3){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}



	if($bError == true){
		$respuesta->alert($MsgError);

	}else{


		$campos	 = array("nombres","direccion","cobertura","periocidad","lectoria","tiraje","audiencia","resumen","fecha_registro","tipo_medios_id");
		$valores = array($form_data['nombres'],$form_data['direccion'],$form_data['cobertura'],$form_data['periocidad'],$form_data['lectoria'],$form_data['tiraje'],$form_data['audiencia'],$form_data['resumen'],date('Y-m-d'),$form_data['tipo_medio']);
		$model->actualizarRegistro("medios" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("medios",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'medios.php'");

	}
		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();

$xajax->configure('javascript URI','../');

$xajax->registerFunction("deleteMedios");

$xajax->registerFunction("nuevoMedios");

$xajax->registerFunction("editarMedios");

$xajax->processRequest();

?>