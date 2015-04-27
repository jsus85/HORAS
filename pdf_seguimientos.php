<?php
include_once('pdf/phpToPDF.php') ;
//Code to generate PDF file from specified URL
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();
$fecha             = $_REQUEST['fecha'];
$fecha2            = $_REQUEST['fecha2'];
$clientes_control  = $_REQUEST['clientes'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];

$idseguimientos = '0';
if($_POST['HddidActividad'] !=0){
    $idseguimientos  =  $_POST['HddidActividad'];
}

$lista             = $model->datosSeguimientos($clientes_control,$difusion_control,$lista_control,$fecha,$fecha2,$idseguimientos);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$cobertura         = array_cobertura();
$periocidad        = array_periocidad();


$html = '';
$html .='<p style="font-family:arial"><img  style="float:right" src="http://solucionperu.com/pacific/images/logo.png" /></p>
      <p><center><b style="font-family:arial;font-size:16px">REPORTE DE SEGUIMIENTOS</b></center></p>
      <p style="font-family:arial">TOTAL DE REGISTROS: <b>'.count($lista).'</b> </p><br />'; 

  $html .='<table id="example2" style="font-family:arial;font-size:10px" cellspacing="2"  cellpadding = "2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>';
                                          
                                            if($_POST['CHKCliente']==1){ 
                                               $html .='<th style="background:#DDD;">CLIENTE</th>';
                                            }
                                            
                                            if($_POST['CHKDifusion']==1){ 
                                              $html .='<th style="background:#DDD;">DIFUSION</th>';
                                            }

                                            if($_POST['CHKLista']==1){ 
                                               $html .='<th style="background:#DDD;">LISTA</th>';
                                             }

                                            if($_POST['CHKDocumento']==1){                                             
                                              $html .='<th style="background:#DDD;">DOCUMENTO</th>';
                                             }

                                            if($_POST['CHKFecRegistro']==1){  
                                              $html .='<th style="background:#DDD;">Fecha</th>';
                                            }

                                            if($_POST['CHKUsuario']==1){
                                              $html .='<th style="background:#DDD;">USUARIO</th>';
                                            }

                                            $html .='</tr></thead><tbody>';
                                            
                                     
                                        $arrai_periodistas = "";    
                                        for($i=0;$i<count($lista);$i++){

                                       
                                        $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");// Cliente
                                        $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");// usuario
                                        $data3 = $model->listarTablaGeneral(" nombres ","listas","where id='".$lista[$i]["lista_id"]."'");//Lista
                                        $data4 = $model->listarTablaGeneral(" nombres ","difusion","where id='".$lista[$i]["difusion_id"]."'");//Lista
                                        $data5 = $model->listarTablaGeneral(" nombres ","boletin","where id='".$lista[$i]["boletin_id"]."'");//Lista

                                     

                                        $html .='<tr class="odd gradeX">';

                                        if($_POST['CHKCliente']==1){    

                                          $html .='<td>'.utf8_encode($data1[0]["nombres"]).'</td>';
                                        }

                                         if($_POST['CHKDifusion']==1){ 
                                           $html .='<td>'.utf8_encode($data4[0]["nombres"]).'</td>';    
                                         }               

                                         if($_POST['CHKLista']==1){ 
                                            $html .='<td>'.utf8_encode($data3[0]["nombres"]).'</td>';
                                          }                                            

                                          if($_POST['CHKDocumento']==1){                                            
                                           $html .='<td>'.utf8_encode($data5[0]["nombres"]).'</td>';
                                           }
                                            
                                           if($_POST['CHKFecRegistro']==1){  
                                            $html .='<td>'.($lista[$i]["fecha_registro"]).'</td>';
                                             }
                                            
                                            if($_POST['CHKUsuario']==1){                                                                                            
                                            $html .='<td>'.utf8_encode($data2[0]["nombres"]).'</td>';
                                             }
                                            
                                        $html .='</tr>';
                                         } 
                                            

                                        $html .='</tbody></table> ';


$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimir_seguimientos'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimir_seguimientos".$random.".pdf");
?> 