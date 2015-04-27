<?php
session_start();
include("model/functions.php");
require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
$model     = new funcionesModel();

$boletines      = $model->listarTablaGeneral("id,fecha_envio","boletin"," where estado = 2 and programar_envio = 1");

if(count($boletines) !=0 ){

for($i=0;$i<count($boletines);$i++){



		 $val1 = date("Y-m-d H:i:s"); // fecha actual
		 $val2 = $boletines[$i]["fecha_envio"];

		$datetime1 = new DateTime($val1);
		$datetime2 = new DateTime($val2);


		if($datetime1 >= $datetime2){
		// enviar boletin		
			$id_boletin = $boletines[$i]["id"];
				$boletin   	 = $model->listarTablaGeneral("*","boletin"," where id = '".$id_boletin."' ");	
				$lista     	 = $model->listarTablaGeneral("periodistas","listas"," where id = '".$boletin[0]['lista_id']."' ");


				$boletinAdjuntos = $model->listarTablaGeneral("*","boletin_archivos"," where boletin_id = '".$id_boletin."' ");

				$saludos   = $model->listarTablaGeneral("nombres,nombres_femenino,ninguno","saludos"," where id = '".$boletin[0]['saludo_id']."' ");
				$usuarios  = $model->listarTablaGeneral("firma,nombres,email","usuarios"," where id = '".$boletin[0]['usuario_id']."' ");
				$img_firma = ($usuarios[0]['firma']!='')?$usuarios[0]['firma']:'firma.jpg';

				// -------------- --------- Enviar correo 
				$mail 	 = new PHPMailer();
				$mail->CharSet = "UTF-8";

							 
				$mail->Host = "localhost";
	
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

				$campos   = array("estado");
				$valores  = array("3" );
				$model->actualizarRegistro("boletin" , $campos , $valores , " id = '".$id_boletin."' ");


			
			echo "Enviar boletin";			
		}else{

			echo "NO hay para enviar";

		}	



}

}else{
	echo "NO hay para enviar";
	
}

 
?>
