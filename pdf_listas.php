<?php
include_once('pdf/phpToPDF.php') ;
//Code to generate PDF file from specified URL
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();


$idboletines = '0';
if($_POST['HddidActividad'] !=0){
    $idboletines  =  $_POST['HddidActividad'];
}
    // End if

$clientes_control  = $_REQUEST['clientes'];
$nombres           = $_REQUEST['nombres'];
$lista             = $model->datosListas($clientes_control,$nombres,$idboletines);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");


$html = '';
$html .= '<p><img src="http://solucionperu.com/pacific/images/logo.png" /></p>';
$html .= '<p style="font-family:arial;font-size:11px">TOTAL DE REGISTROS:'.count($lista).' </p>';

             $html .= '<table id="example2" class="table table-bordered table-striped">
                         <thead>
                        <tr>
                        <th>NOMBRES</th>
                        <th>CLIENTES</th>
                        <th>NUM. PERIODISTAS</th>
                        <th>FECHA REGISTRO</th>
                        <th>USUARIO</th>
                        </tr>
                    </thead>
                    <tbody>';
                        

            $arrai_periodistas = "";    
            for($i=0;$i<count($lista);$i++){

                $arrai_periodistas =  explode(",", $lista[$i]["periodistas"]);
                $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");
                $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");
                $periodistas_listado = $model->listarTablaGeneral(" nombres , apellidos","periodistas","where id in(".$lista[$i]["periodistas"].") ");


                   $html .= '<tr  class="odd gradeX">
                        <td>'.utf8_encode($lista[$i]["nombres"]).'</td>
                        <td>'.($data1[0]["nombres"]).'</td>
                        <td>'.count($arrai_periodistas).'</td>
                        <td>'.$lista[$i]["fecha_registro"].'</td>
                        <td>'.utf8_encode($data2[0]["nombres"]).'</td>
                       
                    </tr>';
                     } 
                        

                    for($p=0;$p<count($periodistas_listado);$p++){
                   
                    $html .= '<tr class="odd gradeX">
                        <td style="text-align:left" colspan="5">'.utf8_encode($periodistas_listado[$p]["nombres"]." ".$periodistas_listado[$p]["apellidos"]).'</td>
                        
                    </tr>';
                    
                                }
                        

                    $html .= '</tbody></table>';

              


$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimir_lista'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimir_lista".$random.".pdf");
?> 