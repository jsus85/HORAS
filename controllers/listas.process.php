<?php
function deleteListas($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


//	foreach ($form_data['idLista'] as $key => $value) {

//		$model->eliminarRegistro("listas" , " id = '".($value)."' ");
//		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
/*		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("listas",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);*/
		// end(array) History query
//	}

	$model->eliminarRegistro("listas" , " id in ( ".$form_data." ) ");

	$respuesta->alert('Registro Eliminado...');
			$respuesta->Script("window.location= 'listas.php'");
	return $respuesta;

}// END FUNCTION 




function editarLista($form_data){

	
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

		$agrupar_periodistas = implode(",", $form_data['periodistas']);

		$campos	 = array("nombres","periodistas","cliente_id");
		$valores = array($form_data['nombres'],$agrupar_periodistas,$form_data['clientes']);
		
		$model->actualizarRegistro("listas" , $campos , $valores , " id = '".($form_data['HDDID'])."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("listas",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		//$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query
		
		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'listas.php'");

	}	

		

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteListas");
$xajax->registerFunction("editarLista");
$xajax->processRequest();
?>