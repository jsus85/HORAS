<?php
function deleteDifusion($form_data)
{


	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	foreach ($form_data['idTemaInteres'] as $key => $value) {

		$model->eliminarRegistro("difusion" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("difusion",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

	}

	$respuesta->alert('Registro Eliminado...');

	return $respuesta;

	

}// END FUNCTION 

   



function nuevoDifusion($form_data){



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


		$campos	 = array("nombres" ,"categoria_id", "fecha_registro");
		$valores = array($form_data['nombres'],$form_data['tema_interes'],date('Y-m-d'));
		$model->insertarRegistro("difusion",$campos,$valores);
		$id_tema = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("difusion",$id_tema,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');
		$respuesta->Script("window.location= 'difusion.php'");

	}



	return $respuesta;

}





function editarDifusion($form_data){

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

		$campos	 = array("nombres","categoria_id");
		$valores = array($form_data['nombres'],$form_data['tema_interes']);
		$model->actualizarRegistro("difusion" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("difusion",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'difusion.php'");

	}



	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteDifusion");
$xajax->registerFunction("nuevoDifusion");
$xajax->registerFunction("editarDifusion");

$xajax->processRequest();

?>