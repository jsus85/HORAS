<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/reporte.process.php');
$model       = new funcionesModel();

$fecha             = $_REQUEST['fecha'];
$fecha2             = $_REQUEST['fecha2'];
$clientes_control  = $_REQUEST['clientes'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];
$lista_control     = $_REQUEST['Lista'];
$nombres_periodista     = $_REQUEST['nombres_periodista'];
$lista             = $model->datosReporte($clientes_control,$difusion_control,$lista_control,$nombres,$fecha,$fecha2);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");

    if($nombres_periodista !=''){      $campPeriodista      = " and MATCH (nombres, apellidos)      AGAINST ('".$nombres_periodista."' IN BOOLEAN MODE) ";  }

  $id_periodistas = ''; 
  for($xx=0;$xx<count($lista);$xx++){

           $periodistas      = $model->listarTablaGeneral("periodistas","listas"," where id = '".$lista[$xx]["lista_id"]."' ");

           $id_periodistas .=  ",".$periodistas[0]['periodistas'];
   } 

    $arrai_periodistas = explode("," ,substr($id_periodistas,1));
    $resultado = array_unique($arrai_periodistas);

    $idperiodistas_sinrepetir = implode(",", $resultado);


    $lista_periodistas       = $model->listarTablaGeneral("nombres,apellidos,id","periodistas"," where id in (".$idperiodistas_sinrepetir.") ".$campPeriodista);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css tables -->
    <link href="table.css" rel="stylesheet" type="text/css" />
    <title>Intranet Periodistas | Pacific Latam</title>
    <!-- Core CSS - Include with every page -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek,cyrillic' rel='stylesheet' type='text/css'>    
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <style type="text/css">
    td{text-align: center;}
    </style>
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- css tables -->
     <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
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
                    <h1 class="page-header">REPORTE</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form action="reporte.php" id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
              <input type="hidden" name="HddidActividad" id="HddidActividad" value="0" />
                <div class="panel-heading">
                    <div class="form-group1">
                        <div class="ingr">

                        Clientes:                        
                            <select id="clientes"  name="clientes" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($clientes);$i++){?>
                                    <option <?php if($clientes_control==$clientes[$i]["id"]){?>selected<?php }?> value="<?php echo $clientes[$i]["id"];?>"><?php echo utf8_encode($clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                            &nbsp;&nbsp;&nbsp;
                            <!--
                            onchange="xajax_mostrarListas(this.value);"
                         Lista:

                        <span id="HTML_LISTAS">  
                         <select id="Lista" name="Lista">
                            <option value="0">[seleccionar]</option>
                         </select>
                         </span>-->   

                                &nbsp;&nbsp;&nbsp;
                        Difusión:      
                             <select id="difusion"  name="difusion" onchange="show_columnas(this.value);" class="select1">
                                    <option value="0">[Todos]</option>
                                    
                                    <?php for($w=0;$w<count($difusion);$w++){?>
                                    <option <?php if($difusion_control == $difusion[$w]["id"]){?>selected<?php }?> value="<?php echo $difusion[$w]["id"];?>"><?php echo utf8_encode($difusion[$w]["nombres"]);?></option>   

                                    <?php $difusion2  = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = '".$difusion[$w]["id"]."' order by nombres asc ");
                                    ?>
                                    
                                    <?php for($m=0;$m<count($difusion2);$m++){?>
                                    <option <?php if($difusion_control == $difusion2[$m]["id"]){?>selected<?php }?> value="<?php echo $difusion2[$m]["id"];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo utf8_encode($difusion2[$m]["nombres"]);?></option>  
                                    <?php 
                                            }// #2 FOR

                                        }// #1 FOR
                                     ?>
                            </select>

                          &nbsp;&nbsp;&nbsp;  
                          Documento: <input type="text" id="nombres" value="<?php echo $nombres;?>"  name="nombres" />   

                           &nbsp;&nbsp;&nbsp;  
                          Periodista: <input type="text" id="nombres_periodista" value="<?php echo $nombres_periodista;?>"  name="nombres_periodista" />


                          <div style="clear:both;padding-top:10px;padding-bottom:10px">  
                      
                          Fecha desde: <input type="text" id="fecha" value="<?php echo $fecha;?>" style="width: 70px;" name="fecha" /> Hasta  <input type="text" id="fecha2" value="<?php echo $fecha2;?>" style="width: 70px;" name="fecha2" /> 


                          &nbsp;&nbsp;&nbsp;
                          <button title="Buscar Actividad del Periodista" onclick= "buscar();" class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>

                      </div>
                          <div style="clear:both">
                               <a href="#" title="Exportar a EXCEL" onclick="imprimir();" style="color:#FFF"><img height="25" src="assets/img/exc.png" /></a>&nbsp;&nbsp;
                               <a href="#" title="Exportar a PDF" onclick="imprimirPDF();" style="color:#FFF"><img height="25" src="images/pdf.png" /></a>
                          </div>

                        </div>

          


                    </div>
                </div>
               
                    <div class="form-group1">
                         <div style="clear:both">
                            <input type="checkbox" checked="checked" value="1" id="CHKSiConfirmo" name="CHKSiConfirmo"  /> &nbsp; Si Confirmo  |
                            <input type="checkbox" checked="checked" value ="1" id="CHKNoConfirmo" name="CHKNoConfirmo"  />&nbsp; No Confirmo |
                            <input type="checkbox" checked="checked" value= "1" id="CHKTalvez" name="CHKTalvez"  />&nbsp; Tal Vez Confirmo |

                            <input type="checkbox" checked="checked" value="1" id="CHKSiAsistio" name="CHKSiAsistio"  /> &nbsp; Si Asistio   |
                            <input type="checkbox" checked="checked" value="1" id="CHKNoAsistio" name="CHKNoAsistio"  /> &nbsp; No Asistio  |

                            <input type="checkbox" checked="checked" value="1" id="CHKSiPublico" name="CHKSiPublico"  /> &nbsp; Si Publico  |
                            <input type="checkbox" checked="checked" value="1" id="CHKNoPublico" name="CHKNoPublico"  />&nbsp; No Publicado   |


                        </div>                       
                    </div>
                                <div class="box">
                                    
                                <div class="box-body table-responsive">
                                    
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th><input type="checkbox" id="selecctall" name="selecctall" /></th>
                                            <th>PERIODISTA</th>
                                            <th>CONFIRMADOS</th>
                                            <th>NO CONFIRMADOS</th>
                                            <th>TALVEZ CONFIRMADOS</th>

                                            <th>ASISTIDOS</th>
                                            <th>NO ASISTIDOS</th>
                                            
                                            <th>PUBLICADOS</th>
                                            <th>NO PUBLICADOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
<?php 

/*
SELECT count(*)
                 from 
                            seguimientos s , boletin b  , seguimiento_detalles sd 
                where 
                            s.boletin_id = b.id and sd.confirmo = 'S' and b.nombres like '%Prueba 2%' 
                            and sd.periodista_id='1457' 

*/
                                  
for($i=0;$i<count($lista_periodistas);$i++){

  $confirmo_si = $model->listarTablaGeneral(" count(*) as siconfirmo ","seguimiento_detalles","where confirmo = 'S'  and periodista_id='".$lista_periodistas[$i]["id"]."'");// 

  $confirmo_no = $model->listarTablaGeneral(" count(*) as noconfirmo ","seguimiento_detalles","where confirmo = 'N'  and periodista_id='".$lista_periodistas[$i]["id"]."'"); 

  $confirmo_talvez = $model->listarTablaGeneral(" count(*) as talvez ","seguimiento_detalles","where confirmo = 'T'  and periodista_id='".$lista_periodistas[$i]["id"]."'"); 


  $asistio_si = $model->listarTablaGeneral(" count(*) as siasistio ","seguimiento_detalles","where asistio = 'S'  and periodista_id='".$lista_periodistas[$i]["id"]."'");
  $asistio_no = $model->listarTablaGeneral(" count(*) as noasistio ","seguimiento_detalles","where asistio = 'N'  and periodista_id='".$lista_periodistas[$i]["id"]."'"); 


  $publicara_si = $model->listarTablaGeneral(" count(*) as sipublicara ","seguimiento_detalles","where publicara = 'S'  and periodista_id='".$lista_periodistas[$i]["id"]."'");
  $publicara_no = $model->listarTablaGeneral(" count(*) as nopublicara ","seguimiento_detalles","where publicara = 'N'  and periodista_id='".$lista_periodistas[$i]["id"]."'");

?>

                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">

                                            <td><input class="checkbox1" type="checkbox" id="idActividad" name="idActividad" value="<?php echo $lista_periodistas[$i]["id"];?>" /></td>
                                            <td style="text-align:left"><?php echo utf8_encode($lista_periodistas[$i]["nombres"])." ".utf8_encode($lista_periodistas[$i]["apellidos"]);?></td>
                                            <td><?php echo $confirmo_si[0]['siconfirmo'];?></td>
                                            <td><?php echo $confirmo_no[0]['noconfirmo'];?></td>
                                            <td><?php echo $confirmo_talvez[0]['talvez'];?></td>

                                            <td><?php echo $asistio_si[0]['siasistio'];?></td>
                                            <td><?php echo $asistio_no[0]['noasistio'];?></td>
                                            
                                            <td><?php echo $publicara_si[0]['sipublicara'];?></td>
                                            <td><?php echo $publicara_no[0]['nopublicara'];?></td>
                                            
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
                                    </table>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
        <!-- DATA TABES SCRIPT -->
        <script src="assets/plugins/dataTables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js" type="text/javascript"></script>
         <!-- Calendar-->
        <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>
        <!-- page script -->
        <script type="text/javascript">

          // Mostrar columnas para difusion: invitaicon && Nota de prensa
          function show_columnas(data){
                if(data == 1){
                     $('#example2 th:eq(7)').show();$('#example2 td:nth-child(8)').show();                                          
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();

                     $('#example2 th:eq(2)').hide();$('#example2 td:nth-child(3)').hide();
                     $('#example2 th:eq(3)').hide();$('#example2 td:nth-child(4)').hide();
                     $('#example2 th:eq(4)').hide();$('#example2 td:nth-child(5)').hide();
                     $('#example2 th:eq(5)').hide();$('#example2 td:nth-child(6)').hide();  
                     $('#example2 th:eq(6)').hide();$('#example2 td:nth-child(7)').hide();                     
                     $('#example2 th:eq(8)').hide();$('#example2 td:nth-child(9)').hide();

                }else if(data == 0){

                     $('#example2 th:eq(2)').show();$('#example2 td:nth-child(3)').show();
                     $('#example2 th:eq(3)').show();$('#example2 td:nth-child(4)').show();
                     $('#example2 th:eq(4)').show();$('#example2 td:nth-child(5)').show();
                     $('#example2 th:eq(5)').show();$('#example2 td:nth-child(6)').show();  
                     $('#example2 th:eq(6)').show();$('#example2 td:nth-child(7)').show();                     
                     $('#example2 th:eq(7)').show();$('#example2 td:nth-child(8)').show();                                          
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();
               }else{

                     $('#example2 th:eq(2)').show();$('#example2 td:nth-child(3)').show();
                     $('#example2 th:eq(3)').show();$('#example2 td:nth-child(4)').show();
                     $('#example2 th:eq(4)').show();$('#example2 td:nth-child(5)').show();
                     $('#example2 th:eq(5)').show();$('#example2 td:nth-child(6)').show();  
                     $('#example2 th:eq(6)').show();$('#example2 td:nth-child(7)').show();                     
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();

                     $('#example2 th:eq(7)').hide();$('#example2 td:nth-child(8)').hide();                                          
                     $('#example2 th:eq(8)').hide();$('#example2 td:nth-child(9)').hide();
                }
          }


          // para hacer la busqueda
          function buscar(){

            document.form_buscar.target='_self';
            document.form_buscar.action = 'reporte.php';
            document.form_buscar.submit();
          
          }


          function imprimirPDF(){

            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'pdf_imprimir_seguimiento.php';
            document.form_buscar.submit();
          }

         function imprimir(){

            var client     = document.getElementById('clientes').value;   
            var nombres        = document.getElementById('nombres').value;
 
            var difusion          = document.getElementById('difusion').value;   
   
            var fech        = document.getElementById('fecha').value;   
            var clientes       = document.getElementById('clientes').value;   
             $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'xlxs-seguimientos.php';
            document.form_buscar.submit();
        }



         // ----- ocultar columnas de la tabla -----
            $( "#CHKSiConfirmo" ).click(function() {
                if($('#CHKSiConfirmo').is(':checked')){
                     $('#example2 th:eq(2)').show();$('#example2 td:nth-child(3)').show();
                 } else{
                     $('#example2 th:eq(2)').hide();$('#example2 td:nth-child(3)').hide();
                 }
            });

            $( "#CHKNoConfirmo" ).click(function() {
                if($('#CHKNoConfirmo').is(':checked')){
                     $('#example2 th:eq(3)').show();$('#example2 td:nth-child(4)').show();
                 } else{
                     $('#example2 th:eq(3)').hide();$('#example2 td:nth-child(4)').hide();
                 }
            });

          $( "#CHKTalvez" ).click(function() {
                if($('#CHKTalvez').is(':checked')){
                     $('#example2 th:eq(4)').show();$('#example2 td:nth-child(5)').show();
                 } else{
                     $('#example2 th:eq(4)').hide();$('#example2 td:nth-child(5)').hide();
                 }
            });


             $( "#CHKSiAsistio" ).click(function() {
                if($('#CHKSiAsistio').is(':checked')){
                     $('#example2 th:eq(5)').show();$('#example2 td:nth-child(6)').show();
                 } else{
                     $('#example2 th:eq(5)').hide();$('#example2 td:nth-child(6)').hide();
                 }
            });


              $( "#CHKNoAsistio" ).click(function() {
                if($('#CHKNoAsistio').is(':checked')){
                     $('#example2 th:eq(6)').show();$('#example2 td:nth-child(7)').show();
                 } else{
                     $('#example2 th:eq(6)').hide();$('#example2 td:nth-child(7)').hide();
                 }
            });

             $( "#CHKSiPublico" ).click(function() {
                if($('#CHKSiPublico').is(':checked')){
                     $('#example2 th:eq(7)').show();$('#example2 td:nth-child(8)').show();
                 } else{
                     $('#example2 th:eq(7)').hide();$('#example2 td:nth-child(8)').hide();
                 }
            });


              $( "#CHKNoPublico" ).click(function() {
                if($('#CHKNoPublico').is(':checked')){
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();
                 } else{
                     $('#example2 th:eq(8)').hide();$('#example2 td:nth-child(9)').hide();
                 }
            });

            // ----- ocultar columnas de la tabla -----

            $(function() {

                <?php if($lista_control !=0){ 
                ?>
                    xajax_mostrarListas('<?php echo $clientes_control;?>','<?php echo $lista_control;?>');
                <?php }?>

                $('#fecha').datepicker({format: "yyyy-mm-dd"});  
                 $('#fecha2').datepicker({format: "yyyy-mm-dd"}); 
                $('#example2').dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": true
                });
            });
        </script>
</body>

</html>
