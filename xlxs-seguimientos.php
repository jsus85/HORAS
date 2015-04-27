<?php 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"detalle_seguimientos_".date("Y-m-d").".xls\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include('validar.session.php');
include("model/functions.php");
$model     = new funcionesModel();

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


?>
<html>
<meta charset="utf-8">
<head>
<style type="text/css">
body{
	font-family: arial;
	font-size: 12px;
}
</style>
<style type="text/css">
    td{text-align: center;margin: 10px;padding: 5px;border: #CCC 1px solid}
    </style>
</head>
<body>
<table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                       
                                            <th style="text-align:left">PERIODISTA</th>
                                            <?php if($_POST['CHKSiConfirmo']==1){?>
                                            <th>CONFIRMADOS</th><?php }?>

                                            <?php if($_POST['CHKNoConfirmo']==1){?>
                                            <th>NO CONFIRMADOS</th>
                                            <?php }?>

                                            <?php if($_POST['CHKTalvez']==1){?>
                                            <th>TALVEZ CONFIRMADOS</th>
                                            <?php }?>

                                            <?php if($_POST['CHKSiAsistio']==1){?>
                                            <th>ASISTIDOS</th>
											<?php }?>

											<?php if($_POST['CHKNoAsistio']==1){?>											                                            
                                            <th>NO ASISTIDOS</th>
                                            <?php }?>

											<?php if($_POST['CHKSiPublico']==1){?>
                                            <th>PUBLICADOS</th>
                                            <?php }?>

                                            <?php if($_POST['CHKNoPublico']==1){?>
                                            <th>NO PUBLICADOS</th>
                                            <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
<?php 
                           
// select por periodista
$campNombres = "";  
if($nombres  !='0' && $nombres    !=''){           $campNombres  = " and b.id = '".$nombres."' ";  }                                

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
          ?>      

           <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
        <td style="text-align:left"><?php echo utf8_encode($lista_periodistas[$i]["nombres"])." ".utf8_encode($lista_periodistas[$i]["apellidos"]);?></td>
        <?php if($_POST['CHKSiConfirmo']==1){?>
        <td><?php echo $confirmo_si[0]['siconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoConfirmo']==1){?>
        <td><?php echo $confirmo_no[0]['noconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKTalvez']==1){?>
        <td><?php echo $confirmo_talvez[0]['talvez'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiAsistio']==1){?>
        <td><?php echo $asistio_si[0]['siasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoAsistio']==1){?>                                                                                      
        <td><?php echo $asistio_no[0]['noasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiPublico']==1){?>
        <td><?php echo $publicara_si[0]['sipublicara'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoPublico']==1){?>
        <td><?php echo $publicara_no[0]['nopublicara'];?></td>
        <?php }?>
        </tr>

<?php
      } // enf if
 
   }else if($estado == 'PUBLICADOS'){  // PUBLICADOS

         if($publicara_si[0]['sipublicara']  !=0){

            $TotalConfirmados       += $confirmo_si[0]['siconfirmo'];
            $TotalNoConfirmados     += $confirmo_no[0]['noconfirmo'];
            $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez'];
            $TotalSiAsistieron      += $asistio_si[0]['siasistio'];            
            $TotalNoAsistieron      += $asistio_no[0]['noasistio'];    

            $TotalSiPublicaron      +=  $publicara_si[0]['sipublicara'];   
            $TotalNoPublicaron      += $publicara_no[0]['nopublicara'];    
?>

         <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
        <td style="text-align:left"><?php echo utf8_encode($lista_periodistas[$i]["nombres"])." ".utf8_encode($lista_periodistas[$i]["apellidos"]);?></td>
        <?php if($_POST['CHKSiConfirmo']==1){?>
        <td><?php echo $confirmo_si[0]['siconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoConfirmo']==1){?>
        <td><?php echo $confirmo_no[0]['noconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKTalvez']==1){?>
        <td><?php echo $confirmo_talvez[0]['talvez'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiAsistio']==1){?>
        <td><?php echo $asistio_si[0]['siasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoAsistio']==1){?>                                                                                      
        <td><?php echo $asistio_no[0]['noasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiPublico']==1){?>
        <td><?php echo $publicara_si[0]['sipublicara'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoPublico']==1){?>
        <td><?php echo $publicara_no[0]['nopublicara'];?></td>
        <?php }?>
        </tr>
 <?php
         }// END IF

   }else if($estado == 'CONFIRMADOS'){  // CONFIRMAOS

         if($confirmo_si[0]['siconfirmo']  !=0){

            $TotalConfirmados       += $confirmo_si[0]['siconfirmo'];
            $TotalNoConfirmados     += $confirmo_no[0]['noconfirmo'];
            $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez'];
            $TotalSiAsistieron      += $asistio_si[0]['siasistio'];            
            $TotalNoAsistieron      += $asistio_no[0]['noasistio'];    

            $TotalSiPublicaron      +=  $publicara_si[0]['sipublicara'];   
            $TotalNoPublicaron      += $publicara_no[0]['nopublicara'];
?>
         <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
        <td style="text-align:left"><?php echo utf8_encode($lista_periodistas[$i]["nombres"])." ".utf8_encode($lista_periodistas[$i]["apellidos"]);?></td>
        <?php if($_POST['CHKSiConfirmo']==1){?>
        <td><?php echo $confirmo_si[0]['siconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoConfirmo']==1){?>
        <td><?php echo $confirmo_no[0]['noconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKTalvez']==1){?>
        <td><?php echo $confirmo_talvez[0]['talvez'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiAsistio']==1){?>
        <td><?php echo $asistio_si[0]['siasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoAsistio']==1){?>                                                                                      
        <td><?php echo $asistio_no[0]['noasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiPublico']==1){?>
        <td><?php echo $publicara_si[0]['sipublicara'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoPublico']==1){?>
        <td><?php echo $publicara_no[0]['nopublicara'];?></td>
        <?php }?>
        </tr>
        

<?php
         }// End IF

  } // END ELSE IF
          
?>

       


        <?php 

       }else{

              $TotalConfirmados += $confirmo_si[0]['siconfirmo'];
            $TotalNoConfirmados += $confirmo_no[0]['noconfirmo'];
            $TotalTalVezConfirmados += $confirmo_talvez[0]['talvez'];                  
            $TotalSiAsistieron      += $asistio_si[0]['siasistio'];
            $TotalNoAsistieron      += $asistio_no[0]['noasistio']; 
            $TotalSiPublicaron     +=  $publicara_si[0]['sipublicara'];    
            $TotalNoPublicaron     += $publicara_no[0]['nopublicara'];
?>

            
         <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
        <td style="text-align:left"><?php echo utf8_encode($lista_periodistas[$i]["nombres"])." ".utf8_encode($lista_periodistas[$i]["apellidos"]);?></td>
        <?php if($_POST['CHKSiConfirmo']==1){?>
        <td><?php echo $confirmo_si[0]['siconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoConfirmo']==1){?>
        <td><?php echo $confirmo_no[0]['noconfirmo'];?></td>
        <?php }?>
        <?php if($_POST['CHKTalvez']==1){?>
        <td><?php echo $confirmo_talvez[0]['talvez'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiAsistio']==1){?>
        <td><?php echo $asistio_si[0]['siasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoAsistio']==1){?>                                                                                      
        <td><?php echo $asistio_no[0]['noasistio'];?></td>
        <?php }?>
        <?php if($_POST['CHKSiPublico']==1){?>
        <td><?php echo $publicara_si[0]['sipublicara'];?></td>
        <?php }?>
        <?php if($_POST['CHKNoPublico']==1){?>
        <td><?php echo $publicara_no[0]['nopublicara'];?></td>
        <?php }?>
        </tr>

<?php 


 } // END ELSE DEL ESTADO 

                } // FOR


    ?> 


           </tbody>
              <tr  class="odd gradeX">
                  <td style="text-align:left"><b>TOTAL</b></td>
                  <?php if($_POST['CHKSiConfirmo']==1){?>
                  <td><b><?php echo $TotalConfirmados ;?></b></td>
                  <?php }?>
                  <?php if($_POST['CHKNoConfirmo']==1){?>
                  <td><b><?php echo $TotalNoConfirmados;?></b></td>
                  <?php }?>  
                  <?php if($_POST['CHKTalvez']==1){?>
                  <td><b><?php echo $TotalTalVezConfirmados;?></b></td>
                  <?php }?>
                  <?php if($_POST['CHKSiAsistio']==1){?>
                  <td><b><?php echo $TotalSiAsistieron;?></b></td>
                  <?php }?>
                  <?php if($_POST['CHKNoAsistio']==1){?> 
                  <td><b><?php echo $TotalNoAsistieron;?></b></td>
                   <?php }?>
                   <?php if($_POST['CHKSiPublico']==1){?>
                  <td><b><?php echo $TotalSiPublicaron;?></b></td>
                  <?php }?>
                  <?php if($_POST['CHKNoPublico']==1){?>
                  <td><b><?php echo $TotalNoPublicaron  ?></b></td>
                  <?php }?>

                  
              </tr>

                                   
                               </table>
</body>
</html>