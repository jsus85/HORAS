<?php
function deleteSaludos($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


	foreach ($form_data['idSaludo'] as $key => $value) {

		$model->eliminarRegistro("saludos" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("saludos",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

	}

	$respuesta->alert('Registro Eliminado...');
	return $respuesta;

}// END FUNCTION 

   



function nuevoSaludo($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";
	if(strlen($form_data['nombres'])<=2){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}


	if($bError == true){
		$respuesta->alert($MsgError);

	}else{

		$campos	 = array("nombres","nombres_femenino","ninguno","fecha_registro");
		$valores = array($form_data['nombres'],$form_data['nombres_femenino'],$form_data['mascu_femino'],date('Y-m-d'));
		$model->insertarRegistro("saludos",$campos,$valores);
		$id_saludo = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("saludos",$id_saludo,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');

		$respuesta->Script("window.location= 'saludos.php'");

	}

	return $respuesta;
}




function editarSaludo($form_data){

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
	
		$campos	 = array("nombres","nombres_femenino","ninguno");
		$valores = array($form_data['nombres'],$form_data['nombres_femenino'],$form_data['mascu_femino']);
		$model->actualizarRegistro("saludos" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("saludos",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query
		
		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'saludos.php'");

	}	

		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteSaludos");
$xajax->registerFunction("nuevoSaludo");
$xajax->registerFunction("editarSaludo");
$xajax->processRequest();

?>