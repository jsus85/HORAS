<?php

function deleteUsuarios($form_data)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


	foreach ($form_data['idUsuario'] as $key => $value) {


		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("usuarios",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query

		$model->eliminarRegistro("usuarios" , " id = '".($value)."' ");

		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
	}

	$respuesta->alert('Registro Eliminado...');

	return $respuesta;

	

}// END FUNCTION 

 
//

function nuevoUsuario($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";


	if($form_data['tipo_usuario']=="--"){

		$MsgError  = " * Error Tipo Usuario , seleccione un valor.";
		$respuesta->assign("tipo_usuario","focus()","");
		$bError = true;

	}else if(strlen($form_data['nombres'])<=3){

		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;

	}else if(strlen($form_data['email'])<=3){

		$MsgError  = " * Error en Email , ingresar un valor.";
		$respuesta->assign("email","focus()","");

		$bError = true;

	}else if(strlen($form_data['usuario'])<=3){

		$MsgError  = " * Error en Usuario , ingresar un valor.";
		$respuesta->assign("usuario","focus()","");

		$bError = true;

	}else if(strlen($form_data['password'])<=3){

		$MsgError  = " * Error en Password , ingresar un valor.";
		$respuesta->assign("password","focus()","");
		$bError = true;

	}



	if($bError == true){

	$respuesta->alert($MsgError);

	}else{

	
	    $respuesta->assign("form_nuevo","action","data.usuarios.php");
		$respuesta->assign("form_nuevo","submit()","");
		return $respuesta;
	/*	
	    $menus = NULL;	
		for($i=1;$i<=9;$i++){
			if(isset($form_data['menu_'.$i])){ 
				$menus	 .=  ",".$form_data['menu_'.$i];
			}
		}

		$permisos = NULL;	
		for($i=1;$i<=2;$i++){
			if(isset($form_data['atributos_'.$i])){ 
				$permisos	 .=  ",".$form_data['atributos_'.$i];
			}
		}


		$campos	 	= array("nombres","email","tipo_usuario","clave","fecha_registro","usuario","atributos","permisos");
		$valores 	= array($form_data['nombres'],$form_data['email'],$form_data['tipo_usuario'],$form_data['password'],date('Y-m-d'),$form_data['usuario'],substr($menus,1) , substr($permisos,1) );
		$model->insertarRegistro("usuarios",$campos,$valores);
		$id_usuario = mysql_insert_id();
		
		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("usuarios",$id_usuario,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Guardado...');
		$respuesta->Script("window.location= 'usuarios.php'");
		*/
	}



	return $respuesta;

}





function editarUsuario($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$bError = false;	

	$MsgError = "";
	if($form_data['tipo_usuario']=="--"){

		$MsgError  = " * Error Tipo Usuario , seleccione un valor.";
		$respuesta->assign("tipo_usuario","focus()","");
		$bError = true;

	}else if(strlen($form_data['nombres'])<=3){

		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;

	}else if(strlen($form_data['email'])<=3){

		$MsgError  = " * Error en Email , ingresar un valor.";
		$respuesta->assign("email","focus()","");
		$bError = true;

	}else if(strlen($form_data['usuario'])<=3){

		$MsgError  = " * Error en Usuario , ingresar un valor.";
		$respuesta->assign("usuario","focus()","");
		$bError = true;

	}else if(strlen($form_data['password'])<=3){

		$MsgError  = " * Error en Password , ingresar un valor.";
		$respuesta->assign("password","focus()","");
		$bError = true;
	}



	if($bError == true){

		$respuesta->alert($MsgError);

	}else{


		$respuesta->assign("form_editar","action","data.usuarios.php");
		$respuesta->assign("form_editar","submit()","");

		return $respuesta;

		/*$menus = NULL;	
		for($i=1;$i<=9;$i++){
			if(isset($form_data['menu_'.$i])){ 
				$menus	 .=  ",".$form_data['menu_'.$i];
			}
		}

		$permisos = NULL;	
		for($i=1;$i<=2;$i++){
			if(isset($form_data['atributos_'.$i])){ 
				$permisos	 .=  ",".$form_data['atributos_'.$i];
			}
		}

		$campos	 = array("nombres","email","tipo_usuario","clave","fecha_registro","usuario","atributos","permisos");
		$valores = array($form_data['nombres'],$form_data['email'],$form_data['tipo_usuario'],$form_data['password'],date('Y-m-d'),$form_data['usuario'],substr($menus,1) ,substr($permisos,1) );
		$model->actualizarRegistro("usuarios" , $campos , $valores , " id = '".$form_data['HDDID']."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("usuarios",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		$respuesta->alert('Registro Actualizado...');
		$respuesta->Script("window.location= 'usuarios.php'");
		*/
	}	

	return $respuesta;

}





require ('xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteUsuarios");
$xajax->registerFunction("nuevoUsuario");
$xajax->registerFunction("editarUsuario");
$xajax->processRequest();

?>