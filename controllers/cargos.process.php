<?php
function deleteCargos($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


	foreach ($form_data['idCargos'] as $key => $value) {

		$model->eliminarRegistro("cargos" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("cargos",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

	}

	$respuesta->alert('Registro Eliminado...');
	return $respuesta;

}// END FUNCTION 

   



function nuevoCargos($form_data){



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



		$campos	 = array("nombres","fecha_registro");
		$valores = array($form_data['nombres'],date('Y-m-d'));
		$model->insertarRegistro("cargos",$campos,$valores);


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("cargos",$id_medios,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');

		$respuesta->Script("window.location= 'cargos.php'");

	}



	return $respuesta;

}





function editarCargos($form_data){

	

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
		$model->actualizarRegistro("cargos" , $campos , $valores , " id = '".mysql_real_escape_string($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("cargos",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query
		
		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'cargos.php'");

	}	

		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteCargos");
$xajax->registerFunction("nuevoCargos");
$xajax->registerFunction("editarCargos");
$xajax->processRequest();

?>