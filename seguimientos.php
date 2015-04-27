<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include('controllers/seguimiento.process.php');
$model       = new funcionesModel();

$fecha             = $_REQUEST['fecha'];
$fecha2            = $_REQUEST['fecha2'];
$clientes_control  = $_REQUEST['clientes'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];

$lista             = $model->datosSeguimientos($clientes_control,$difusion_control,$lista_control,$fecha,$fecha2,'0');
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$cobertura         = array_cobertura();
$periocidad        = array_periocidad();
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
                    <h1 class="page-header">Seguimientos</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form action="seguimientos.php" id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
              <input type="hidden" name="HddidActividad" id="HddidActividad" value="0" />
                <div class="panel-heading">
                    <div class="form-group1">
                        <div class="ingr">

                        Clientes:                        
                            <select id="clientes" onchange="document.form_buscar.submit();" name="clientes" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($clientes);$i++){?>
                                    <option <?php if($clientes_control==$clientes[$i]["id"]){?>selected<?php }?> value="<?php echo $clientes[$i]["id"];?>"><?php echo utf8_encode($clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                                &nbsp;&nbsp;&nbsp;
                             Difusión:      
                             <select id="difusion" name="difusion" class="select1">
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
                          Fecha desde: <input type="text" id="fecha" value="<?php echo $fecha;?>" style="width: 70px;" name="fecha" /> Hasta <input type="text" id="fecha2" value="<?php echo $fecha2;?>" style="width: 70px;" name="fecha2" />   
                          &nbsp;&nbsp;&nbsp;
                          <button title="Buscar Actividad del Periodista" class="btn btn-default" onclick= "buscar();" type="button">
                          <i class="fa fa-search"></i>
                          </button>

                          <div style="padding-top:5px">
                                <p>TOTAL DE REGISTROS: <b><?php echo count($lista);?></b> </p>
                          </div>


                        </div>

                        <!-- Opciones -->
                        <div class="opci" style="width:20%">
                        <?php
                            if($_SESSION['sTipoUsuario']==1){

                            $extraer_permisos = explode(",", $_SESSION['sPermisos']);

                            if(in_array(2, $extraer_permisos)){
                        ?>
                        
                        <div class="nuev"><a href="seguimiento_nuevo.php"><img src="images/nuev.png"> Nuevo</a></div>
                        <div class="elim"><a href="#" onclick="if(confirm('&iquest;Esta seguro de eliminar registro(s)?')) borrar_seguimiento();" ><img src="images/elim.png"> Eliminar</a></div>
                        
                        <?php       } // End If
                                }// End If
                        ?>

                            <div style="clear:both;padding-top:10px ">
                                <a href="#" title="Exportar a EXCEL" onclick="imprimir();" style="color:#FFF"><img height="25" src="assets/img/exc.png" /></a>&nbsp;&nbsp;
                                <a href="#" title="Exportar a PDF" onclick="imprimirPDF();" style="color:#FFF"><img height="25" src="images/pdf.png" /></a>
                            </div>

                        </div>
                        <!-- End Opciones -->


                    </div>
                </div>
               
                    <div class="form-group1">
                         <div style="clear:both">
                            <input type="checkbox" checked="checked" value="1" id="CHKCliente" name="CHKCliente"  /> &nbsp; Cliente |
                            <input type="checkbox" checked="checked" value ="1" id="CHKDifusion"   name="CHKDifusion"  />&nbsp; Difusion |
                            <input type="checkbox" checked="checked" value= "1" id="CHKLista"   name="CHKLista"  />&nbsp; Lista |

                            <input type="checkbox" checked="checked" value="1" id="CHKDocumento" name="CHKDocumento"  /> &nbsp; Documento  |

                            <input type="checkbox" checked="checked" value="1" id="CHKFecRegistro" name="CHKFecRegistro"  /> &nbsp; F. Registro  |

                            <input type="checkbox" checked="checked" value="1" id="CHKUsuario" name="CHKUsuario"  />&nbsp; Usuario   |

                        </div>                       
                    </div>

                                <div class="box">
                                    
                                <div class="box-body table-responsive">
                                    
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th><input type="checkbox" id="selecctall" name="selecctall" /></th>
                                            <th>CLIENTE</th>
                                            <th>DIFUSION</th>
                                            <th>LISTA</th>
                                            <th>DOCUMENTO</th>
                                            <th>F. REGISTRO</th>
                                            <th>USUARIO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                     <?php 
                                        $arrai_periodistas = "";    
                                        for($i=0;$i<count($lista);$i++){

                                       
                                        $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");// Cliente
                                        $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");// usuario
                                        $data3 = $model->listarTablaGeneral(" nombres ","listas","where id='".$lista[$i]["lista_id"]."'");//Lista
                                        $data4 = $model->listarTablaGeneral(" nombres ","difusion","where id='".$lista[$i]["difusion_id"]."'");//Lista
                                        $data5 = $model->listarTablaGeneral(" nombres ","boletin","where id='".$lista[$i]["boletin_id"]."'");//Lista

                                        ?>

                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            <td><input type="checkbox" class="checkbox1" id="idActividad" name="idActividad" value="<?php echo $lista[$i]["id"];?>" /></td>

                                            <td><a title="Editar Seguimiento" href="seguimiento_editar.php?id_seguimiento=<?php echo $lista[$i]["id"];?>"><?php echo utf8_encode($data1[0]["nombres"]);?></a></td>
                                            <td><?php echo utf8_encode($data4[0]["nombres"]);?></td>
                                            <td><?php echo utf8_encode($data3[0]["nombres"]);?></td>                                            

                                            <td><?php echo utf8_encode($data5[0]["nombres"]);;?></td>
                                            
                                            <td><?php echo ($lista[$i]["fecha_registro"]);?></td>
                                            <td><?php echo utf8_encode($data2[0]["nombres"]);;?></td>
                                            
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
    <script src="assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="assets//plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
     <!-- Calendar-->
    <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>
    <!-- page script -->
   

        <script type="text/javascript">

          function borrar_seguimiento(){
            xajax_deleteSeguimiento($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
          }

         // para hacer la busqueda
          function buscar(){
            document.form_buscar.target='_self';
            document.form_buscar.action = 'seguimientos.php';
            document.form_buscar.submit();
          
          }

         // exportar excel
         function imprimir(){     
            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'xls-reporte-seguimientos.php';
            document.form_buscar.submit();
        }

          function imprimirPDF(){
            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'pdf_seguimientos.php';
            document.form_buscar.submit();
          }

          // ----- ocultar columnas de la tabla -----
            $( "#CHKCliente" ).click(function() {
                if($('#CHKCliente').is(':checked')){
                     $('#example2 th:eq(1)').show();$('#example2 td:nth-child(2)').show();
                 } else{
                     $('#example2 th:eq(1)').hide();$('#example2 td:nth-child(2)').hide();
                 }
            });

            $( "#CHKDifusion" ).click(function() {
                if($('#CHKDifusion').is(':checked')){
                     $('#example2 th:eq(2)').show(); $('#example2 td:nth-child(3)').show();
                 } else{
                     $('#example2 th:eq(2)').hide(); $('#example2 td:nth-child(3)').hide();
                 }
            });

            $( "#CHKLista" ).click(function() {
                if($('#CHKLista').is(':checked')){
                     $('#example2 th:eq(3)').show(); $('#example2 td:nth-child(4)').show();
                 } else{
                     $('#example2 th:eq(3)').hide(); $('#example2 td:nth-child(4)').hide();
                 }
            });

            $( "#CHKDocumento" ).click(function() {
                if($('#CHKDocumento').is(':checked')){
                     $('#example2 th:eq(4)').show(); $('#example2 td:nth-child(5)').show();
                 } else{
                     $('#example2 th:eq(4)').hide(); $('#example2 td:nth-child(5)').hide();
                 }
            });


            $( "#CHKFecRegistro" ).click(function() {
                if($('#CHKFecRegistro').is(':checked')){
                     $('#example2 th:eq(5)').show(); $('#example2 td:nth-child(6)').show();
                 } else{
                     $('#example2 th:eq(5)').hide(); $('#example2 td:nth-child(6)').hide();
                 }
            });


            $( "#CHKUsuario" ).click(function() {
                if($('#CHKUsuario').is(':checked')){
                     $('#example2 th:eq(6)').show(); $('#example2 td:nth-child(7)').show();
                 } else{
                     $('#example2 th:eq(6)').hide(); $('#example2 td:nth-child(7)').hide();
                 }
            });
            // ----- ocultar columnas de la tabla -----

            $(function() {

                $('#fecha').datepicker({format: "yyyy-mm-dd" });  
                $('#fecha2').datepicker({format: "yyyy-mm-dd"});    

                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": true
                });
            });
        </script>
</body>

</html>
