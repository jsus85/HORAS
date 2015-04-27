<?php
						require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
						$mail 	 = new PHPMailer();
						$mail->CharSet = "UTF-8";
					    
				        $mail->Host = "localhost";// Servidor
				
						$mail->setFrom('prensa@pacificlatam.com', 'Prensa Pacific');
						$mail->From = "prensa@pacificlatam.com";
						$mail->FromName = "Pacific latam"; 		
						$mail->Subject = "Noticia de prueba"; // Asunto
						
						$body  = "holaaaaaaaa"; // Mensaje
						$mail->MsgHTML($body);

						$mail->AddAddress("prueba@catalogosac.com"); // cambiar destinatario
						$mail->AddAddress("ejemplo@solucionperu.com"); // cambiar destinatario						

						if(!$mail->Send()) {

						echo "Mailer Error: " . $mail->ErrorInfo;

						} else {

						echo "Message sent!";

						}



?>
