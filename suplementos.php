<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/cargos.process.php');
$model       = new funcionesModel();

$nombres     = $_REQUEST['nombres'];
$lista       = $model->datosSuplementos($nombres);
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
                    <h1 class="page-header">Mantenimientos de Suplementos</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form action="suplementos.php" id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
                <div class="panel-heading">
                    <div class="form-group1">
                        <div class="ingr">
                         Suplementos <input type="text" id="nombres" value="<?php echo $nombres;?>" name="nombres"><img src="images/busc.png">

                        </div>
                       
                        <!-- Opciones nuevo editar-->
                        <?php if($_SESSION['sTipoUsuario']==1){?>     
                        <div class="opci" style="width:20%">
                        <div class="nuev"><a href="suplementos_nuevo.php"><img src="images/nuev.png"> Nuevo</a></div>
                        <div class="elim"><a href="#" onclick="if(confirm('&iquest;Esta seguro de eliminar registro(s)?')) xajax_deleteSuplementos(xajax.getFormValues('form_buscar'));" ><img src="images/elim.png"> Eliminar</a></div>
                        </div>
                        <?php 
                                }
                        ?> 

                    </div>
                </div>
               
                    
                                <div class="box">
                                    
                                <div class="box-body table-responsive">
                                    
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th><input type="checkbox" id="selecctall" name="selecctall"  /></th>
                                                <th>NOMBRES</th>
                                                <th>FECHA REGISTRO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                     <?php 
                                        for($i=0;$i<count($lista);$i++){
                                        ?>
                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            <td><input class="checkbox1" type="checkbox" id="idCargos[]" name="idCargos[]" value="<?php echo $lista[$i]["id"];?>" /></td>
                                            <!--<td><a title="Editar Cargos" href="EditarCargos-<?php echo $lista[$i]["id"];?>.html"><?php echo utf8_encode($lista[$i]["nombres"]);?></a></td>-->
                                            <td><a title="Editar Cargos" href="suplementos_editar.php?id=<?php echo $lista[$i]["id"];?>.html"><?php echo utf8_encode($lista[$i]["nombres"]);?></a></td>
                                            
        
                                            <td><?php echo utf8_encode($lista[$i]["fecha"]);?></td>
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                             <th><input type="checkbox"  id="selecctall" name="selecctall"  /></th>
                                             <th>NOMBRES</th>
                                                <th>FECHA REGISTRO</th>                                          
                                            </tr>
                                        </tfoot>
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
