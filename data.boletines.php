<?php
session_start();
include("model/functions.php");
require_once('model/class.upload.php');
$model     = new funcionesModel();

if(isset($_POST['query'])){

  if($_POST['query']==1){

         // imagen 1
            $handle = new Upload($_FILES['imagen']);        
            if ($handle->uploaded) {  
              #Ruta 
              $handle->Process('images/boletines/');       
              if ($handle->processed) {
                $imagen = $handle->file_dst_name;
              } 
         }
         // End of Imagen 1

          $estado = 1;
        if(isset($_POST['confirmoEnvio'])){
          if($_POST['confirmoEnvio']==1){
                   $estado = 2;
          }  
        }


        $campos   = array("nombres","fecha_registro","fecha_envio","cliente_id","difusion_id","lista_id","asunto","resumen","saludo_id","imagen","usuario_id","estado");
        $valores  = array($_POST['nombres'],date("Y-m-d H:i:s"),$_POST['fecha_envio'],$_POST['clientes'],$_POST['difusion'],$_POST['Lista'],$_POST['asunto'] ,$_POST['mensaje'],$_POST['saludo'] , $imagen,$_SESSION['sID'] ,$estado );
        $model->insertarRegistro("boletin",$campos,$valores);
        $id_boletin = mysql_insert_id();


       // array de adjuntos -------------------------------------------
        $files = array();
        foreach ($_FILES['documentos'] as $k => $l) {
         foreach ($l as $i => $v) {
         if (!array_key_exists($i, $files))
           $files[$i] = array();
           $files[$i][$k] = $v;
         }
        }    

        foreach ($files as $file) {
          $handle = new Upload($file);
          if ($handle->uploaded) {
            $handle->Process("images/boletines/adjuntos/");
            if ($handle->processed) {

              $campos   = array("nombres","boletin_id");
              $valores  = array($handle->file_dst_name,$id_boletin );
              $model->insertarRegistro("boletin_archivos",$campos,$valores);
            }
          } 
          unset($handle);
        } // End array de adjuntos --------------------------------------


        header('Location: boletin_editar.php?id_boletin='.$id_boletin);

      }else if($_POST['query']==2){

        // Editar boletines

        // Imagen ------------
        if ( $_FILES["imagen"]['name'] !="" ){

          $handle = new Upload($_FILES['imagen']);        
            if ($handle->uploaded) {  
            #Ruta 
            $handle->Process('images/boletines/');       
              if ($handle->processed) {
                $imagen = $handle->file_dst_name;
              } 
            }// End of Imagen 1
          $campos  = array("imagen");
          $valores = array($imagen);
          $model->actualizarRegistro("boletin" , $campos , $valores , " id = '".($_POST['HDDID'])."' ");

        }  // EDITAR FOTO SI lo han Cambiado

      // array de adjuntos -------------------------------------------
        $files = array();
        foreach ($_FILES['documentos'] as $k => $l) {
         foreach ($l as $i => $v) {
         if (!array_key_exists($i, $files))
           $files[$i] = array();
           $files[$i][$k] = $v;
         }
        }    

        foreach ($files as $file) {
          $handle = new Upload($file);
          if ($handle->uploaded) {
            $handle->Process("images/boletines/adjuntos/");
            if ($handle->processed) {
              $campos   = array("nombres","boletin_id");
              $valores  = array($handle->file_dst_name,$_POST['HDDID'] );
              $model->insertarRegistro("boletin_archivos",$campos,$valores);
            }
          } 
          unset($handle);
        } // End array de adjuntos --------------------------------------


        if($_POST['HDDEstate']==3){
            // ninguna accion 
        }else{

            $estado = 1;
            $programar = 0;
            if(isset($_POST['confirmoEnvio'])){
              if($_POST['confirmoEnvio']==1){
                   $estado = 2;
                   $programar = 1;
              }  
            }

          $campos2   = array("estado","programar_envio");
          $valores2  = array($estado,$programar);
          $model->actualizarRegistro("boletin" , $campos2 , $valores2 , " id = '".$_POST['HDDID']."' ");            

        }

       $fecha_envio =  $_POST['fecha_envio']." ".$_POST['hora'].":".$_POST['minuto'].":".$_POST['segundo'];  

       $campos   = array("nombres","fecha_envio","cliente_id","difusion_id","lista_id","asunto","resumen","saludo_id");
       $valores  = array($_POST['nombres'],$fecha_envio,$_POST['clientes'],$_POST['difusion'],$_POST['Lista'],$_POST['asunto'] ,$_POST['mensaje'],$_POST['saludo'] );
       $model->actualizarRegistro("boletin" , $campos , $valores , " id = '".$_POST['HDDID']."' ");

         if($_POST['HddUrl']==1){
           header('Location: boletin_editar.php?id_boletin='.$_POST['HDDID']);
         }else{
           header('Location: boletines.php');
         }         

      }// ELSE IF

  } 
?>