<?php 
session_start();
include('validar.session.php');
require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("model/functions.php");
include('controllers/seguimiento.process.php');
$model       = new funcionesModel();

$seguimientos   = $model->listarTablaGeneral("*","seguimientos"," where id = '".$_GET['id_seguimiento']."' ");
 
$lista      = $model->listarTablaGeneral("id,nombres,periodistas","listas"," where  id = '".$seguimientos[0]['lista_id']."'  ");


$difusion   = $model->listarTablaGeneral("id,nombres","difusion"," where id = '".$seguimientos[0]['difusion_id']."' ");
$clientes   = $model->listarTablaGeneral("nombres","clientes"," where id = '".$seguimientos[0]['cliente_id']."' ");
$boletin   = $model->listarTablaGeneral("nombres","boletin"," where id = '".$seguimientos[0]['boletin_id']."' ");

// sql detalle seguimientos
$periodistas = $model->listarTablaGeneral("*","seguimiento_detalles"," where seguimiento_id = '".$seguimientos[0]['id']."' ");  
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css tables -->
    <link href="table.css" rel="stylesheet" type="text/css" />
    <title>Intranet Periodistas | Pacific Latam</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- css tables -->
    <link href="table.css" rel="stylesheet" type="text/css" />
    <!--Google Font-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <style type="text/css">
    .dynamic-file{float: left;}
    .desactivar{  opacity: 0.7;}
    .fila td{background-color: #E1E1E1}
    </style>
    <?php $xajax->printJavascript("xajax/"); ?>
   </head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
      
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <?php include('include/header.php');?>
            <!-- end navbar-header -->
        </nav>
        <!-- end navbar top -->


       <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <?php include('include/menu-left.php');?>   
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->

        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                 <!--  page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Editar Seguimiento</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_editarSeguimiento(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="seguimientos.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="query" id="query" value="1" /> 
                        <input type="hidden" name="cantPeriodistas" id="cantPeriodistas" value="<?php echo count($periodistas);?>" />
                        <input type="hidden" name="HddID" id="HddID" value="<?php echo $_GET['id_seguimiento'];?>" /> 
                        <input type="hidden" name="HddDifusion" id="HddDifusion" value="<?php echo $difusion[0]['id'];?>" /> 

                        <div class="row show-grid">
    
                            <div class="col-md-4">
                                Cliente: <br />
                                 <b><?php echo strtoupper(utf8_encode($clientes[0]['nombres']));?></b>
                            </div>

                            <div class="col-md-4">
                                Lista <br />
                                <b><?php echo strtoupper(utf8_encode($lista[0]['nombres']));?></b>
                            </div>
                            
                            <div class="col-md-4">
                                Tipo de Difusión <br />
                                <b><?php echo strtoupper(utf8_encode($difusion[0]['nombres']));?></b>  
                            </div>  

                            <div class="col-md-4" >
                                Nombre del documento :<br />
                                <b><?php echo strtoupper(utf8_encode($boletin[0]['nombres']));?></b>
                            </div>


                            <div class="col-md-4" style="width:100%;text-align: left;">
                                  <h4>Detalle del Seguimiento</h4>
                            </div>

                            <div class="col-md-4" style="width:100%;text-align: left;">
                                <div id="HTML_Periodistas">
                                    <?php 

                                        if( $difusion[0]['id'] =='1'){

                                        // ---------------------- NOTA DE PRENSA

                                        $html .= '<table border="0" width="100%" cellpadding="2" cellspacing="2">
                                                    <tr>
                                                        <td style="background-color: #E1E1E1;font-weight: bold;" rowspan="2" align="center">Nombres y Apellidos</td>
                                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center">Confirmacion de Asistencia x <br>Periodista</td>
                                                        <td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Observaciones</td>
                                                        </tr>
                                                        <tr>
                                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center">Se publicara?</td>
                                                    </tr>';

                                        for($x=0;$x<count($periodistas);$x++){  

                                          $nombresPeriodistas  = $model->listarTablaGeneral("nombres,apellidos","periodistas"," where id = '".$periodistas[$x]['periodista_id']."' ");

                                          $checked_SI = '';
                                          if($periodistas[$x]["publicara"]=='S'){
                                            $checked_SI = 'checked';
                                          } 

                                          $checked_NO = '';
                                          if($periodistas[$x]["publicara"]=='N'){
                                            $checked_NO = 'checked';
                                          }

                                          $html .= '<tr>
                                                        <td><input type="hidden" id="idSeguimiento'.$x.'" name="idSeguimiento'.$x.'" value="'.$periodistas[$x]["id"].'" />'.$$nombresPeriodistas[0]["nombres"].' '.$nombresPeriodistas[0]["apellidos"].'</td>
                                                        <td align="center"><input type="radio" '.$checked_SI.'  name="publicara_'.$x.'"  id="publicara_'.$x.'" value="SI" /> SI</td>
                                                        <td  align="center"><input type="radio" '.$checked_NO.' name="publicara_'.$x.'"  id="publicara_'.$x.'" value="NO" /> NO</td>
                                                        <td align="center"><input type="text" name="observaciones_'.$x.'" value="'.$periodistas[$x]["publicara_obs"].'" id="observaciones_'.$x.'"></td>
                                                        </tr>';                         
                                        } // END FOR
                                       
                                        $html  .= '</table>';       



                                        }else{      
                                        // ---------------------- INVITACION        
                                        $html .= '<table border="0" width="100%" cellpadding="2" cellspacing="2">
                                        <tr>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" rowspan="2" align="center">Nombres y Apellidos</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="3" align="center">Confirmacion de Asistencia x <br>Periodista</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Observaciones</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center" valign="middle" abbr="">Confirmacion de Asistencia  <br>dia evento</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">TIER (1:3)</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" align="center" valign="middle" rowspan="2">Comentarios</td>
                                        </tr>
                                        <tr>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="3" align="center">Confirmo periodista?</td>
                                        <td style="background-color: #E1E1E1;font-weight: bold;" colspan="2" align="center" valign="middle" abbr="">Asistio?</td>
                                        </tr>';

                                        for($i=0;$i<count($periodistas);$i++){  


                                        $nombresPeriodistas  = $model->listarTablaGeneral("nombres,apellidos","periodistas"," where id = '".$periodistas[$i]['periodista_id']."' ");

                                          $confirmo_SI = '';
                                          if($periodistas[$i]["confirmo"]=='S'){ $confirmo_SI = 'checked'; }
                                           
                                          $confirmo_NO = '';
                                          if($periodistas[$i]["confirmo"]=='N'){ $confirmo_NO = 'checked'; }  

                                          $confirmo_TALVEz = '';
                                          if($periodistas[$i]["confirmo"]=='T'){ $confirmo_TALVEz = 'checked'; }

                                          $asistio_SI = '';
                                          if($periodistas[$i]["asistio"]=='S'){ $asistio_SI = 'checked'; }

                                          $asistio_NO = '';
                                          if($periodistas[$i]["asistio"]=='N'){ $asistio_NO = 'checked'; }                                          

                                          $tier1 = '';
                                          $tier2 = '';
                                          $tier3 = '';
                                          if($periodistas[$i]["tier"]==1){
                                            $tier1 = 'selected';
                                          }else if($periodistas[$i]["tier"]==2){
                                            $tier2 = 'selected';
                                          }else if($periodistas[$i]["tier"]==3){
                                            $tier3 = 'selected';

                                          }
                 


                                        $html .= '<tr>
                                                    <td><input type="hidden" id="idSeguimiento'.$i.'" name="idSeguimiento'.$i.'" value="'.$periodistas[$i]["id"].'" />'.utf8_encode($nombresPeriodistas[0]["nombres"]).' '.utf8_encode($nombresPeriodistas[0]["apellidos"]).'</td>
                                                    <td align="center"><input type="radio"  '.$confirmo_SI.' name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="S"> SI</td>
                                                    <td align="center"><input type="radio"  '.$confirmo_NO.' name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="N">NO</td>
                                                    <td  align="center"><input type="radio" '.$confirmo_TALVEz.' name="confirmo_'.$i.'" id="confirmo_'.$i.'" value="T">Tal vez</td>
                                                    <td align="center"><input type="text"  name="observaciones_'.$i.'" value="'.$periodistas[$i]["observacion"].'" id="observaciones_'.$i.'"></td>
                                                    <td align="center"><input type="radio" name="asistio_'.$i.'" '.$asistio_SI.' id="asistio_'.$i.'" value="S" /> SI</td>
                                                    <td align="center"><input type="radio" name="asistio_'.$i.'" '.$asistio_NO.' id="asistio_'.$i.'" value="N" /> NO</td>
                                                    <td align="center">
                                                    <select name="tier_'.$i.'" id="tier_'.$i.'">
                                                    <option '.$tier1.' value="1">1</option>
                                                    <option '.$tier2.' value="2">2</option>
                                                    <option '.$tier3.' value="3">3</option>
                                                    </select>
                                                    </td>
                                                    <td align="center"><input type="text" name="comentarios_'.$i.'" value="'.$periodistas[$i]["comentario"].'" id="comentarios_'.$x.'"></td>
                                                    </tr>';                         
                                        } // END FOR
                                        $html  .= '</table>'; 


                                      }
                                      
                                      echo $html;  
                                    ?>
                                </div>
                            </div>    

                        </div>
                          
                        <div class="form-group">
                        <button type="button" onclick="xajax_editarSeguimiento(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar</button>
                        <br >

                        </div>
                    </form>
                    </div>    
        </div>
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
   <!-- Calendar-->
    <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $(function() {
             $('#fecha_desde').datepicker({format: "yyyy-mm-dd"    });          
             $('#fecha_hasta').datepicker({format: "yyyy-mm-dd"    });                      
        });    
      </script>  

</body>

</html>
