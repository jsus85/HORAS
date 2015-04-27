<?php
session_start();
include('validar.session.php');
include("model/functions.php");
require_once('model/class.upload.php');
$model     = new funcionesModel();
	

if(isset($_POST['query'])){

	if($_POST['query']==1){

		// imagen 1
		$handle = new Upload($_FILES['foto']);				
		if ($handle->uploaded) {	
			#Ruta 
			$handle->Process('images/firmas/');				
			if ($handle->processed) {
				$imagen = $handle->file_dst_name;
			}	
		}// End of Imagen 1

		$menus = NULL;	
		for($i=1;$i<=15;$i++){
			if(isset($_POST['menu_'.$i])){ 
				$menus	 .=  ",".$_POST['menu_'.$i];
			}
		}

		$permisos = NULL;	
		for($i=1;$i<=2;$i++){
			if(isset($_POST['atributos_'.$i])){ 
				$permisos	 .=  ",".$_POST['atributos_'.$i];
			}
		}

		$id_clientes = implode(",", $_POST['clientes']);// ID de clientes

		$campos	 	= array("nombres","email","tipo_usuario","clave","fecha_registro","usuario","atributos","permisos","firma","clientes");
		$valores 	= array($_POST['nombres'],$_POST['email'],$_POST['tipo_usuario'],$_POST['password'],date('Y-m-d'),$_POST['usuario'],substr($menus,1) , substr($permisos,1) , $imagen , $id_clientes );
		$model->insertarRegistro("usuarios",$campos,$valores);
		$id_usuario = mysql_insert_id();
		
		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("usuarios",$id_usuario,"insert",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query


		header('Location: usuarios.php');		

	}else if($_POST['query']==2){


		 /************   EDITAR USUARIO *****/

		 if ( $_FILES["foto"]['name'] !="" ){  
				$handle = new Upload($_FILES['foto']);				
				if ($handle->uploaded) {	
				#Ruta 
				$handle->Process('images/firmas/');				
					if ($handle->processed) {
						$imagen = $handle->file_dst_name;
					}	
				}// End of Imagen 1

				$campos	 = array("firma");
				$valores = array($imagen);

			$model->actualizarRegistro("usuarios" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");

		 }	// EDITAR FOTO SI lo han Cambiado


 		for($i=1;$i<=15;$i++){
			if(isset($_POST['menu_'.$i])){ 
				$menus	 .=  ",".$_POST['menu_'.$i];
			}
		}

		$permisos = NULL;	
		for($i=1;$i<=2;$i++){
			if(isset($_POST['atributos_'.$i])){ 
				$permisos	 .=  ",".$_POST['atributos_'.$i];
			}
		}

		$id_clientes = implode(",", $_POST['clientes']);// ID de clientes
		$campos	 = array("nombres","email","tipo_usuario","clave","fecha_registro","usuario","atributos","permisos","clientes");

		$valores = array($_POST['nombres'],$_POST['email'],$_POST['tipo_usuario'],$_POST['password'],date('Y-m-d'),$_POST['usuario'],substr($menus,1) ,substr($permisos,1) ,$id_clientes);
		$model->actualizarRegistro("usuarios" , $campos , $valores , " id = '".$_POST['HDDID']."' ");


		// Historial query
		$campos2    = array("tabla","table_id","query","fecha_query","usuario_id","ip");
		$valores2   = array("usuarios",$_POST['HDDID'],"update",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
		$model->insertarRegistro("historial_querys",$campos2,$valores2);
		// end(array) History query



		header('Location: usuarios.php');		

	}// ELSE IF

}
?>