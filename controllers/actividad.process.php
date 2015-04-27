<?php
/* 
 * Funciones para actividades.php 
 */
function deleteActividad($form_data)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	foreach ($form_data['idActividad'] as $key => $value) {


		$model->eliminarRegistro("periodistas" , " id = '".$value."' ");
		$model->eliminarRegistro("actividad_periodista" , " periodista_id = '".$value."' ");
		//$model->eliminarRegistro("detalle_actividad_periodista" , " actividad_periodista_id = '".$value."' ");
		
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
	}
	$respuesta->alert('Registro Eliminado...');
	return $respuesta;
	
}// END FUNCTION 
   



function nuevoActividad($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$bError = false;	
	$MsgError = "";

	if($form_data['periodistas']==0){
		$MsgError  = " * Error en Periodista , seleccione un valor.";
		$respuesta->assign("periodistas","focus()","");
		$bError = true;
	}

	if($bError == true){

		$respuesta->alert($MsgError);
	
	}else{


			$id_clientes 	 = NULL;
			$id_tema_interes = NULL;	
			$id_secciones	 = NULL;
			for($i=1;$i<=10;$i++){

				if(isset($form_data['validar_'.$i])){ // solo cuando dan check al control.

					$id_clientes 	 .=  ",".$form_data['clientes_'.$i];
					$id_tema_interes .=  ",".$form_data['tema_interes_'.$i];
					$id_secciones	 .=  ",".$form_data['seccion_'.$i];

				}
			}

			// --- Insert Actividad Detalle ---
			$campos	 = array("tipo_medio_id","medio_id","cargo_id","fecha_inicio","fecha_final","telefonos","anexo","clientes_id","tema_interes_id","secciones_id","fecha_registro","ctime","periodista_id");	
			$valores = array($form_data['tipo_medios'],$form_data['medios'],$form_data['cargos'],$form_data['fecha_inicio'],$form_data['fecha_final'],$form_data['telefonos'],$form_data['anexo'], substr($id_clientes,1) , substr($id_tema_interes,1) , substr($id_secciones,1) , date("Y-m-d") , date("Y-m-d H:i:s") ,  $form_data['periodistas']);

			$model->insertarRegistro("actividad_periodista",$campos,$valores);
			$codigo_actividad = mysql_insert_id();
			// ---- insert actividad ---

		
			// --- Insert Activida Detalle ---
			for($m=0;$m<=10;$m++){

				if(isset($form_data['validar_'.$m])){ // solo cuando dan check al control.

					$campos2	 = array("cliente_id","tema_interes_id","secciones_id","actividad_periodista_id","fecha_registro","ctime");
					$valores2    = array($form_data['clientes_'.$m],$form_data['tema_interes_'.$m],$form_data['seccion_'.$m],$codigo_actividad, date("Y-m-d") , date("Y-m-d H:i:s") );
					$model->insertarRegistro("detalle_actividad_periodista",$campos2,$valores2);
				}
			}
			// --- Insert Activida Detalle ---
			
			$respuesta->alert('Registro Guardado...');
			//$respuesta->Script("window.location= 'actividades.php'");
			$respuesta->Script("window.location= 'EditarPeriodista-".$form_data['periodistas'].".html'");			

	}

	return $respuesta;
}


function editarActividad($form_data){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$bError = false;	
	
	$MsgError = "";
	
	if($form_data['periodistas']==0){
		$MsgError  = " * Error en Periodista , seleccione un valor.";
		$respuesta->assign("periodistas","focus()","");
		$bError = true;
	}


	if($bError == true){

		$respuesta->alert($MsgError);
		return $respuesta;
	
	}else{

			$id_clientes 	 = NULL;
			$id_tema_interes = NULL;	
			$id_secciones	 = NULL;
	
	
			for($i=0;$i<=10;$i++){

				if(isset($form_data['validar_'.$i])){ // solo cuando dan check al control.

					$id_clientes 	 .=  ",".$form_data['clientes_'.$i];
					$id_tema_interes .=  ",".$form_data['tema_interes_'.$i];
					$id_secciones	 .=  ",".$form_data['seccion_'.$i];

				}
			}
		
		$campos	 = array("tipo_medio_id","medio_id","cargo_id","fecha_inicio","fecha_final","telefonos","anexo","clientes_id","tema_interes_id","secciones_id","fecha_registro","ctime");	
		//,"periodista_id"
		//,  $form_data['periodistas']
		$valores = array($form_data['tipo_medios'],$form_data['medios'],$form_data['cargos'],$form_data['fecha_inicio'],$form_data['fecha_final'],$form_data['telefonos'],$form_data['anexo'], substr($id_clientes,1) , substr($id_tema_interes,1) , substr($id_secciones,1) , date("Y-m-d") , date("Y-m-d H:i:s") );
		

	
		$model->actualizarRegistro("actividad_periodista" , $campos , $valores , " id = '".$form_data['HddID']."' ");

		//$model->eliminarRegistro("detalle_actividad_periodista" , " actividad_periodista_id = '".$form_data['HddID']."' "); // borrar 

		// --- Insert Activida Detalle ---
			
			mysql_query("delete from detalle_actividad_periodista where actividad_periodista_id = '".$form_data['HddID']."' "); // Borrar los actuales para reemplazr por los nuevos

			for($m=0;$m<=10;$m++){

				if(isset($form_data['validar_'.$m])){ // solo cuando dan check al control.

					$campos2	 = array("cliente_id","tema_interes_id","secciones_id","actividad_periodista_id","fecha_registro","ctime");
					$valores2    = array($form_data['clientes_'.$m],$form_data['tema_interes_'.$m],$form_data['seccion_'.$m],$form_data['HddID'], date("Y-m-d") , date("Y-m-d H:i:s") );
					$model->insertarRegistro("detalle_actividad_periodista",$campos2,$valores2);
				}
			}
			// --- Insert Activida Detalle ---


		$respuesta->alert('Registro Actualizado...');
		//$respuesta->Script("window.location= 'actividades.php'");
		$respuesta->Script("window.location= 'EditarPeriodista-".$form_data['periodistas'].".html'");
	}

		return $respuesta;
	
}

function consultarSeccion($form_data,$Sec){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$seccion = $model->listarTablaGeneral("id,nombres","secciones"," where estado = 1 and  tema_interes_id = '".$form_data."' order by nombres asc");
	$html = "";
	$html .= "<select id='seccion'  name='seccion' class='select1'> <option value='0'>[Seleccionar]</option>";
				
               for($i=0;$i<count($seccion);$i++){
               	$selected = "";
				if($Sec == $seccion[$i]['id']){	$selected = "selected";	}
	$html .="<option ".$selected." value='".$seccion[$i]['id']."'>".utf8_encode($seccion[$i]['nombres'])."</option>";    
               }
    	$html .= "</select>";


	$respuesta->assign("HTTMLSeccion","innerHTML",$html);
	return $respuesta;
}


function consultarSeccionMultiple($form_data,$indice){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$seccion = $model->listarTablaGeneral("id,nombres","secciones"," where estado = 1 and  tema_interes_id = '".$form_data."' order by nombres asc");
	$html = "";
	$html .= "<select id='seccion_".$indice."' style='float:left'  name = 'seccion_".$indice."' class='select1'> <option value='0'>[Seleccionar]</option>";
				$selected = "";
               for($i=0;$i<count($seccion);$i++){

				if($Sec == $seccion[$i]['id']){	$selected = "selected";	}
	$html .="<option ".$selected." value='".$seccion[$i]['id']."'>".utf8_encode($seccion[$i]['nombres'])."</option>";    
               }
    	$html .= "</select>";


	$respuesta->assign("HTTMLSeccion_".$indice,"innerHTML",$html);
	return $respuesta;
}


// ------------------- permite mostrar los medios desdel actividad.php   ------------
function mostrarMedioslist($tipoMedio,$id_medio,$indice)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$HTML = '';
	$Medios = $model->listarTablaGeneral("id,nombres","medios"," where tipo_medios_id = '".$tipoMedio."' and estado = 1 order by nombres asc ");
	
	$HTML .= '<select id="medios_'.$indice.'"  name="medios_'.$indice.'" onchange="MostrarSeccion(this.value);"><option value="0">[Todos]</option>';
	for($i=0;$i<count($Medios);$i++){
		$select = "";
		if($id_medio == $Medios[$i]["id"]){
			$select = "selected";
		}

			$HTML .= '<option '.$select.'  value='.$Medios[$i]['id'].'>'.utf8_encode($Medios[$i]["nombres"]).'</option>';    
		}
	$HTML .= '</select>';

	if($tipoMedio==2 or $tipoMedio==4){
		$respuesta->Script("$('#suplementos').show();");
		$respuesta->Script("$('.suplementos').show();");
	}else{
		$respuesta->Script("$('#suplementos').val(0);");
		$respuesta->Script("$('#suplementos').hide();");
		$respuesta->Script("$('.suplementos').hide();");

	}

	$respuesta->assign("HTMLMEDIOS_".$indice,"innerHTML",$HTML);

	return $respuesta;
	
}// END FUNCTION 


// ******************** *************  CREAR LISTA *************************

function crearLista($nombres,$clientes,$periodistas)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$campos	 = array("nombres","cliente_id","periodistas","fecha_registro","ctime","usuario_id");		
	$valores = array($nombres,$clientes,$periodistas,date("Y-m-d") , date("Y-m-d H:i:s"),$_SESSION['sID']);
	$model->insertarRegistro("listas",$campos,$valores);
	
	$respuesta->alert('Registro Guardado...');
	$respuesta->Script("window.location= 'listas.php'");
	return $respuesta;

}// END FUNCTION 

// ******************** *************  CARGAR LISTA Depende del CLIENTE *************************

function mostrarLista($cliente){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$rowlistas  = $model->listarTablaGeneral("id,nombres","listas"," where estado = 1 and cliente_id = '".$cliente."'  order by nombres asc");

	$html = '';
	$html .= '<select name="Lista" id="Lista" class="form-control"><option value="0">[Seleccionar Lista]</option>';

	 for($i=0;$i<count($rowlistas);$i++){
     $html .= '<option value="'.$rowlistas[$i]["id"].'">'.utf8_encode($rowlistas[$i]["nombres"]).'</option>';   
         }

	$html .= '</select>';  

	$respuesta->assign("HTML_lista","innerHTML",$html);
	return $respuesta;
}

// agregar lista..
function modificarLista($lista,$clientes,$periodistas)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$rowPeriodistas  = $model->listarTablaGeneral("periodistas","listas"," where id = '".$lista."' ");

	$array1 = explode(",",$periodistas); // periodistas seleccionados del busscador actividades
	$array2 = explode(",",$rowPeriodistas[0]['periodistas']); // periodistas guardado en la  lista 
	$result = array_diff($array1, $array2); 

	$norepetidos_periodistas =  implode(",", $result);// periodistas seleccionados que no se repetin

	$ids_periodistas = '';
	if($norepetidos_periodistas!=''){
		$ids_periodistas = ','.$norepetidos_periodistas;
	}

	$campos	 = array("periodistas");
	$valores = array($rowPeriodistas[0]['periodistas'].$ids_periodistas);

	$model->actualizarRegistro("listas" , $campos , $valores , " id = '".$lista."' ");

	$respuesta->alert('Registro Guardado - Periodistas nuevos agregados a la lista ('.count($result).')');
	$respuesta->Script("window.location= 'listas_editar.php?id=".$lista."'");


	return $respuesta;
}

require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deleteActividad");
$xajax->registerFunction("nuevoActividad");
$xajax->registerFunction("editarActividad");
$xajax->registerFunction("consultarSeccion");
$xajax->registerFunction("consultarSeccionMultiple");
$xajax->registerFunction("mostrarMedioslist");
$xajax->registerFunction("crearLista");
$xajax->registerFunction("mostrarLista");
$xajax->registerFunction("modificarLista");
$xajax->processRequest();
?>