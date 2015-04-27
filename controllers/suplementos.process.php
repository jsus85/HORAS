<?php
function deleteSuplementos($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


	foreach ($form_data['idCargos'] as $key => $value) {

		$model->eliminarRegistro("suplementos" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("suplementos",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

	}

	$respuesta->alert('Registro Eliminado...');
	return $respuesta;

}// END FUNCTION 

   



function nuevoSuplementos($form_data){

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



		$campos	 = array("nombres","fecha");
		$valores = array($form_data['nombres'],date('Y-m-d'));
		$model->insertarRegistro("suplementos",$campos,$valores);


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("suplementos",$id_medios,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');

		$respuesta->Script("window.location= 'suplementos.php'");

	}



	return $respuesta;

}





function editarSuplementos($form_data){

	

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

	
		$campos	 = array("nombres");
		$valores = array($form_data['nombres']);
		$model->actualizarRegistro("suplementos" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("suplementos",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query
		
		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'suplementos.php'");

	}	

		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteSuplementos");
$xajax->registerFunction("nuevoSuplementos");
$xajax->registerFunction("editarSuplementos");
$xajax->processRequest();

?>