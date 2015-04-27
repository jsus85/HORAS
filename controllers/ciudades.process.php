<?php

function deleteCiudad($form_data)
{


	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	foreach ($form_data['idCiudad'] as $key => $value) {


		$model->eliminarRegistro("ciudades" , " id = '".($value)."' ");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("ciudades",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");



	}

	$respuesta->alert('Registro Eliminado...');
	return $respuesta;

}// END FUNCTION 



function nuevoCiudad($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";
	if(strlen($form_data['nombres'])<=5){

		$MsgError  = " * Error en Nombres , ingresar un valor.";

		$respuesta->assign("nombres","focus()","");

		$bError = true;

	}



	if($bError == true){

		$respuesta->alert($MsgError);


	}else{

		$campos	 = array("nombres","fecha_registro");
		$valores = array($form_data['nombres'],date('Y-m-d'));
		$model->insertarRegistro("ciudades",$campos,$valores);
		$id_ciudad = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("medios",$id_ciudad,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');
		$respuesta->Script("window.location= 'ciudades.php'");

	}



	return $respuesta;

}





function editarCiudad($form_data){

	

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
		$model->actualizarRegistro("ciudades" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("ciudades",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'ciudades.php'");

	}



		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();

$xajax->configure('javascript URI','../');

$xajax->registerFunction("deleteCiudad");

$xajax->registerFunction("nuevoCiudad");

$xajax->registerFunction("editarCiudad");

$xajax->processRequest();

?>