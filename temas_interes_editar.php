<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/temasinteres.process.php');
$model            = new funcionesModel();
$TemaInteresPadre = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres");
$TemaInteres      = $model->listarTablaGeneral("id,nombres,parent","tema_interes"," where id = '".mysql_real_escape_string($_GET['id'])."' ");
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
                    <h1 class="page-header">Editar Tema de Interes</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                         <!-- Opciones nuevo editar-->
                        <?php if($_SESSION['sTipoUsuario']==1){?>                              
                        <div class="nuev"><a href="#" onclick="xajax_editarTemaInteres(xajax.getFormValues('form_editar'));"><img src="images/guar.png"> Guardar</a></div>
                        <?php }?>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="temas_interes.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_editar" name="form_editar" method="post">
                        
                        <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id'];?>" /> 
                        <div class="form-group"><label>Principal</label></div>
                        <div class=""><select id="tema_interes"  name="tema_interes" class="form-control">
                                    <option value="0">[Principal]</option>
                                    <?php for($i=0;$i<count($TemaInteresPadre);$i++){?>
                                    <option <?php if($TemaInteres[0]['parent']==$TemaInteresPadre[$i]["id"]){?> selected <?php }?>  value="<?php echo $TemaInteresPadre[$i]["id"];?>"><?php echo utf8_encode($TemaInteresPadre[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select></div>

                        <div class="form-group"><label>Nombre :</label></div>
                        <div class=""><input type="text" id="nombres" name="nombres" value="<?php echo utf8_encode($TemaInteres[0]['nombres']);?>" class="form-control" value=""></div>
                        
                       <div class="form-group"><br>
                        <?php if($_SESSION['sTipoUsuario']==1){?> 
                        <button type="button" onclick="xajax_editarTemaInteres(xajax.getFormValues('form_editar'));" class="btn1 btn-primary">Enviar</button>
                      <?php }?>
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
  

</body>

</html>