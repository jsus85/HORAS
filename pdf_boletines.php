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
$lista_control     = $_REQUEST['Lista'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];
$estado            = $_REQUEST['estado'];

$idboletines = '0';
if($_POST['HddidActividad'] !=0){
    $idboletines  =  $_POST['HddidActividad'];
}

$lista             = $model->datosBoletines($nombres,$clientes_control,$difusion_control,$fecha,$fecha2,$lista_control,$estado,$idboletines);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$cobertura         = array_cobertura();
$periocidad        = array_periocidad();

$html = '';
$html .= '<p><img src="http://solucionperu.com/pacific/images/logo.png" /></p>';
$html .= '<p style="font-family:arial;font-size:11px">TOTAL DE REGISTROS:'.count($lista).' </p>';

                $html .= '<p><table style="font-family:arial;font-size:11px" cellspacing="2"  cellpadding = "2" id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>';
                                            if($_POST['CHKDocumento']==1){   
                                              $html .= '<th style="background:#DDD;">DOCUMENTO</th>';
                                            }
                                            if($_POST['CHKEstado']==1){
                                             $html .= '<th style="background:#DDD;">ESTADO</th>';
                                            }
                                            
                                             if($_POST['CHKCliente']==1){
                                               $html .= '<th style="background:#DDD;">CLIENTE</th>';
                                              }
                                            
                                            if($_POST['CHKDifusion']==1){
                                            $html .= '<th style="background:#DDD;">DISUFION</th>';
                                            }
                                            
                                            if($_POST['CHKLista']==1){
                                            $html .= '<th style="background:#DDD;">LISTA</th>';
                                             }
                                            
                                            if($_POST['CHKFecRegistro']==1){
                                            $html .= '<th style="background:#DDD;">FECHA</th>';
                                            }

                                            if($_POST['CHKFecEnvio']==1){
                                             $html .= '<th style="background:#DDD;">F. ENVIO</th>';
                                            } 

                                            if($_POST['CHKUsuario']==1){
                                              $html .= '<th style="background:#DDD;">USUARIO</th>';
                                            }

                                            $html .= '</tr></thead><tbody>';
                                            
                                        $arrai_periodistas = "";    
                                        for($i=0;$i<count($lista);$i++){

                                       
                                        $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");// Cliente
                                        $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");// usuario
                                        $data3 = $model->listarTablaGeneral(" nombres ","listas","where id='".$lista[$i]["lista_id"]."'");//Lista
                                        $data4 = $model->listarTablaGeneral(" nombres ","difusion","where id='".$lista[$i]["difusion_id"]."'");//Lista


                                        $html .= '<tr class="odd gradeX">';
                                            
                                            if($_POST['CHKDocumento']==1){
                                              $html .= '<td>'.utf8_encode($lista[$i]["nombres"]).'</td>';
                                             }
                                            
                                            if($_POST['CHKEstado']==1){

                                            $nombreEstado = '';
                                                        if($lista[$i]["estado"]==1){
                                                            $nombreEstado = 'Borrador';
                                                        }else if($lista[$i]["estado"]==2){
                                                            $nombreEstado = 'Programado';   
                                                        }else if($lista[$i]["estado"]==3){
                                                            $nombreEstado = 'Enviado';
                                                        }
                                                          
                                                $html .= '<td>'.$nombreEstado.'</td>';
                                             }

                                            if($_POST['CHKCliente']==1){
                                              $html .= '<td>'.utf8_encode($data1[0]["nombres"]).'</td>';
                                            }

                                            if($_POST['CHKDifusion']==1){
                                              $html .= '<td>'.utf8_encode($data4[0]["nombres"]).'</td>';                                            
                                            }

                                            if($_POST['CHKLista']==1){                                                                                           
                                            $html .= '<td>'.utf8_encode($data3[0]["nombres"]).'</td>';
                                            }

                                            if($_POST['CHKFecRegistro']==1){
                                              $html .= '<td>'.($lista[$i]["fecha_registro"]).'</td>';
                                            }

                                            if($_POST['CHKFecEnvio']==1){
                                                $html .= '<td>'.($lista[$i]["fecha_envio"]).'</td>';
                                             }

                                             if($_POST['CHKUsuario']==1){                                           
                                              $html .= '<td>'.utf8_encode($data2[0]["nombres"]).'</td>';
                                             } 
                                        $html .= '</tr>';
                                         } 
                                            
                                        $html .= '</tbody>                                 </table>';


$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimir_boletines'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimir_boletines".$random.".pdf");
?> 