<?php
function deleteBoletin($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$model->eliminarRegistro("boletin" , " id in (".$form_data.") ");
	/*foreach ($form_data['idLista'] as $key => $value) {

		$model->eliminarRegistro("boletin" , " id = '".($value)."' ");
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("boletin",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query
	}*/

	$respuesta->alert('Registro Eliminado...');
	$respuesta->Script("window.location='boletines.php';");
	return $respuesta;

}// END FUNCTION 


function nuevoBoletin($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	

	$MsgError = "";


	if(strlen($form_data['nombres'])<=2){

		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}else if($form_data['difusion']==0){

		$MsgError  = " * Error en Difusión , selecionar un valor.";
		$respuesta->assign("difusion","focus()","");
		$bError = true;
	}else if($form_data['clientes']==0){

		$MsgError  = " * Error en Clientes , selecionar un valor.";
		$respuesta->assign("clientes","focus()","");
		$bError = true;
	}else if($form_data['Lista']==0){

		$MsgError  = " * Error en Lista , selecionar un valor.";
		$respuesta->assign("Lista","focus()","");
		$bError = true;
	}else if(strlen($form_data['asunto'])<=2){

		$MsgError  = " * Error en Asunto , ingresar un valor.";
		$respuesta->assign("asunto","focus()","");
		$bError = true;
	}else if($form_data['saludo']=='0'){

		$MsgError  = " * Error en Saludo , selecionar un valor.";
		$respuesta->assign("saludo","focus()","");
		$bError = true;
	}



	if($bError == true){
		$respuesta->alert($MsgError);

	}else{

		$respuesta->assign("form_nuevo","action","data.boletines.php");
		$respuesta->assign("form_nuevo","submit()","");

	}// Else	


	return $respuesta;
}

function editarBoletin($form_data){

	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";

	if(strlen($form_data['nombres'])<=2){

		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}else if($form_data['difusion']==0){

		$MsgError  = " * Error en Difusión , selecionar un valor.";
		$respuesta->assign("difusion","focus()","");
		$bError = true;
	}else if($form_data['clientes']==0){

		$MsgError  = " * Error en Clientes , selecionar un valor.";
		$respuesta->assign("clientes","focus()","");
		$bError = true;
	}else if($form_data['Lista']==0){

		$MsgError  = " * Error en Lista , selecionar un valor.";
		$respuesta->assign("Lista","focus()","");
		$bError = true;
	}else if(strlen($form_data['asunto'])<=2){

		$MsgError  = " * Error en Asunto , ingresar un valor.";
		$respuesta->assign("asunto","focus()","");
		$bError = true;
	}else if($form_data['saludo']=='0'){

		$MsgError  = " * Error en Saludo , selecionar un valor.";
		$respuesta->assign("saludo","focus()","");
		$bError = true;
	}



	if($bError == true){
		$respuesta->alert($MsgError);

	}else{

		$respuesta->assign("form_nuevo","action","data.boletines.php");
		$respuesta->assign("form_nuevo","submit()","");
	}	

	return $respuesta;

}

function mostrarListas($cliente,$select){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$rowlistas  = $model->listarTablaGeneral("id,nombres","listas"," where estado = 1 and cliente_id = '".$cliente."'  order by nombres asc");

	$html = '';
	$html .= '<select name="Lista" id="Lista" class="form-control"><option value="0">[Seleccionar Lista]</option>';

	 for($i=0;$i<count($rowlistas);$i++){

	 	$selected = '';
		if($select==$rowlistas[$i]["id"]){
			$selected = 'selected';
		}

     	$html .= '<option '.$selected.' value="'.$rowlistas[$i]["id"].'" >'.utf8_encode($rowlistas[$i]["nombres"]).'</option>';   
     }

	$html .= '</select>';  

	$respuesta->assign("HTML_LISTAS","innerHTML",$html);
	
	return $respuesta;

}

// Borra archivo adjuntos 1 x 1
function borrarAdjunto($nombre,$indice){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$model->eliminarRegistro("boletin_archivos" , " id = '".($indice)."' ");

	@unlink("images/boletines/adjuntos/".$nombre);	
	$respuesta->Script("$('.botones_".$indice."').remove();");
	$respuesta->alert('archivo Eliminado...');

	return $respuesta;
}

// Enviar correo - Boton: Vista previa
function enviarMailPrueba($id_boletin){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$respuesta->assign("cargador","style.display","block");


	if(!$_SESSION['sEMAIl']){

		$respuesta->alert('* Error volver a Iniciar sesion.');
		$respuesta->Script("window.location='index.php';");

	}else{
 
		$boletin   = $model->listarTablaGeneral("*","boletin"," where id = '".$id_boletin."' ");
		$boletinAdjuntos = $model->listarTablaGeneral("*","boletin_archivos"," where boletin_id = '".$id_boletin."' ");

		$saludos   = $model->listarTablaGeneral("nombres","saludos"," where id = '".$boletin[0]['saludo_id']."' ");
		$usuarios  = $model->listarTablaGeneral("firma,nombres,email","usuarios"," where id = '".$boletin[0]['usuario_id']."' ");
		$img_firma = ($usuarios[0]['firma']!='')?$usuarios[0]['firma']:'firma.jpg';
		
		// Enviar correo 
		$mail 	 = new PHPMailer();
		$mail->CharSet = "UTF-8";

		/*$mail->IsSMTP();
		$mail->SMTPAuth = true;		*/		 
		$mail->Host = "localhost";
		//$mail->Port = 25;
		//$mail->Username = "prensa@pacificlatam.com";
		//$mail->Password = "prens1@";	
		$mail->setFrom('prensa@pacificlatam.com', 'Prensa Pacific');

		$mail->From = $usuarios[0]['email'];
		$mail->FromName = utf8_encode($usuarios[0]['nombres']); 
		$mail->AddReplyTo($usuarios[0]['email'],utf8_encode($usuarios[0]['nombres'])); 

		$mail->Subject = utf8_encode($boletin[0]['asunto']); // asunto
		for($ba=0;$ba<count($boletinAdjuntos);$ba++){
			$mail->AddAttachment('images/boletines/adjuntos/'.$boletinAdjuntos[$ba]['nombres']); 
		}

		$mail->AddAddress($_SESSION['sEMAIl']); // Segundo parametro Nombre del destinatario
		$mail->WordWrap = 50;
		$body  = "<p>".utf8_encode($saludos[0]['nombres'])." <b>".utf8_encode($_SESSION['sNOMBRES'])."</b></p><p>".utf8_encode($boletin[0]['resumen'])."</p><p><img src='images/boletines/".$boletin[0]['imagen']."' /></p><p><a href='http://pacificlatam.com/'><img border='0' src='images/firmas/".$img_firma."'></a></p>"; 	
					
		$mail->msgHTML($body);

		if(!$mail->Send()) {
			$respuesta->alert("Mailer Error: " . $mail->ErrorInfo);
		} else {
			$respuesta->assign("cargador","style.display","none");
			$respuesta->alert("Mensaje Enviando , Revise su correo." );
		}
		$mail->ClearAddresses();		
		// End Enviar correo 	
	}

	return $respuesta;
}// End Function 


// Enviar boletin a varios
function enviarMailista($id_boletin){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$boletin   	 = $model->listarTablaGeneral("*","boletin"," where id = '".$id_boletin."' ");	
	$lista     	 = $model->listarTablaGeneral("periodistas","listas"," where id = '".$boletin[0]['lista_id']."' ");


	$boletinAdjuntos = $model->listarTablaGeneral("*","boletin_archivos"," where boletin_id = '".$id_boletin."' ");

	$saludos   = $model->listarTablaGeneral("nombres,nombres_femenino,ninguno","saludos"," where id = '".$boletin[0]['saludo_id']."' ");
	$usuarios  = $model->listarTablaGeneral("firma,nombres,email","usuarios"," where id = '".$boletin[0]['usuario_id']."' ");
	$img_firma = ($usuarios[0]['firma']!='')?$usuarios[0]['firma']:'firma.jpg';

		// -------------- --------- Enviar correo 
        $mail 	 = new PHPMailer();
		$mail->CharSet = "UTF-8";
		
		//$mail->IsSMTP();
		//$mail->SMTPAuth = true;				 
		$mail->Host = "localhost";
		//$mail->Port = 25;
		//$mail->Username = "prensa@pacificlatam.com";
		//$mail->Password = "prens1@";	
		$mail->setFrom('prensa@pacificlatam.com', 'Prensa Pacific');

		$mail->From = trim($usuarios[0]['email']);
		$mail->FromName = utf8_encode($usuarios[0]['nombres']); 
		$mail->AddReplyTo($usuarios[0]['email'],utf8_encode($usuarios[0]['nombres'])); 

		$mail->Subject = utf8_encode($boletin[0]['asunto']); // asunto

		for($ba = 0 ;$ba<count($boletinAdjuntos);$ba++){
			$mail->AddAttachment('images/boletines/adjuntos/'.$boletinAdjuntos[$ba]['nombres']); 
		}


		$periodistas = $model->listarTablaGeneral("nombres,apellidos,emailA,sexo","periodistas"," where id in (".$lista[0]['periodistas'].") ");
		$DesSaludo = "";

		for($pp=0;$pp<count($periodistas);$pp++){					

			
			if($periodistas[$pp]['sexo']=='M'){
			
				$DesSaludo = $saludos[0]['nombres'];
			}else if($periodistas[$pp]['sexo']=='F'){
				
				$DesSaludo = $saludos[0]['nombres_femenino'];

			}else{

				$DesSaludo = $saludos[0]['ninguno'];	
			}


			$mail2 = clone $mail;
			$body  = "<p>".utf8_encode($DesSaludo)." <b>".$periodistas[$pp]['nombres']." ".$periodistas[$pp]['apellidos']."</b></p><p>".utf8_encode($boletin[0]['resumen'])."</p><p><img src='images/boletines/".$boletin[0]['imagen']."' /></p><p><a href='http://pacificlatam.com/'><img border='0' src='images/firmas/".$img_firma."'></a></p>"; 
			$mail2->MsgHTML($body);
			$mail2->AddAddress($periodistas[$pp]['emailA']);
			$mail2->send();
			$mail2->ClearAddresses();

		
		}// End For



		// ------------------- ------------- End Enviar correo 

       $campos   = array("fecha_envio","estado");
       $valores  = array(date("Y-m-d H:i:s"),"3" );
       $model->actualizarRegistro("boletin" , $campos , $valores , " id = '".$id_boletin."' ");

       $respuesta->alert("Boletin Enviado." );
  	   $respuesta->Script("window.location='boletines.php';");
	

	   return $respuesta;
}// End Function 

function programarBoletin($form_data){

   $respuesta = new xajaxResponse();
   $model     = new funcionesModel();
	
   $campos   = array("fecha_envio","estado");
   $valores  = array($form_data['fecha_envio'],"2" );
   $model->actualizarRegistro("boletin" , $campos , $valores , " id = '".$form_data['HDDID']."' ");

   $respuesta->alert("Boletin Programado." );
   $respuesta->Script("window.location='boletines.php';");
	 	  
    return $respuesta;
}

// Guardar sin cerrar la ventanaa
function guardarBoletin($form_data){

   $respuesta = new xajaxResponse();
   $model     = new funcionesModel();

	$MsgError = "";


	if(strlen($form_data['nombres'])<=2){

		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}else if($form_data['difusion']==0){

		$MsgError  = " * Error en Difusión , selecionar un valor.";
		$respuesta->assign("difusion","focus()","");
		$bError = true;
	}else if($form_data['clientes']==0){

		$MsgError  = " * Error en Clientes , selecionar un valor.";
		$respuesta->assign("clientes","focus()","");
		$bError = true;
	}else if($form_data['Lista']==0){

		$MsgError  = " * Error en Lista , selecionar un valor.";
		$respuesta->assign("Lista","focus()","");
		$bError = true;
	}else if(strlen($form_data['asunto'])<=2){

		$MsgError  = " * Error en Asunto , ingresar un valor.";
		$respuesta->assign("asunto","focus()","");
		$bError = true;
	}else if($form_data['saludo']=='0'){

		$MsgError  = " * Error en Saludo , selecionar un valor.";
		$respuesta->assign("saludo","focus()","");
		$bError = true;
	}


	if($bError == true){
		$respuesta->alert($MsgError);

	}else{

		$respuesta->assign("HddUrl","value","1");
		$respuesta->assign("form_nuevo","action","data.boletines.php");
		$respuesta->assign("form_nuevo","submit()","");

	}// Else	


   return $respuesta;	  
}



require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteBoletin");
$xajax->registerFunction("nuevoBoletin");
$xajax->registerFunction("editarBoletin");
$xajax->registerFunction("mostrarListas");
$xajax->registerFunction("borrarAdjunto");
$xajax->registerFunction("enviarMailPrueba");
$xajax->registerFunction("enviarMailista");	
$xajax->registerFunction("programarBoletin");
$xajax->registerFunction("guardarBoletin");	
$xajax->processRequest();
?>