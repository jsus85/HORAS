<?php
include_once('pdf/phpToPDF.php') ;
//Code to generate PDF file from specified URL
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();

$estado            = $_REQUEST['estado'];
$fecha             = $_REQUEST['fecha'];
$clientes_control  = $_REQUEST['clientes'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];
$lista_control     = $_REQUEST['Lista'];

$lista             = $model->datosReporte($clientes_control,$difusion_control,$lista_control,$nombres,$fecha);
$id_periodistas = ''; 
for($xx=0;$xx<count($lista);$xx++){

           $periodistas      = $model->listarTablaGeneral("periodistas","listas"," where id = '".$lista[$xx]["lista_id"]."' ");

           $id_periodistas .=  ",".$periodistas[0]['periodistas'];
   } 

    $arrai_periodistas = explode("," ,substr($id_periodistas,1));
    $resultado = array_unique($arrai_periodistas);

    $idperiodistas_sinrepetir = implode(",", $resultado);

    // periodistas seleccionados mediante
    if($_POST['HddidActividad'] !=0){
      $idperiodistas_sinrepetir =  $_POST['HddidActividad'];
    }
    // End if


    $lista_periodistas       = $model->listarTablaGeneral("nombres,apellidos,id","periodistas"," where id in (".$idperiodistas_sinrepetir.") ");


    $html = '';
    $html .= '<p><img src="http://solucionperu.com/pacific/images/logo.png" /></p><table style="font-family:arial;font-size:11px" cellspacing="2"  cellpadding = "2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>                                       
                                            <th style="text-align:left;background:#DDD;">PERIODISTA</th>';

                                            if($_POST['CHKSiConfirmo']==1){
                                              $html .= '<th style="background:#DDD;">CONFIRMADOS</th>';
                                            }

                                            if($_POST['CHKNoConfirmo']==1){
                                              $html .= '<th style="background:#DDD;">NO CONFIRMADOS</th>';
                                             }

                                            if($_POST['CHKTalvez']==1){
                                              $html .= '<th style="background:#DDD;">TALVEZ CONFIRMADOS</th>';
                                            }

                                            if($_POST['CHKSiAsistio']==1){
                                            $html .= '<th style="background:#DDD;">ASISTIDOS</th>';
                                             }

                                            if($_POST['CHKNoAsistio']==1){                                                                  
                                              $html .= '<th style="background:#DDD;">NO ASISTIDOS</th>';
                                            }

                                            if($_POST['CHKSiPublico']==1){
                                              $html .= '<th style="background:#DDD;">PUBLICADOS</th>';
                                            }

                                            if($_POST['CHKNoPublico']==1){
                                              $html .= '<th style="background:#DDD;">NO PUBLICADOS</th>';
                                             }

                                            $html .= '</tr></thead><tbody>';
                                            
                                     
// select por periodista
$campNombres = "";  
if($nombres  !='0' && $nombres  !=''){  $campNombres  = " and b.id = '".$nombres."' ";  }                             

$TotalConfirmados       = 0;
$TotalNoConfirmados     = 0;
$TotalTalVezConfirmados = 0;
$TotalSiAsistieron      = 0;

$TotalNoAsistieron      = 0;

$TotalSiPublicaron      = 0;
$TotalNoPublicaron      = 0;

for($i=0;$i<count($lista_periodistas);$i++){

  // CONFIRMADOS
  $confirmo_si = $model->listarTablaGeneral(" count(*) as siconfirmo ","seguimiento_detalles sd , seguimientos s , boletin b ","where sd.confirmo = 'S' and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres);// 

  // NO CONFIRMADOS 
  $confirmo_no = $model->listarTablaGeneral(" count(*) as noconfirmo ","seguimiento_detalles sd , seguimientos s , boletin b ","where sd.confirmo = 'N'  and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres); 

  // CONFIRMARON TAL VEZ
  $confirmo_talvez = $model->listarTablaGeneral(" count(*) as talvez ","seguimiento_detalles","where confirmo = 'T'  and periodista_id='".$lista_periodistas[$i]["id"]."'"); 

  // ASISTIERON SI
  $asistio_si = $model->listarTablaGeneral(" count(*) as siasistio ","seguimiento_detalles sd , seguimientos s , boletin b ","where sd.asistio = 'S'  and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres);

  // ASISTIERON NO
  $asistio_no = $model->listarTablaGeneral(" count(*) as noasistio ","seguimiento_detalles sd , seguimientos s , boletin b","where asistio = 'N' and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres); 

  // SI PUBLICARA
  $publicara_si = $model->listarTablaGeneral(" count(*) as sipublicara ","seguimiento_detalles sd , seguimientos s , boletin b","where publicara = 'S'  and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres);

// NO PUBLICARA
  $publicara_no = $model->listarTablaGeneral(" count(*) as nopublicara ","seguimiento_detalles sd , seguimientos s , boletin b","where publicara = 'N' and sd.periodista_id='".$lista_periodistas[$i]["id"]."' and sd.seguimiento_id = s.id and s.boletin_id = b.id  ".$campNombres);
                                


  if( $estado != '0' && isset($estado) ){


    if($estado == 'ASISTIDOS'){

     if($asistio_si[0]['siasistio']   !=0){    // ASISTIDOS

            $TotalConfirmados       += $confirmo_si[0]['siconfirmo'];
            $TotalNoConfirmados     += $confirmo_no[0]['noconfirmo'];
            $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez'];
            $TotalSiAsistieron      += $asistio_si[0]['siasistio'];            
            $TotalNoAsistieron      += $asistio_no[0]['noasistio'];    

            $TotalSiPublicaron      +=  $publicara_si[0]['sipublicara'];   
            $TotalNoPublicaron      += $publicara_no[0]['nopublicara'];

                      $html .= '<tr class="odd gradeX">';
          $html .= '<td style="text-align:left">'.utf8_encode($lista_periodistas[$i]["nombres"]).' '.utf8_encode($lista_periodistas[$i]["apellidos"]).'</td>';
          if($_POST['CHKSiConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_si[0]['siconfirmo'].'</td>';
          }
          if($_POST['CHKNoConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_no[0]['noconfirmo'].'</td>';
          }
          if($_POST['CHKTalvez']==1){
          $html .= '<td style="text-align:center">'.$confirmo_talvez[0]['talvez'].'</td>';
          }
          if($_POST['CHKSiAsistio']==1){
          $html .= '<td style="text-align:center">'.$asistio_si[0]['siasistio'].'</td>';
          }
          if($_POST['CHKNoAsistio']==1){                                                                  
          $html .= '<td style="text-align:center">'.$asistio_no[0]['noasistio'].'</td>';
          }
          if($_POST['CHKSiPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_si[0]['sipublicara'].'</td>';
          }
          if($_POST['CHKNoPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_no[0]['nopublicara'].'</td>';
          }
           $html .= '</tr>';


     } // enf if
 
   }else if($estado == 'PUBLICADOS'){  // PUBLICADOS


      if($publicara_si[0]['sipublicara']  !=0){

        $TotalConfirmados += $confirmo_si[0]['siconfirmo'];
        $TotalNoConfirmados += $confirmo_no[0]['noconfirmo'];           
        $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez'];           
        $TotalSiAsistieron      += $asistio_si[0]['siasistio'];
        $TotalNoAsistieron      += $asistio_no[0]['noasistio'];  
        $TotalSiPublicaron     +=  $publicara_si[0]['sipublicara'];   
        $TotalNoPublicaron     += $publicara_no[0]['nopublicara'];  
                  $html .= '<tr class="odd gradeX">';
          $html .= '<td style="text-align:left">'.utf8_encode($lista_periodistas[$i]["nombres"]).' '.utf8_encode($lista_periodistas[$i]["apellidos"]).'</td>';
          if($_POST['CHKSiConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_si[0]['siconfirmo'].'</td>';
          }
          if($_POST['CHKNoConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_no[0]['noconfirmo'].'</td>';
          }
          if($_POST['CHKTalvez']==1){
          $html .= '<td style="text-align:center">'.$confirmo_talvez[0]['talvez'].'</td>';
          }
          if($_POST['CHKSiAsistio']==1){
          $html .= '<td style="text-align:center">'.$asistio_si[0]['siasistio'].'</td>';
          }
          if($_POST['CHKNoAsistio']==1){                                                                  
          $html .= '<td style="text-align:center">'.$asistio_no[0]['noasistio'].'</td>';
          }
          if($_POST['CHKSiPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_si[0]['sipublicara'].'</td>';
          }
          if($_POST['CHKNoPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_no[0]['nopublicara'].'</td>';
          }
           $html .= '</tr>';

      }// END IF

   }else if($estado == 'CONFIRMADOS'){  // CONFIRMAOS
   
    if($confirmo_si[0]['siconfirmo']  !=0){

           $TotalConfirmados += $confirmo_si[0]['siconfirmo'];
           $TotalNoConfirmados += $confirmo_no[0]['noconfirmo'];
           $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez']; 
           $TotalSiAsistieron      += $asistio_si[0]['siasistio'];
           $TotalNoAsistieron      += $asistio_no[0]['noasistio'];  
           $TotalSiPublicaron     +=  $publicara_si[0]['sipublicara'];   
           $TotalNoPublicaron     += $publicara_no[0]['nopublicara'];      

                     $html .= '<tr class="odd gradeX">';
          $html .= '<td style="text-align:left">'.utf8_encode($lista_periodistas[$i]["nombres"]).' '.utf8_encode($lista_periodistas[$i]["apellidos"]).'</td>';
          if($_POST['CHKSiConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_si[0]['siconfirmo'].'</td>';
          }
          if($_POST['CHKNoConfirmo']==1){
          $html .= '<td style="text-align:center">'.$confirmo_no[0]['noconfirmo'].'</td>';
          }
          if($_POST['CHKTalvez']==1){
          $html .= '<td style="text-align:center">'.$confirmo_talvez[0]['talvez'].'</td>';
          }
          if($_POST['CHKSiAsistio']==1){
          $html .= '<td style="text-align:center">'.$asistio_si[0]['siasistio'].'</td>';
          }
          if($_POST['CHKNoAsistio']==1){                                                                  
          $html .= '<td style="text-align:center">'.$asistio_no[0]['noasistio'].'</td>';
          }
          if($_POST['CHKSiPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_si[0]['sipublicara'].'</td>';
          }
          if($_POST['CHKNoPublico']==1){
          $html .= '<td style="text-align:center">'.$publicara_no[0]['nopublicara'].'</td>';
          }
           $html .= '</tr>';

    }// End IF
  
  } // END ELSE IF









  }else{ // --------------------------------

           $TotalConfirmados += $confirmo_si[0]['siconfirmo'];
           $TotalNoConfirmados += $confirmo_no[0]['noconfirmo'];
           $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez']; 
           $TotalSiAsistieron      += $asistio_si[0]['siasistio'];
           $TotalNoAsistieron      += $asistio_no[0]['noasistio'];  
           $TotalSiPublicaron     +=  $publicara_si[0]['sipublicara'];   
           $TotalNoPublicaron     += $publicara_no[0]['nopublicara'];  

    $html .= '<tr class="odd gradeX">';
    $html .= '<td style="text-align:left">'.utf8_encode($lista_periodistas[$i]["nombres"]).' '.utf8_encode($lista_periodistas[$i]["apellidos"]).'</td>';
    if($_POST['CHKSiConfirmo']==1){
    $html .= '<td style="text-align:center">'.$confirmo_si[0]['siconfirmo'].'</td>';
    }
    if($_POST['CHKNoConfirmo']==1){
    $html .= '<td style="text-align:center">'.$confirmo_no[0]['noconfirmo'].'</td>';
    }
    if($_POST['CHKTalvez']==1){
    $html .= '<td style="text-align:center">'.$confirmo_talvez[0]['talvez'].'</td>';
    }
    if($_POST['CHKSiAsistio']==1){
    $html .= '<td style="text-align:center">'.$asistio_si[0]['siasistio'].'</td>';
    }
    if($_POST['CHKNoAsistio']==1){                                                                  
    $html .= '<td style="text-align:center">'.$asistio_no[0]['noasistio'].'</td>';
    }
    if($_POST['CHKSiPublico']==1){
    $html .= '<td style="text-align:center">'.$publicara_si[0]['sipublicara'].'</td>';
    }
    if($_POST['CHKNoPublico']==1){
    $html .= '<td style="text-align:center">'.$publicara_no[0]['nopublicara'].'</td>';
    }
     $html .= '</tr>';


  } // END ELSE DEL ESTADO    

} // END FOR
                                            

       $html .= '</tbody>';

       $html .= '<tr  class="odd gradeX">


                  <td style="text-align:left"><b>TOTAL</b></td>';
                  if($_POST['CHKSiConfirmo']==1){
                   $html .= '<td style="text-align:center"><b>'.$TotalConfirmados.'</b></td>';
                  }
                  if($_POST['CHKNoConfirmo']==1){
                   $html .= '<td style="text-align:center"><b>'.$TotalNoConfirmados.'</b></td>';
                  }

                  if($_POST['CHKTalvez']==1){
                  $html .= '<td style="text-align:center"><b>'.$TotalTalVezConfirmados.'</b></td>';
                  }

                  if($_POST['CHKSiAsistio']==1){
                  $html .= '<td style="text-align:center"><b>'.$TotalSiAsistieron.'</b></td>';
                  }

                  if($_POST['CHKNoAsistio']==1){
                  $html .= '<td style="text-align:center"><b>'.$TotalNoAsistieron.'</b></td>';
                  }

                   if($_POST['CHKSiPublico']==1){                   
                  $html .= '<td style="text-align:center"><b>'.$TotalSiPublicaron.'</b></td>';
                    }
                  if($_POST['CHKNoPublico']==1){  
                  $html .= '<td style="text-align:center"><b>'.$TotalNoPublicaron.'</b></td>';
                  }                  
              $html .= '</tr>';

       $html .= '</table>';
   
$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimirSeguimiento'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimirSeguimiento".$random.".pdf");
?>  