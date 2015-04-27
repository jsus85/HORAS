<?php 
header('Content-Type: text/html; charset=UTF-8'); 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();

$periodista  = $model->listarTablaGeneral("nombres,apellidos","periodistas"," where id = '".$_GET['idperiodista']."'");

?>
<style type="text/css">
body{
    font-family: arial;
    font-size: 12px;
}
</style>

<h5>PERIODISTA: <b><?php echo strtoupper(utf8_encode($periodista[0]['nombres'])." ".utf8_encode($periodista[0]['apellidos']));?></b></h5>
<?php

$difusion  = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 2  order by nombres asc");

   echo "<b>Invitación</b> <br />";


        $boletines2  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                                                                                            and s.boletin_id = b.id AND
                                                                                                                            sd.asistio  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                                                                                AND s.difusion_id = '2'");      
          $suma = count($boletines2);   
          if(count($boletines2) !=0){

              /*for($zz=0;$zz<count($boletines2);$zz++){
                echo "&nbsp;&nbsp;".utf8_encode($boletines2[$zz]["nombres"])."<br />";
              }*/
              echo "&nbsp;&nbsp;".count($boletines2)."<br />";
          }else{
                echo "&nbsp;&nbsp;No tiene Evento.<br />";

          }   
    $suma2 = 0;
     for($xx=0;$xx<count($difusion);$xx++){

        echo "<b>".$difusion[$xx]["nombres"]."</b><br />";


        $boletines  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                                                                                            and s.boletin_id = b.id AND
                                                                                                                            sd.asistio  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                                                                                AND s.difusion_id = '".$difusion[$xx]["id"]."'");  
          $suma2 += count($boletines);  
          if(count($boletines) !=0){
              
              /*for($yy=0;$yy<count($boletines);$yy++){

                  echo "&nbsp;&nbsp;".($boletines[$yy]["nombres"])."<br />";
              } */
                  echo "&nbsp;&nbsp;".count($boletines)."<br />";

            }else{
                  echo "&nbsp;&nbsp;No tiene Evento.<br />";
            }     
  }



$resultado =  $suma + $suma2;

echo "<br /><p><b>TOTAL ASISTIDOS: ".$resultado."</b></p>";

$notas_prensa  = $model->listarTablaGeneral("b.nombres","seguimiento_detalles sd , seguimientos s , boletin b"," where sd.seguimiento_id = s.id
                                                                                                                            and s.boletin_id = b.id AND
                                                                                                                            sd.publicara  = 'S' and sd.periodista_id = '".$_GET['idperiodista']."'
                                                                                                                                AND s.difusion_id = '1'");

echo "<p><b>TOTAL NOTAS DE PRENSA: ".count($notas_prensa)."</b></p>";
?>