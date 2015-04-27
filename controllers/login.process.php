<?php
function clsLogin($form_data)

{



	$respuesta = new xajaxResponse();

	$bError = false;	

	$MsgError = "";

	$lista = NULL;



	if(strlen($form_data['usuario'])<=2){

		$MsgError  = " * Error en Usuario , ingresar un valor.";

		$respuesta->assign("usuario","focus()","");

		$bError = true;

	}else if(strlen($form_data['password'])<=2){

		$MsgError  = " * Error en Password, ¡ Minimo 6 caracteres!.";

		$respuesta->assign("password","focus()","");

		$bError = true;

	}else if(!validar_passwd($form_data['password'])){

		$MsgError  = " * Error en Contraseña.";

		$respuesta->assign("password","focus()","");

		$bError = true;

	}



	if($bError == true){



		$respuesta->alert($MsgError);

	

	}else{



	$model    = new funcionesModel();


	
	$verificacion = $model->verificarInicioDeSession($form_data['usuario'],$form_data['password']);	



		if($verificacion==null)

		{

				$respuesta->alert(" * Error en Usuario y Password.");

				$respuesta->assign("password","focus()","");

		}

		else

		{

			$lista 	= $model->datosUsuarioSession($form_data['usuario'],$form_data['password']);



			$_SESSION['sID'] 			= $lista[0]["id"];
			$_SESSION['sEMAIl'] 	    = $lista[0]["email"];
			$_SESSION['sNOMBRES'] 	    = $lista[0]["nombres"];
			$_SESSION['sTipoUsuario']   = $lista[0]["tipo_usuario"];
			$_SESSION['sAtributos']     = $lista[0]["atributos"];
			$_SESSION['sPermisos']      = $lista[0]["permisos"];
			$_SESSION['sClientes']      = $lista[0]["clientes"];			

			// insert query
			$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
			$valores = array("usuarios",$lista[0]["id"],"login",date('Y-m-d H:i:s'),$lista[0]["id"],$_SERVER['REMOTE_ADDR']);
			$model->insertarRegistro("historial_querys",$campos,$valores);
			// end(array) insert query

			$respuesta->Script("window.parent.location='panel.php'");
		}

	}// End Else
		

	return $respuesta;

}// END FUNCTION 

   

require ('xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();

$xajax->configure('javascript URI','../');

$xajax->registerFunction("clsLogin");

$xajax->processRequest();

?>