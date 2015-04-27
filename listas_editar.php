<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/listas.process.php');
$model       = new funcionesModel();
$clientes    = $model->listarTablaGeneral("*","clientes","");
$listas      = $model->listarTablaGeneral(" * ","listas","where id='".mysql_real_escape_string($_GET['id'])."'");

$listadoPeriodistas    = $model->listarTablaGeneral("id,nombres,apellidos","periodistas"," where id in (".$listas[0]["periodistas"].") ");

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

                    <h1 class="page-header">Editar Lista</h1>

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
                        <div class="nuev"><a href="#" onclick="xajax_editarLista(xajax.getFormValues('form_editar'));"><img src="images/guar.png"> Guardar</a></div>
                        <?php }
                            }
                        ?>
                        <!-- Opcion Guardar-->
                     


                        <div class="elim"><a href="listas.php"><img src="images/cerr.png"> Cerrar</a></div>

                        </div> 



                    </div>

                    <div class="conte">

                    <form id="form_editar" name="form_editar" method="post">

                        <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id']?>" /> 


                         <div class="row show-grid">

                                <div class="col-md-4">
                                Listas<br />
                                <select id="clientes" name="clientes" class="form-control">

                                <option value="0">[Todos]</option>

                                <?php for($i=0;$i<count($clientes);$i++){?>

                                <option <?php  if($listas[0]["cliente_id"]==$clientes[$i]["id"]){?> selected <?php }?> value="<?php echo $clientes[$i]["id"];?>"><?php echo utf8_encode($clientes[$i]["nombres"]);?></option>    

                                <?php }?>
                                </select>
                                </div>
   

                                <div class="col-md-4" >
                                    Nombre :<br />
                                    <input type="text" id="nombres" name="nombres" value="<?php echo utf8_encode($listas[0]["nombres"]);?>" class="form-control" value="">
                                </div>   

                                  
 

                                  <div class="col-md-4" style="width: 100%;text-align:left">
                                    Periodistas :<br /><br />   
                                     
                                      <?php for($j=0;$j<count($listadoPeriodistas);$j++){?>
                                     <div class="option" >
                                     <input  checked type="checkbox" class="opciones" id="periodistas[]" name="periodistas[]" value="<?php echo $listadoPeriodistas[$j]["id"];?>"  /> <?php echo $listadoPeriodistas[$j]["nombres"]." ".utf8_encode($listadoPeriodistas[$j]["apellidos"]);?>
                                     </div>
                                     <?php }?>
                                  </div>  

                         </div>       

                        </div>


             

                        <div class="form-group"><br>
                         <!-- Opciones Guardar -->        
                        <?php if($_SESSION['sTipoUsuario']==1){

                                 $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 if(in_array(2, $extraer_permisos)){

                            ?>    
                        <button type="button" onclick="xajax_editarLista(xajax.getFormValues('form_editar'));" class="btn1 btn-primary">Enviar</button>
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

