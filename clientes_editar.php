<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/clientes.process.php');
$model     = new funcionesModel();
$Clientes     = $model->listarTablaGeneral(" id,nombres,imagen ","clientes"," where id  = '".$_GET['id']."'  ");
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
                    <h1 class="page-header">Editar Cliente</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <?php if($_SESSION['sTipoUsuario']==1){?>     
                        <div class="nuev"><a href="#" onclick="xajax_editarClientes(xajax.getFormValues('form_editar'));"><img src="images/guar.png"> Guardar</a></div>
                        <?php }// opciones ?>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="clientes.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_editar" name="form_editar" method="post" enctype="multipart/form-data">
                         <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id'];?>" /> 
                         <input type="hidden" name="query" id="query" value="2" /> 

                         <div class="row show-grid">                           
                             <div class="col-md-4" style="width: 60%;">
                                Nombre <br />
                                <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $Clientes[0]['nombres'];?>" />
                             </div>
                             <div class="col-md-4">
                                Logo: <br />
                                <input type="file" id="foto" name="foto" /><br ><small>150px - 150px , JPG</small>
                                <img width="80" src="images/clientes/<?php echo $Clientes[0]["imagen"]?>" />
                            </div>
                         </div>   

                        <?php if($_SESSION['sTipoUsuario']==1){?>
                        <div class="form-group"><br>
                        <button type="button" onclick="xajax_editarClientes(xajax.getFormValues('form_editar'));" class="btn1 btn-primary">Enviar</button>
                        </div>
                        <?php }// opciones ?>
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
  

</body>

</html>
