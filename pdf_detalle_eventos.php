<?php
 include_once('pdf/phpToPDF.php') ;
  //Code to generate PDF file from specified URL
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();

$periodista  = $model->listarTablaGeneral("nombres,apellidos","periodistas"," where id = '".$_GET['idperiodista']."'");
?>
<?php
$html = '';

$html .= '<p><img style="float:right" src="http://solucionperu.com/pacific/images/logo.png" /></p><h5 style="font-family:arial">PERIODISTA: '.strtoupper(utf8_encode($periodista[0]['nombres']).' '.utf8_encode($periodista[0]['apellidos'])).'</h5>';



$difusion  = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 2  order by nombres asc");

   $html .= '<b style="font-family:arial">Invitación</b> <br />';


    $boletines2  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                              and s.boletin_id = b.id AND
                                                              sd.asistio  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                AND s.difusion_id = '2'");    
      $suma = count($boletines2); 
      if(count($boletines2) !=0){

        /*for($zz=0;$zz<count($boletines2);$zz++){

          $html .= '&nbsp;&nbsp;<span style="font-family:arial">'.utf8_encode($boletines2[$zz]["nombres"]).'</span><br /><br />';
        }*/
        $html .= '&nbsp;&nbsp;'.count($boletines2).'<br />';

      }else{
        $html .= '&nbsp;&nbsp;<span style="font-family:arial">No tiene Evento.</span><br /><br />';

      }   
  $suma2 = 0;
   for($xx=0;$xx<count($difusion);$xx++){

      $html .= '<b><span style="font-family:arial">'.$difusion[$xx]["nombres"].'</span></b><br />';


    $boletines  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                              and s.boletin_id = b.id AND
                                                              sd.asistio  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                AND s.difusion_id = '".$difusion[$xx]["id"]."'");  
        $suma2 += count($boletines);  
      if(count($boletines) !=0){
        /*for($yy=0;$yy<count($boletines);$yy++){

              $html .= '&nbsp;&nbsp;<span style="font-family:arial">'.($boletines[$yy]["nombres"]).'</span><br /><br />';
        } */
        $html .= '&nbsp;&nbsp;'.count($boletines).'<br />';
      }else{
            $html .= '&nbsp;&nbsp;<span style="font-family:arial">No tiene Evento.</span><br /><br />';
      }   
  }



$resultado =  $suma + $suma2;

$html .= '<p><b style="font-family:arial">TOTAL ASISTIDOS: '.$resultado.'</p></b>';

$notas_prensa  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                                                                                            and s.boletin_id = b.id AND
                                                                                                                            sd.publicara  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                                                                                AND s.difusion_id = '1'");

$html .= '<p><b style="font-family:arial">TOTAL NOTAS DE PRENSA: '.count($notas_prensa).'</b></p>';

$random = rand();
phptopdf_html($html,'pdf/pdf/', 'imprimir_eventos'.$random.'.pdf'); 
header("Location: pdf/pdf/imprimir_eventos".$random.".pdf");
?> 