<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/medios.process.php');
$model       = new funcionesModel();
$tipo_medios = $model->listarTablaGeneral("*","tipo_medios","");
$medios      = $model->listarTablaGeneral(" * ","medios","where id='".mysql_real_escape_string($_GET['id'])."'");
$cobertura   = array_cobertura();
$periocidad  = array_periocidad();
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

                    <h1 class="page-header">Editar Medios</h1>

                </div>

                 <!-- end  page header -->

            </div>

            <div class="row">

                <div class="panel-heading">

                    <div class="form-group1">

                        

                        <div class="opci">

                        <!-- Opciones Guardar -->        
                        <?php if($_SESSION['sTipoUsuario']==1){

                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                        <div class="nuev"><a href="#" onclick="xajax_editarMedios(xajax.getFormValues('form_editar'));"><img src="images/guar.png"> Guardar</a></div>
                        <?php }
                            }
                        ?>
                        <!-- Opcion Guardar-->
                     


                        <div class="elim"><a href="medios.php"><img src="images/cerr.png"> Cerrar</a></div>

                        </div> 



                    </div>

                    <div class="conte">

                    <form id="form_editar" name="form_editar" method="post">

                        <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id']?>" /> 


                         <div class="row show-grid">

                                <div class="col-md-4">
                                Tipo de Medio<br />
                                <select id="tipo_medio" name="tipo_medio" class="form-control">

                                <option value="0">[Todos]</option>

                                <?php for($i=0;$i<count($tipo_medios);$i++){?>

                                <option <?php  if($medios[0]["tipo_medios_id"]==$tipo_medios[$i]["id"]){?> selected <?php }?> value="<?php echo $tipo_medios[$i]["id"];?>"><?php echo utf8_encode($tipo_medios[$i]["nombres"]);?></option>    

                                <?php }?>
                                </select>
                                </div>

                                <div class="col-md-4" style="width: 65%;">

                                    Cobertura :<br />
                                    <select id="cobertura" name="cobertura" class="form-control">

                                    <option value="0">[Seleccionar]</option>

                                    <?php foreach ($cobertura as $key => $value) {?>

                                    <option <?php  if($medios[0]["cobertura"]==$key){?> selected <?php }?> value="<?php echo $key;?>" ><?php echo $value;?></option>
                                    <?php } ?>       
                                    </select>
                                </div>    

                                <div class="col-md-4" >
                                    Nombre :<br />
                                    <input type="text" id="nombres" name="nombres" value="<?php echo utf8_encode($medios[0]["nombres"]);?>" class="form-control" value="">
                                </div>   

                                <div class="col-md-4" style="width: 65%;">
                                    Direccion : <br >
                                    <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $medios[0]["direccion"];?>" />
                                </div>    

                                <div class="col-md-4" >
                                    Periocidad : <br />
                                    <select id="periocidad" name="periocidad" class="form-control">

                                    <option value="0">[Seleccionar]</option>

                                    <?php foreach ($periocidad as $key => $value) {?>

                                    <option <?php  if($medios[0]["periocidad"]==$key){?> selected <?php }?> value="<?php echo $key;?>" ><?php echo $value;?></option>

                                    <?php } ?>        

                                    </select>
                                </div>

                                <div class="col-md-4" >
                                    Lectoria : <br />
                                    <input type="text" name="lectoria" id="lectoria" value="<?php echo $medios[0]["lectoria"];?>" class="form-control" />
                                </div>    

                                 <div class="col-md-4" >
                                    Tiraje :<br />
                                    <input type="text" id="tiraje" name="tiraje" class="form-control" value="<?php echo $medios[0]["tiraje"];?>" />
                                 </div>   

                                 <div class="col-md-4"  style="width: 100%;">
                                    Resumen/Perfil : <br />
                                    <input type="text" name="resumen" style="height:100px" id="resumen" value="<?php echo $medios[0]["resumen"];?>" class="form-control" />
                                 </div>   

                                  <div class="col-md-4" style="width: 100%;">
                                    Audiencia :<br />
                                    <input type="text" id="audiencia" name="audiencia" class="form-control"  value="<?php echo $medios[0]["audiencia"];?>" />
                                  </div>  

                         </div>       

                        </div>


             

                        <div class="form-group"><br>
                         <!-- Opciones Guardar -->        
                        <?php if($_SESSION['sTipoUsuario']==1){

                                 $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 if(in_array(2, $extraer_permisos)){

                            ?>    
                        <button type="button" onclick="xajax_editarMedios(xajax.getFormValues('form_editar'));" class="btn1 btn-primary">Enviar</button>
                        <?php }
                                }

                        ?>
                        <!-- end -->   
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

