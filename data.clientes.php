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
			$handle->Process('images/clientes/');				
			if ($handle->processed) {
				$imagen = $handle->file_dst_name;
			}	
		}// End of Imagen 1


		// Insert

		$campos	 = array("nombres","imagen","fecha_registro");
		$valores = array($_POST['nombres'],$imagen,date('Y-m-d'));
		$model->insertarRegistro("clientes",$campos,$valores);
		$id_clientes = mysql_insert_id();

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("clientes",$id_clientes,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);


		// end(array) History query

		header('Location: clientes.php');		

	}else if($_POST['query']==2){

		 if ( $_FILES["foto"]['name'] !="" ){  
				$handle = new Upload($_FILES['foto']);				
				if ($handle->uploaded) {	
				#Ruta 
				$handle->Process('images/clientes/');				
					if ($handle->processed) {
						$imagen = $handle->file_dst_name;
					}	
				}// End of Imagen 1
				$campos	 = array("imagen");
				$valores = array($imagen);
			$model->actualizarRegistro("clientes" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");
		 }	// EDITAR FOTO SI lo han Cambiado

		$campos	 = array("nombres");
		$valores = array($_POST['nombres']);
		$model->actualizarRegistro("clientes" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");

		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("clientes",$form_data['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query

		

		header('Location: clientes.php');		

	}// ELSE IF

}


?>