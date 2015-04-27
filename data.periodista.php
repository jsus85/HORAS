<?php
session_start();
include("model/functions.php");
require_once('model/class.upload.php');
$model     = new funcionesModel();
	

if(isset($_POST['query'])){

	if($_POST['query']==1){
			// imagen 1
		$handle = new Upload($_FILES['foto']);				
		if ($handle->uploaded) {	
			#Ruta 
			$handle->Process('images/periodistas/');				
			if ($handle->processed) {
				$imagen = $handle->file_dst_name;
			}	
		}// End of Imagen 1


		// Insert
		$maxCodigo = $model->listarTablaGeneral(" (max(SUBSTRING(codigo,2,6))+1) as total ","periodistas","");
		$cod = "P".str_pad($maxCodigo[0]["total"], 5, "00", STR_PAD_LEFT);


		$arrai_temas = "";		
		foreach ($_POST['TemaEditar1'] as $key => $value) {
			if($value !=0 ){
				$arrai_temas .= ",".$value;
			}
		}

		// fecha de cumpleaños
		$dia   = substr($_POST['nacimiento'], 0,2);
		$mes   = substr($_POST['nacimiento'], 3,2);
		$anio  = substr($_POST['nacimiento'], 6,10);
		// End 

		$campos	 = array("codigo","nombres","apellidos","telefono","telefonoB","telefonoC","anexo","celularA","celularB","emailA","emailB","nacimiento","comentarios","foto","direccion","cv","ciudad_id","fecha_registro","tema_interes","sexo");		

		$valores = array($cod,$_POST['nombres'],$_POST['apellidos'],$_POST['telefono'],$_POST['telefono2'],$_POST['telefono3'],$_POST['anexo'],$_POST['celularA'],$_POST['celularB'],$_POST['emailA'],$_POST['emailB'],$anio."-".$mes."-".$dia,$_POST['comentarios'],$imagen,$_POST['direccion'],$_POST['editor1'],$_POST['ciudad'],date("Y-m-d H:i:s"), substr($arrai_temas,1), $_POST['sexo']);

		$model->insertarRegistro("periodistas",$campos,$valores);
		$id_periodista = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("periodistas",$id_periodista,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		header('Location: actividades.php');		

	}else if($_POST['query']==2){

		 /************   EDITAR PERDIODISTA *****/

		 if ( $_FILES["foto"]['name'] !="" ){  

				$handle = new Upload($_FILES['foto']);				
				if ($handle->uploaded) {	
				#Ruta 
				$handle->Process('images/periodistas/');				
					if ($handle->processed) {
						$imagen = $handle->file_dst_name;
					}	
				}// End of Imagen 1

				$campos	 = array("foto");

				$valores = array($imagen);

			$model->actualizarRegistro("periodistas" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");

		 }	// EDITAR FOTO SI lo han Cambiado

		$arrai_temas = "";		
		foreach ($_POST['TemaEditar1'] as $key => $value) {
			if($value !=0 ){
				$arrai_temas .= ",".$value;
			}
		}

		// fecha de cumpleaños
		$dia   = substr($_POST['nacimiento'], 0,2);
		$mes   = substr($_POST['nacimiento'], 3,2);
		$anio  = substr($_POST['nacimiento'], 6,10);
		// End 

		$campos	 = array("nombres","telefono","anexo","celularA","celularB","emailA","emailB","nacimiento","comentarios","direccion","cv","ciudad_id","fecha_registro","tema_interes","sexo");

		$valores = array($_POST['nombres'],$_POST['telefono'],$_POST['anexo'],$_POST['celularA'],$_POST['celularB'],$_POST['emailA'],$_POST['emailB'],$anio."-".$mes."-".$dia,$_POST['comentario'],$_POST['direccion'],$_POST['editor1'],$_POST['ciudad'],date("Y-m-d H:i:s"),substr($arrai_temas,1),$_POST['sexo']);

		$model->actualizarRegistro("periodistas" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("periodistas",$_POST['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		header('Location: actividades.php');		

	}// ELSE IF

}
?>