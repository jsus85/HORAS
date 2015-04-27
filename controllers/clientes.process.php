<?php
function deleteClientes($form_data)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	

	foreach ($form_data['idCliente'] as $key => $value) {

		$model->eliminarRegistro("clientes" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");

		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("clientes",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

	}

	$respuesta->alert('Registro Eliminado...');
	return $respuesta;	

}// END FUNCTION 

   



function nuevoClientes($form_data){



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


		$respuesta->assign("form_nuevo","action","data.clientes.php");
		$respuesta->assign("form_nuevo","submit()","");


	}



	return $respuesta;

}





function editarClientes($form_data){

	

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


		$respuesta->assign("form_editar","action","data.clientes.php");
		$respuesta->assign("form_editar","submit()","");

		/*$campos	 = array("nombres");
		$valores = array($form_data['nombres']);
		$model->actualizarRegistro("clientes" , $campos , $valores , " id = '".mysql_real_escape_string($form_data['HDDID'])."' ");

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("clientes",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'clientes.php'");*/

	}

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();

$xajax->configure('javascript URI','../');

$xajax->registerFunction("deleteClientes");

$xajax->registerFunction("nuevoClientes");

$xajax->registerFunction("editarClientes");

$xajax->processRequest();

?>