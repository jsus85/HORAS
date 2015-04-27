<?php

function deletePeriodista($form_data)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	foreach ($form_data['idPeriodista'] as $key => $value) {

		$model->eliminarRegistro("periodistas" , " id = '".$value."' ");


		// Historial query
		$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores = array("periodistas",$value,"delete",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos,$valores);
		// end(array) History query
		
		$respuesta->Script("$('#rw_".$value."').closest('tr').remove();");
	}
	$respuesta->alert('Registro Eliminado...');
	return $respuesta;
	
}// END FUNCTION 
   
function borrarPeriodista($form_data)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$model->eliminarRegistro("periodistas" , " id = '".$form_data."' ");
   
   	$respuesta->Script("window.location='actividades.php'");
	$respuesta->alert('Periodista Eliminado...');
	return $respuesta;
	
}// END FUNCTION 


function nuevoPeriodista($form_data){

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$Usuarios      = $model->listarTablaGeneral(" count(*) as cantidad","periodistas"," where emailA = '".trim($form_data['emailA'])."' ");

	$bError = false;	
	$MsgError = "";
	if(strlen($form_data['ciudad'])==0){
		$MsgError  = " * Error en Ciudad , seleccione un valor.";
		$respuesta->assign("ciudad","focus()","");
		$bError = true;
	}else if(strlen($form_data['nombres'])<=2){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}else if(strlen($form_data['emailA'])<=2){
		$MsgError  = " * Error en Email #1 , ingresar un valor.";
		$respuesta->assign("emailA","focus()","");
		$bError = true;
	}else if($Usuarios[0]['cantidad'] != 0){
		$MsgError  = " * Error en Periodista , Registro Existente.";
		$respuesta->assign("emailA","focus()","");
		$bError = true;

	}

	if($bError == true){

		$respuesta->alert($MsgError);
	
	}else{


		$respuesta->assign("form_nuevo","action","data.periodista.php");
		$respuesta->assign("form_nuevo","submit()","");

	}

	return $respuesta;
}


function editarPeriodista($form_data){
	
	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$bError = false;	
	
	$MsgError = "";
	if(strlen($form_data['ciudad'])==0){
		$MsgError  = " * Error en Ciudad , seleccione un valor.";
		$respuesta->assign("ciudad","focus()","");
		$bError = true;
	}else if(strlen($form_data['nombres'])<=1){
		$MsgError  = " * Error en Nombres , ingresar un valor.";
		$respuesta->assign("nombres","focus()","");
		$bError = true;
	}


	if($bError == true){

		$respuesta->alert($MsgError);
		return $respuesta;
	
	}else{

		$respuesta->assign("form_nuevo","action","data.periodista.php");
		$respuesta->assign("form_nuevo","submit()","");
		return $respuesta;
	}

		

		
}


function mostrarMedios($tipoMedio,$id_medio,$indice)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$SUPLEMENTOS = array_suplemento();

	// Medios
	$HTML = '';
	$Medios = $model->listarTablaGeneral("id,nombres","medios"," where tipo_medios_id = '".$tipoMedio."' and estado = 1 order by nombres asc ");
	
	$HTML .= '<select id="medios_'.$indice.'"  name="medios_'.$indice.'" class="form-control"><option value="0">[Todos]</option>';
	for($i=0;$i<count($Medios);$i++){
		$select = "";
		if($dataMedios[0]["id"] == $Medios[$i]["id"]){
			$select = "selected";
		}

			$HTML .= '<option '.$select.'  value='.$Medios[$i]['id'].'>'.utf8_encode($Medios[$i]["nombres"]).'</option>';    
		}
	$HTML .= '</select>';

	$respuesta->assign("HTMLMEDIOS_".$indice,"innerHTML",$HTML);

	// Suplementos
	$HTML2 = "";
     $respuesta->Script("$('#suple_".$indice."').hide();");

	if( $tipoMedio==2 || $tipoMedio==4){
        
       $HTML2 .= '<select id="suplementos_'.$indice.'"  name="suplementos_'.$indice.'" class="form-control">
            <option value="0">[Seleccionar]</option>';
            foreach($SUPLEMENTOS as $idx => $value ){
        $HTML2 .='<option value="'.$idx.'">'.$value.'</option>';    
            }
        $HTML2 .= '</select>';
        $respuesta->Script("$('#suple_".$indice."').show();");
	 
	}


	$respuesta->assign("HTMLSUMPLEMENTOS_".$indice,"innerHTML",$HTML2);

	return $respuesta;
	
}// END FUNCTION 
   

// ------------------- permite mostrar los medios desdel periodista.php   ------------
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

	$respuesta->assign("HTMLMEDIOS_".$indice,"innerHTML",$HTML);

	return $respuesta;
	
}// END FUNCTION 


function mostrarMediosNuevo($tipoMedio,$id_medio,$indice)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	$HTML = '';
	$Medios = $model->listarTablaGeneral("id,nombres","medios"," where tipo_medios_id = '".$tipoMedio."' and estado = 1 order by nombres asc ");
	
	$HTML .= '<select id="NuevoMedios_'.$indice.'"  name="NuevoMedios_'.$indice.'" class="form-control"><option value="0">[Todos]</option>';
	for($i=0;$i<count($Medios);$i++){
		$select = "";
		if($dataMedios[0]["id"] == $Medios[$i]["id"]){
			$select = "selected";
		}

			$HTML .= '<option '.$select.'  value='.$Medios[$i]['id'].'>'.utf8_encode($Medios[$i]["nombres"]).'</option>';    
		}
	$HTML .= '</select>';

	$respuesta->assign("NuevoHTMLMEDIOS_".$indice,"innerHTML",$HTML);

	return $respuesta;
	
}// END FUNCTION 
 

// EDITAR DATOS DEL PERIODISTA   
function EditarDatosPeriodista($id_periodista,$campo_periodista,$valor)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$campos	 = array($campo_periodista);
	$valores = array($valor);

	if($campo_periodista=='nacimiento'){
		
		$dia   = substr($valor, 0,2);
		$mes   = substr($valor, 3,2);
		$anio  = substr($valor, 6,10);
		$valores = array($anio."-".$mes."-".$dia);
	}
		
	$model->actualizarRegistro("periodistas" , $campos , $valores , " id = '".$id_periodista."' ");
	
	$respuesta->alert("Registro Editado.");	
	return $respuesta;
	
}// END FUNCTION 

// EDITAR DATOS DE LA ACTIVIDAD ------------------
function EditarDatosActividad($id_actividad,$campo_actividad,$valor)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();

	$campos	 = array($campo_actividad);
	$valores = array($valor);
	$model->actualizarRegistro("actividad_periodista" , $campos , $valores , " id = '".$id_actividad."' ");
	
	$respuesta->alert("Registro Editado.");	
	return $respuesta;
	
}// END FUNCTION 

// Guardar las secciones en la Edicion:
function GuardarSeccionEditar($form_entrada,$indice,$id)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$arrai_secciones = "";
	
	foreach ($form_entrada['seccionEditar'.$indice] as $key => $value) {
		if($value !=0 ){
			$arrai_secciones .= ",".$value;
		}
	}

	$campos	 = array("secciones_id");
	$valores = array(substr($arrai_secciones,1));
	$model->actualizarRegistro("actividad_periodista" , $campos , $valores , " id = '".$id."' ");

	$respuesta->alert("Registro Sección Actualizado.");
	return $respuesta;
	
}// END FUNCTION 

// Guardar las clientes en la Edicion:
function GuardarClientesEditar($form_entrada,$indice,$id)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$arrai_clientes = "";
	
	foreach ($form_entrada['clientesEditar'.$indice] as $key => $value) {
		if($value !=0 ){
			$arrai_clientes .= ",".$value;
		}
	}

	$campos	 = array("clientes_id");
	$valores = array(substr($arrai_clientes,1));
	$model->actualizarRegistro("actividad_periodista" , $campos , $valores , " id = '".$id."' ");

	$respuesta->alert("Registro Clientes Actualizado.");
	return $respuesta;
	
}// END FUNCTION 


// Guardar Tema de interes en la Edicion:
function GuardarInteresEditar($form_entrada,$indice,$id)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$arrai_temas = "";
	
	foreach ($form_entrada['TemaEditar'.$indice] as $key => $value) {
		if($value !=0 ){
			$arrai_temas .= ",".$value;
		}
	}

	$campos	 = array("tema_interes_id");
	$valores = array(substr($arrai_temas,1));
	$model->actualizarRegistro("actividad_periodista" , $campos , $valores , " id = '".$id."' ");

	$respuesta->alert("Registro Tema Interes Actualizado.");
	return $respuesta;
	
}// END FUNCTION 



// Eliminar actividad
function EliminarActividad($id, $indice)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$respuesta->Script("$('#HTML_Actividad$indice').hide();");	
	$model->eliminarRegistro("actividad_periodista" , " id = '".$id."' ");


	return $respuesta;
	
}// END FUNCTION 
	

// Crear actividad perdiosita_editar.php
function AgregarActividad($id)
{

	$respuesta = new xajaxResponse();
	$model     = new funcionesModel();
	
	$campos	 = array("periodista_id","fecha_registro","estado");
	$valores = array($id,date("Y-m-d"),"1");	
	$model->insertarRegistro("actividad_periodista",$campos,$valores);

	$respuesta->Script("window.location.href = 'periodistas_editar.php?id=".$id."';");	
	$respuesta->alert("Actividad Creada.");

	return $respuesta;
	
}// END FUNCTION 
	



require ('xajax/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI','../');
$xajax->registerFunction("deletePeriodista");
$xajax->registerFunction("nuevoPeriodista");
$xajax->registerFunction("editarPeriodista");
$xajax->registerFunction("mostrarMedios");
$xajax->registerFunction("mostrarMedioslist");
$xajax->registerFunction("mostrarMediosNuevo");
$xajax->registerFunction("EditarDatosPeriodista");
$xajax->registerFunction("GuardarSeccionEditar");
$xajax->registerFunction("GuardarClientesEditar");
$xajax->registerFunction("GuardarInteresEditar");
$xajax->registerFunction("EditarDatosActividad");
$xajax->registerFunction("EliminarActividad");
$xajax->registerFunction("AgregarActividad");
$xajax->registerFunction("borrarPeriodista");
$xajax->processRequest();
?>