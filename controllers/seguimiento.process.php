<?php
function deleteSeguimiento($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();


/*	foreach ($form_data['idLista'] as $key => $value) {

		$model->eliminarRegistro("seguimientos" , " id = '".($value)."' ");
		$model->eliminarRegistro("seguimientos_detalle" , " seguimiento_id = '".($value)."' ");

		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
		
		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("seguimientos",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query
	}*/

	$model->eliminarRegistro("seguimientos" , " id in ( ".$form_data.") ");
	$model->eliminarRegistro("seguimiento_detalles" , " seguimiento_id in ( ".$form_data.") ");
	$respuesta->alert('Registro Eliminado...');
			$respuesta->Script("window.location='seguimientos.php';");	
	return $respuesta;

}// END FUNCTION 




function editarSeguimiento($form_data){

	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";

	if($form_data['HddDifusion']!=''){
		$MsgError  = " * Error en difusion, verificar el seguimiento.";
		$respuesta->assign("nombres","focus()","");
	}


	if($bError == true){
		$respuesta->alert($MsgError);

	}else{

		if($form_data['HddDifusion']==1){
			// NOTA DE PREnSA
		
			for ($jj=0; $jj<$form_data['cantPeriodistas'] ; $jj++) { 
				
				$campos	 = array("publicara","publicara_obs");
				$valores = array($form_data['publicara_'.$jj],$form_data['observaciones_'.$jj]);
				$model->actualizarRegistro("seguimiento_detalles",$campos,$valores , " id = '".$form_data['idSeguimiento'.$jj]."' ");

			}// END FOR

		}else{

			// INVITACION
			for ($xx=0; $xx<$form_data['cantPeriodistas'] ; $xx++) { 					
				$campos	 = array("confirmo","observacion","asistio","tier","comentario");
				$valores = array($form_data['confirmo_'.$xx],$form_data['observaciones_'.$xx],$form_data['asistio_'.$xx],$form_data['tier_'.$xx],$form_data['comentarios_'.$xx]);
				$model->actualizarRegistro("seguimiento_detalles",$campos,$valores," id = '".$form_data['idSeguimiento'.$xx]."' ");	

			}// END FOR

		}	// EN ELSE DIFUSION
		######## End Insert Seguimiento detalle


		$respuesta->alert('* Registro Actualizado.');
		$respuesta->Script("window.location='seguimientos.php';");	
	}	

	return $respuesta;

}

function mostrarListas($cliente){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$rowlistas  = $model->listarTablaGeneral("id,nombres","listas"," where estado = 1 and cliente_id = '".$cliente."'  order by nombres asc");

	$html = '';
	$html .= '<select name="Lista" onchange="xajax_mostrarBoletines(xajax.getFormValues(form_nuevo));" id="Lista" class="form-control"><option value="0">[Seleccionar Lista]</option>';

	for($i=0;$i<count($rowlistas);$i++){
    	$html .= '<option value="'.$rowlistas[$i]["id"].'">'.utf8_encode($rowlistas[$i]["nombres"]).'</option>';   
    }

	$html .= '</select>';  

	$respuesta->assign("HTML_LISTAS","innerHTML",$html);
	
	return $respuesta;

}

function mostrarBoletines($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$campoLista = '';
	if($form_data['Lista']!='0'){
		$campoLista = " and lista_id = '".$form_data['Lista']."' ";
	}

	$campoDifusion = '';
	if($form_data['difusion']!='0'){
		$campoDifusion = " and difusion_id = '".$form_data['difusion']."' ";
	}

	$rowBoletin  = $model->listarTablaGeneral("id,nombres","boletin"," where id not in (SELECT boletin_id FROM seguimientos ) ".$campoLista.$campoDifusion."  order by nombres asc");

	$html = '';
	$html .= '<select name="boletin"  id="boletin" class="form-control"><option value="0">[Seleccionar Documento]</option>';

	for($i=0;$i<count($rowBoletin);$i++){
    	$html .= '<option value="'.$rowBoletin[$i]["id"].'">'.utf8_encode($rowBoletin[$i]["nombres"]).'</option>';   
    }

	$html .= '</select>';  

	$respuesta->assign("HTML_BOLETIN","innerHTML",$html);


	return $respuesta;
}

function mostrarPeriodistas($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$html = '';

	$rowlistas    = $model->listarTablaGeneral("periodistas","listas"," where id = '".$form_data['Lista']."'  ");	
	$periodistas  = $model->listarTablaGeneral("id,nombres,apellidos","periodistas"," where id in (".$rowlistas[0]['periodistas'].") order by nombres asc");
	



	if($form_data['difusion']=='1'){
		
		// ---------------------- NOTA DE PRENSA

		$html .= '<table border="0" width="100%" cellpadding="2" cellspacing="2">
				<tr>
					    <td style="background-color: #E1E1E1;font-weight: bold;" rowspan="2" align="center">Nombres y Apellidos</td>
					    <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center">Confirmacion de Asistencia x <br>Periodista</td>
					    <td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Observaciones</td>
					  </tr>
					  <tr>
					    <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center">Se publicara?</td>
					  </tr>';
		
			for($x=0;$x<count($periodistas);$x++){	
				
				$html .= '<tr>
							    <td><input type="hidden" id="idPeriodista'.$x.'" name="idPeriodista'.$x.'" value="'.$periodistas[$x]["id"].'" />'.utf8_encode($periodistas[$x]["nombres"]).' '.utf8_encode($periodistas[$x]["apellidos"]).'</td>
							    <td align="center"><input type="radio" name="publicara_'.$x.'" id="publicara_'.$x.'" value="SI" /> SI</td>
							    <td  align="center"><input type="radio" name="publicara_'.$x.'" id="publicara_'.$x.'" value="NO" />     NO</td>
							    <td align="center"><input type="text" name="observaciones_'.$x.'" id="observaciones_'.$x.'"></td>
							  </tr>';						  
		} // END FOR
		$html  .= '</table>'; 		
			


	}else{		
			// ---------------------- INVITACION 		
		$html .= '<table border="0" width="100%" cellpadding="2" cellspacing="2">
				<tr>
					<td style="background-color: #E1E1E1;font-weight: bold;" rowspan="2" align="center">Nombres y Apellidos</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" colspan="3" align="center">Confirmacion de Asistencia x <br>Periodista</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Observaciones</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center" valign="middle" abbr="">Confirmacion de Asistencia  <br>dia evento</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">TIER (1:3)</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Comentarios</td>
					</tr>
				<tr>
					<td style="background-color: #E1E1E1;font-weight: bold;" colspan="3" align="center">Confirmo periodista?</td>
					<td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center" valign="middle" abbr="">Asistio?</td>
				</tr>';
		
			for($i=0;$i<count($periodistas);$i++){	
				
				$html .= '<tr>
					    <td><input type="hidden" id="idPeriodista'.$i.'" name="idPeriodista'.$i.'" value="'.$periodistas[$i]["id"].'" />'.utf8_encode($periodistas[$i]["nombres"]).' '.utf8_encode($periodistas[$i]["apellidos"]).'</td>
					    <td align="center"><input type="radio"  name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="SI"> SI</td>
					    <td align="center"><input type="radio"  name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="NO">NO</td>
					    <td  align="center"><input type="radio" name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="Tal vez">Tal vez</td>
					    <td align="center"><input type="text" 	name="observaciones_'.$i.'" id="observaciones_'.$i.'">
					    </td>
					    <td align="center"><input type="radio" name="asistio_'.$i.'" id="asistio_'.$i.'" value="SI">
					      SI</td>
					    <td align="center"><input type="radio" name="asistio_'.$i.'" id="asistio_'.$i.'" value="NO"> NO</td>
					         <td align="center">
					           <select name="tier_'.$i.'" id="tier_'.$i.'">
					           <option value="1">1</option>
					           <option value="2">2</option>
					           <option value="3">3</option>
					           </select>
					         </td>
					         <td align="center"><input type="text" name="comentarios_'.$i.'" id="comentarios_'.$x.'"></td>
					  </tr>';						  
		} // END FOR
		$html  .= '</table>'; 

	} // End else

	
	$respuesta->assign("cantPeriodistas","value",count($periodistas));
	$respuesta->assign("HTML_Periodistas","innerHTML",$html);
	return $respuesta;
}

function guardarSeguimiento($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";


	if($form_data['clientes']==0){
		$MsgError  = " * Error en Cliente , seleccione un valor.";
		$respuesta->assign("clientes","focus()","");
		$bError = true;
	}else if($form_data['Lista']==0){

		$MsgError  = " * Error en Lista, selecionar un valor.";
		$respuesta->assign("Lista","focus()","");
		$bError = true;
	}else if($form_data['difusion']==0){
		$MsgError  = " * Error en Difusión , selecionar un valor.";
		$respuesta->assign("difusion","focus()","");
		$bError = true;
	}else if($form_data['boletin']==0){

		$MsgError  = " * Error en Documento , selecionar un valor.";
		$respuesta->assign("boletin","focus()","");
		$bError = true;
	}


	if($bError == true){

		$respuesta->alert($MsgError);

	}else{

		// Insert Seguimiento
		$campos	 = array("cliente_id","difusion_id","lista_id","boletin_id","fecha_registro","usuario_id");
		$valores = array($form_data['clientes'],$form_data['difusion'],$form_data['Lista'],$form_data['boletin'],date('Y-m-d'),$_SESSION['sID']);
		$model->insertarRegistro("seguimientos",$campos,$valores);
		$id_seguimiento = mysql_insert_id();


		######### Insert seguimiento Detalle 

		if($form_data['difusion']==1){
			// NOTA DE PREnSA
		
			for ($jj=0; $jj<$form_data['cantPeriodistas'] ; $jj++) { 
				
				$campos	 = array("periodista_id","publicara","publicara_obs","fecha_registro","seguimiento_id");
				$valores = array($form_data['idPeriodista'.$jj],$form_data['publicara_'.$jj],$form_data['observaciones_'.$jj],date('Y-m-d'),$id_seguimiento);
				$model->insertarRegistro("seguimiento_detalles",$campos,$valores);

			}// END FOR

		}else{

			// INVITACION
			for ($xx=0; $xx<$form_data['cantPeriodistas'] ; $xx++) { 					
				$campos	 = array("periodista_id","confirmo","observacion","asistio","tier","comentario","fecha_registro","seguimiento_id");
				$valores = array($form_data['idPeriodista'.$xx],$form_data['confirmo_'.$xx],$form_data['observaciones_'.$xx],$form_data['asistio_'.$xx],$form_data['tier_'.$xx],$form_data['comentarios_'.$xx],date('Y-m-d'),$id_seguimiento);
				$model->insertarRegistro("seguimiento_detalles",$campos,$valores);	

			}// END FOR

		}	// EN ELSE DIFUSION
		######## End Insert Seguimiento detalle


		$respuesta->alert('* Registro guardado.');
		$respuesta->Script("window.location='seguimientos.php';");

	}	// End else


	return $respuesta;	
}

require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteSeguimiento");
$xajax->registerFunction("editarSeguimiento");
$xajax->registerFunction("mostrarListas");	
$xajax->registerFunction("mostrarBoletines");	
$xajax->registerFunction("mostrarPeriodistas");	
$xajax->registerFunction("guardarSeguimiento");	
$xajax->processRequest();
?>