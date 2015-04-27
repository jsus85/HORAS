<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/usuarios.process.php');
$model     = new funcionesModel();
$arrai_usuario = array_tipoUsuario();
$Clientes    = $model->listarTablaGeneral("id,nombres","clientes"," where estado = 1 order by nombres asc");
$Menus    = $model->listarTablaGeneral("id,nombres","menus","  order by nombres asc");
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
    .listado_clientes{float: left;  display: block;margin: 2px;padding: 2px;    width: 307px;}
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

                    <h1 class="page-header">Nuevo Usuario</h1>

                </div>

                 <!-- end  page header -->

            </div>

            <div class="row">


                    <div class="form-group1">

                        

                        <div class="opci">

                        <div class="nuev"><a href="#" onclick="xajax_nuevoUsuario(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>

                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->

                        <div class="elim"><a href="usuarios.php"><img src="images/cerr.png"> Cerrar</a></div>

                        </div> 



                    </div>

                    <div class="conte">

                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="query" id="query" value="1" /> 
                        <div class="row show-grid">

                            <div class="col-md-4">
                                Tipo de Usuario : <br />
                                <select id="tipo_usuario" name="tipo_usuario" onchange="seleccionarCheck(this.value);" class="form-control">

                                <option value="--">[Seleccionar]</option>

                                <?php foreach ($arrai_usuario as $key => $value) {?>

                                <option value="<?php echo $key;?>"><?php echo $value;?></option>

                                <?php }?>

                                </select>
                            </div>
                        


                            <div class="col-md-4" style="width: 65%;">
                                Nombre : <br />
                                <input type="text" id="nombres" name="nombres" class="form-control" value="">
                            </div> 


                           <div class="col-md-4" >
                            Email #1: <br />
                            <input type="text" id="email" name="email" class="form-control" />
                           </div>


                            <div class="col-md-4">
                                Usuario : <br />
                                <input type="text" id="usuario" name="usuario" class="form-control" value="" />
                            </div>

                            <div class="col-md-4">
                                Password : <br />
                                <input type="text" id="password" name="password" class="form-control" value="" />
                            </div>

                           <div class="col-md-4">
                                     Firma:<br />
                                    <input type="file" id="foto" name="foto" />
                            </div>        
                           <style type="text/css">
                            .option{float: left;display: block;margin: 5px;padding: 5px;width: 215px;                 
                            }

                            </style>


                        <div class="form-group" style="margin-bottom:0"><h4 class="page-header">Permisos</h4></div>    
                         <p><input type="checkbox" id="selectMantenimiento" name="selectMantenimiento" /> TODOS  </p>

                        <div class="option" ><input class="opciones checkboxMantenimiento" type="checkbox" id="menu_1" name="menu_1" value="1"  />Mantenimientos de Usuario</div>
                        
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_2" name="menu_2" value="2"  />Mantenimientos de Medios</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_3" name="menu_3" value="3"  />Mantenimientos de Clientes</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_4" name="menu_4" value="4"  />Mantenimientos de T. Interes</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_5" name="menu_5" value="5"  />Mantenimientos de Secciones</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_6" name="menu_6" value="6"  />Mantenimientos de Cargos</div>                         
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_7" name="menu_7" value="7"  />Mantenimientos de Ciudades</div>   
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_8" name="menu_8" value="8"  />Mantenimientos Periodista</div>       
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_9" name="menu_9" value="9"  />Mantenimientos Suplementos</div>


                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_13" name="menu_13" value="13"  />Mantenimientos Difusión</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_14" name="menu_14" value="14"  />Mantenimientos saludos</div>


                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_11" name="menu_11" value="11"  />Mantenimientos Listas</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_12" name="menu_12" value="12"  />Difusión</div>
                        <div class="option"><input class="opciones checkboxMantenimiento"  type="checkbox" id="menu_15" name="menu_15" value="15"  />Mantenimientos Seguimientos</div>


                        <div id="atributos" style="display:block">
                            <div class="form-group" style="margin-bottom:0"><h4 class="page-header">Atributos</h4></div> 
                            <div class="option" ><input class="opciones " type="checkbox" id="atributos_1" name="atributos_1" value="1"  />Lectura</div>       
                            <div class="option" ><input class="opciones " type="checkbox" id="atributos_2" name="atributos_2" value="2"  />Escritura</div>
                        </div>

                        <div class="form-group" style="margin-bottom:0"><h4 class="page-header">Clientes</h4> </div>    
                        <p><input type="checkbox" id="selecCliente" name="selecCliente" /> TODOS LOS CLIENTES </p>
                         <?php 
                         for($x=0;$x<count($Clientes);$x++){
                         ?>
                         <div class="listado_clientes" ><input  type="checkbox" class="checkboxClientes" id="clientes[]" name="clientes[]" value="<?php echo $Clientes[$x]["id"];?>" /> <?php echo utf8_encode($Clientes[$x]["nombres"]);?></div>
                        <?php }// End For 2?>  


                        <div class="form-group"><br>

                        <button type="button" onclick="xajax_nuevoUsuario(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Enviar</button>

                        </div>
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
    
    $( document ).ready(function() {
        $('#atributos').hide();
    });

    function seleccionarCheck(data){

        if(data==1){ // administrador
            $(".opciones").prop("checked",true);
            $('#atributos').show();
        }else{     // Usuario 
            $(".opciones").prop("checked",false);
            $('#atributos').hide();

      }

    }
    </script>  
    


</body>



</html>

