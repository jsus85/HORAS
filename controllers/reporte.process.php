<?php


function mostrarListas($cliente,$select){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$rowlistas  = $model->listarTablaGeneral("id,nombres","listas"," where estado = 1 and cliente_id = '".$cliente."'  order by nombres asc");

	$html = '';
	$html .= '<select name="Lista"  id="Lista" ><option value="0">[Seleccionar Lista]</option>';

	for($i=0;$i<count($rowlistas);$i++){

		$selected = '';
		if($select==$rowlistas[$i]["id"]){
			$selected = 'selected';
		}	
		
    	$html .= '<option '.$selected.' value="'.$rowlistas[$i]["id"].'">'.utf8_encode($rowlistas[$i]["nombres"]).'</option>';   
    }

	$html .= '</select>';  

	$respuesta->assign("HTML_LISTAS","innerHTML",$html);
	
	return $respuesta;

}

function mostrarBoletines($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$campoLista = '';
	if($form_data['clientes']!='0'){
		$campoLista = " and cliente_id = '".$form_data['clientes']."' ";
	}

	$campoDifusion = '';
	if($form_data['difusion']!='0'){
		$campoDifusion = " and difusion_id = '".$form_data['difusion']."' ";
	}

	$rowBoletin  = $model->listarTablaGeneral("id,nombres","boletin"," where  1 ".$campoLista.$campoDifusion."  order by nombres asc");

	$html = '';
	$html .= '<select name="nombres"  id="nombres" ><option value="0">[Seleccionar Documento]</option>';

	for($i=0;$i<count($rowBoletin);$i++){

		$select = "";
		if($form_data['HddBoletin']==$rowBoletin[$i]["id"]){
			$select = "selected";
		}
    	$html .= '<option '.$select.' value="'.$rowBoletin[$i]["id"].'">'.utf8_encode($rowBoletin[$i]["nombres"]).'</option>';   
    }

	$html .= '</select>';  

	$respuesta->assign("HTML_BOLETIN","innerHTML",$html);


	return $respuesta;
}




require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("mostrarListas");
$xajax->registerFunction("mostrarBoletines");
$xajax->processRequest();

?>