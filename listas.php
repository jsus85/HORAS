<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/listas.process.php');
$model       = new funcionesModel();

$clientes_control  = $_REQUEST['clientes'];
$nombres           = $_REQUEST['nombres'];
$lista             = $model->datosListas($clientes_control,$nombres,'0');
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
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
                    <h1 class="page-header">Listas</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form action="listas.php" id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
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
                             Nombre: <input type="text" id="nombres" value="<?php echo $nombres;?>" name="nombres"><img src="images/busc.png">

                        </div>

                        <!-- Opciones -->
                                                <div class="opci" style="width:20%">
                        <?php
                             if($_SESSION['sTipoUsuario']==1){
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 if(in_array(2, $extraer_permisos)){
                        ?>




                        
                        <!--<div class="nuev"><a href="medios_nuevo.php"><img src="images/nuev.png"> Nuevo</a></div>-->
                        <div class="elim"><a href="#" onclick="if(confirm('&iquest;Esta seguro de eliminar registro(s)?')) borrar_lista();" ><img src="images/elim.png"> Eliminar</a></div>
                        
                        
                        <?php       }
                                }
                        ?>

                            <div style="clear:both;padding-top:10px;">
                            <a href="#" title="Exportar a EXCEL" onclick="imprimir();" style="color:#FFF"><img height="25" src="assets/img/exc.png" /></a>&nbsp;&nbsp;
                            <a href="#" title="Exportar a PDF" onclick="imprimirPDF();" style="color:#FFF"><img height="25" src="images/pdf.png" /></a>
                            </div>

                        </div>
                        <!-- End Opciones -->


                    </div>
                </div>

                        
               
                 <div class="box">
                              
                 <div class="box-body table-responsive">
                                    
                    <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th><input type="checkbox" id="selecctall" name="selecctall" /></th>
                        <th>NOMBRES</th>
                        <th>CLIENTES</th>
                        <th>NUM. PERIODISTAS</th>
                        <th>FECHA REGISTRO</th>
                        <th>USUARIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php 
            $arrai_periodistas = "";    
            for($i=0;$i<count($lista);$i++){

                $arrai_periodistas =  explode(",", $lista[$i]["periodistas"]);
                $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");
                $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");

?>
                    <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                        <td><input type="checkbox" class="checkbox1" id="idActividad" name="idActividad" value="<?php echo $lista[$i]["id"];?>" /></td>
                        <td><a title="Editar lista" href="listas_editar.php?id=<?php echo $lista[$i]["id"];?>"><?php echo utf8_encode($lista[$i]["nombres"]);?></a></td>
                        <td><?php echo ($data1[0]["nombres"]);?></td>
                        <td><?php echo count($arrai_periodistas);?></td>
                        <td><?php echo ($lista[$i]["fecha_registro"]);?></td>
                        <td><?php echo utf8_encode($data2[0]["nombres"]);?></td>
                        
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
        <!-- page script -->
        <script type="text/javascript">
            
                 // exportar excel
         function imprimir(){     

            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));

            document.form_buscar.target='_blank';
            document.form_buscar.action = 'xls-listas.php';
            document.form_buscar.submit();
        }

          function imprimirPDF(){

                        $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'pdf_listas.php';
            document.form_buscar.submit();
          }

            function borrar_lista(){
                xajax_deleteListas($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            }

            $(function() {
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
