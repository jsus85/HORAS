<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/secciones.process.php');
$model            = new funcionesModel();
$TipoMedio        = $model->listarTablaGeneral("id,nombres","tipo_medios"," where estado = 1 order by nombres asc");
$Secciones        = $model->listarTablaGeneral("id,nombres,suplemento,medios_id","secciones"," where id = '".($_GET['id'])."' ");
$tipoMedio        = $model->listarTablaGeneral(" tipo_medios_id ","medios"," where id = '".$Secciones[0]['medios_id']."' ");

$suplemento      = array_suplemento();
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
       <style type="text/css">
    #medios_1{ width: 100%;    }
    </style>
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

                    <h1 class="page-header">Editar Sección</h1>

                </div>

                 <!-- end  page header -->

            </div>

            <div class="row">

                <div class="panel-heading">

                    <div class="form-group1">

                        

                        <div class="opci">
                        <!-- Opciones nuevo editar-->
                        <?php if($_SESSION['sTipoUsuario']==1){?>         
                        <div class="nuev"><a href="#" onclick="xajax_editarSecciones(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <?php }// ?>    
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->

                        <div class="elim"><a href="secciones.php"><img src="images/cerr.png"> Cerrar</a></div>

                        </div> 



                    </div>

                    <div class="conte">

                    <form id="form_nuevo" name="form_nuevo" method="post">

                        <input type="hidden" id="HDDID" name="HDDID" value="<?php echo $_GET['id'];?>" /> 



                       <div class="form-group"><label>Medios :</label></div>

                       <div class="">

                         <select id="medios" style="width:100%"  name="medios"  >

                                    <option value="0">[Todos]</option>

                                    <?php
                                     for($x=0;$x<count($TipoMedio);$x++){?>
                                    <option <?php if($tipoMedio[0]['tipo_medios_id']==$TipoMedio[$x]["id"]){?>selected<?php }?> value="<?php echo $TipoMedio[$x]["id"];?>"><b><?php echo  strtoupper(utf8_encode($TipoMedio[$x]["nombres"]));?></b></option>

                               <?php }// End For 2?>                                    

                        </select></div>                        


                            <div class="form-group"><label>Medio :</label></div>
                            <div class="">
                            <span id="HTMLMEDIOS_1">
                            <select id="medios_1"  name="medios_1" style="width:100%">
                            <option value="0">[Todos]</option>
                            </select>
                            </span>
                            </div>


                        <div class="form-group"><label>Nombre :</label></div>

                        <div class=""><input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo utf8_encode($Secciones[0]['nombres']);?>" /></div>

                        

                        <div class="form-group"><label>Suplemento :</label></div>

                        <div class="">
                        <select id="suplemento" style="width:100%;height:auto" name="suplemento" onchange="document.form_buscar.submit();" class="select1">
                                    <option value='0'>Seleccionar</option>
                                    <?php foreach ($suplemento as $key => $value) {                             ?>
                                    <option  <?php if($Secciones[0]['suplemento']==$key){?>selected<?php }?> value='<?php echo $key;?>'><?php echo $value;?></option>
                                    <?php } ?>
                                </select>
                        </div>




                        <div class="form-group"><br>
                         <!-- Opciones nuevo editar-->
                        <?php if($_SESSION['sTipoUsuario']==1){?>      
                        <button type="button" onclick="xajax_editarSecciones(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Enviar</button>
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

          <script type="text/javascript">

            $(function() {
           
                xajax_mostrarMedioslist('<?php echo $tipoMedio[0]['tipo_medios_id'];?>','<?php echo $Secciones[0]['medios_id'];?>','1');
               
       

            });
                    </script>

</body>



</html>

