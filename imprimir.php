<?php
include_once('pdf/phpToPDF.php') ;

  //Code to generate PDF file from specified URL
   include("model/functions.php");
$model       = new funcionesModel();


$guardar_checkbox = '';
if($_POST['HddidActividad'] !=0){
  $guardar_checkbox =  $_POST['HddidActividad'];
}

$lista  = $model->datosActividadesReporte($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccionEditar_'],$_POST['clientes'],$guardar_checkbox,'');


$html = '';
$html .= '<p><img src="http://solucionperu.com/pacific/images/logo.png" /></p><h3 style="font-family:arial;">Reporte de Actividades</h3><table style="font-size:12px;font-family:arial;" cellspacing="0"  cellpadding = "0">
             <thead>
                                            <tr>';
                                         if($_POST['CHKPeriodista']){
                                                  $html .= '<th style="background:#DDD;padding:2px">PERIODISTA</th>';
                                                }

                                                if($_POST['CHKTelefono']){                                             
                                                  $html .= '<th style="background:#DDD;padding:2px">TELÉFONO</th>';
                                                }

                                                if($_POST['CHKEmail']){                                             
                                                  $html .= '<th style="background:#DDD;padding:2px">EMAIL</th>';                                                  
                                                }  
                                                


                                      $html .=  '
                                                <th style="background:#DDD;padding:2px">CELULAR</th>
                                                <th style="background:#DDD;padding:2px">T. MEDIO</th>
                                                <th style="background:#DDD;padding:2px">MEDIO</th>
                                                <th style="background:#DDD;padding:2px">CLIENTE</th>
                                                <th style="background:#DDD;padding:2px">T.INTERES</th>
                                                <th style="background:#DDD;padding:2px">SECCIÓN</th>                                          
                                                <th style="background:#DDD;padding:2px">CARGO</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                    
                    
                
                   for($i=0;$i<count($lista);$i++){
                                        
                       $dataTipoMedio   = $model->listarTablaGeneral(" nombres ","tipo_medios","where id='".$lista[$i]["tipo_medio_id"]."'");
                       $dataMedios      = $model->listarTablaGeneral(" nombres ","medios","where id='".$lista[$i]["medio_id"]."'");
                      
                       $dataClientes    = $model->listarTablaGeneral(" nombres ","clientes","where id in (".$lista[$i]["clientes_id"].") ");
                       $dataTemaInteres = $model->listarTablaGeneral(" nombres ","tema_interes","where id  in (".$lista[$i]["tema_interes"].") ");
                       
                       $dataSecciones   = $model->listarTablaGeneral(" nombres ","secciones","where id in(".$lista[$i]["secciones_id"].")");

                       $dataCargo       = $model->listarTablaGeneral(" nombres ","cargos","where id='".$lista[$i]["cargo_id"]."'");

                $NombresClientes = "";       
                for($y=0;$y<count($dataClientes);$y++){  
                    $NombresClientes .= utf8_encode($dataClientes[$y]['nombres']);
                }

                $NombresTema = "";   
                for($z=0;$z<count($dataTemaInteres);$z++){  
                    $NombresTema .=  "/".utf8_encode($dataTemaInteres[$z]['nombres']);
                }

                  $NombreSecciones = "";
                for($x=0;$x<count($dataSecciones);$x++){
                  $NombreSecciones .=  "/".utf8_encode($dataSecciones[$x]['nombres']);
                 }

                 $html .= '<tr>';

                            if($_POST['CHKPeriodista']){                               
                               $html .= '<td style="border:1px #CCC solid;padding:2px">'.utf8_encode($lista[$i]["nombres"])." ".utf8_encode($lista[$i]["apellidos"]).'</td>';
                            }

                            if($_POST['CHKTelefono']){
                              $html .= '<td style="border:1px #CCC solid;padding:2px">'.$lista[$i]["telefono"]." ".$lista[$i]["telefonoB"]." ".$lista[$i]["telefonoC"].'</td>';
                             } 

                             if($_POST['CHKEmail']){ 
                              $html .=  '<td style="border:1px #CCC solid;padding:2px">'.$lista[$i]["emailA"]." ".$lista[$i]["emailB"]." ".$lista[$i]["emailC"].'</td>';
                             } 


                    $html .=   '<td style="border:1px #CCC solid;padding:2px">'.$lista[$i]["celularA"].' '.$lista[$i]["celularB"].' '.$lista[$i]["celularC"].'</td>
                                <td style="border:1px #CCC solid;padding:2px">'.utf8_encode($dataTipoMedio[0]["nombres"]).'</td>
                                <td style="border:1px #CCC solid;padding:2px">'.utf8_encode($dataMedios[0]["nombres"]).'</td>
                                <td style="border:1px #CCC solid;padding:2px">'.$NombresClientes.'</td>                                        
                                <td style="border:1px #CCC solid;padding:2px">'.$NombresTema.'</td>
                                <td style="border:1px #CCC solid;padding:2px">'.$NombreSecciones.'</td>                                            
                                <td style="border:1px #CCC solid;padding:2px">'.utf8_encode($dataCargo[0]['nombres']).'</td>                                       
                                        </tr>';
                                         } 
                                            

                                        $html .= '</tbody></table>';



$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimir'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimir".$random.".pdf");
?> 