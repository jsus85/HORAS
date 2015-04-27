<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/actividad.process.php');
$model        = new funcionesModel();
$periodistas  = $model->listarTablaGeneral("id,nombres","periodistas"," where estado = 1 order by nombres asc");
$TipoMedios   = $model->listarTablaGeneral(" id,nombres ","tipo_medios"," order by nombres asc");
$Medios       = $model->listarTablaGeneral(" id,nombres ","medios"," order by nombres asc");
$Clientes     = $model->listarTablaGeneral(" id,nombres ","clientes"," order by nombres asc ");
$TemaInteres  = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");
$Cargos       = $model->listarTablaGeneral("id,nombres","cargos"," order by nombres asc");
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
                    <h1 class="page-header">Nueva Actividad del Periodista</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_nuevoActividad(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="actividades.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="query" id="query" value="1" />   
                        <div class="form-group"><label>Buscar Periodista</label></div>
                        <div class="">                                            
                        <select id="periodistas" name="periodistas" class="form-control">
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($periodistas);$i++){?>
                        <option value="<?php echo $periodistas[$i]["id"];?>"><?php echo utf8_encode($periodistas[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select>
                        </div>

                        <div class="form-group"><label>Tipo Medios :</label></div>
                        <div class=""><select id="tipo_medios" name="tipo_medios" class="form-control" />
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($TipoMedios);$i++){?>
                        <option value="<?php echo $TipoMedios[$i]["id"];?>"><?php echo utf8_encode($TipoMedios[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select></div>

                        <div class="form-group"><label>Medios :</label></div>
                        <div class=""><select id="medios" name="medios" class="form-control">
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($Medios);$i++){?>
                        <option value="<?php echo $Medios[$i]["id"];?>"><?php echo utf8_encode($Medios[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select>
                        </div>

                        <div class="form-group"><label>Cargos :</label></div>
                        <div class=""><select id="cargos" name="cargos" class="form-control">
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($Cargos);$i++){?>
                        <option value="<?php echo $Cargos[$i]["id"];?>"><?php echo utf8_encode($Cargos[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select>
                        </div>

                        <div class="form-group"><label><b>DETALLE ACTIVIDADES:</b></label></div>
                        <table id="no-more-tables">
                                    <thead class="theadact">
                                        <tr>
                                            <th></th>
                                            <th align="center">CLIENTES</th>
                                            <th align="center">T.INTERES</th>
                                            <th align="center">SECCIONES</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=1;$i<=10;$i++){?>
                                        <tr>
                                            <td class="td2"><input type="checkbox" id="validar_<?php echo $i;?>" value="<?php echo $i;?>" name="validar_<?php echo $i;?>" /></td>
                                            <td data-title="Clientes" class="td2">
                                            <select id="clientes_<?php echo $i;?>" name="clientes_<?php echo $i;?>" style="float:left" >
                                            <option value="0">[Todos]</option>
                                            <?php for($x=0;$x<count($Clientes);$x++){?>
                                            <option value="<?php echo $Clientes[$x]["id"];?>"><?php echo utf8_encode($Clientes[$x]["nombres"]);?></option>    
                                            <?php }?></select></td>

                                            <td data-title="T.Interes" class="td2">
                                            <select id="tema_interes_<?php echo $i;?>"  name="tema_interes_<?php echo $i;?>" style="float:left" onchange="xajax_consultarSeccionMultiple(this.value,'<?php echo $i;?>');" class="select1">
                                            <option value="0">[Todos]</option>
                                            <?php  for($z=0;$z<count($TemaInteres);$z++){?>
                                            <option value="<?php echo $TemaInteres[$z]["id"];?>"><?php echo utf8_encode($TemaInteres[$z]["nombres"]);?></option>    

                                            <?php 
                                            $TemaInteres2 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$z]["id"]."' order by nombres asc");

                                            for($y=0;$y<count($TemaInteres2);$y++){
                                            ?>
                                            <option <?php if($_POST['tema_interes']==$TemaInteres2[$y]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres2[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres2[$y]["nombres"]);?></option> 

                                                <?php }// For 2?>

                                            <?php }// End For 1?>
                                            </select></td>

                                            <td data-title="Seccion" class="td2">
                                                <span id="HTTMLSeccion_<?php echo $i;?>" style="float:left" name="HTTMLSeccion">
                                                <select id="seccion_<?php echo $i;?>"  name="seccion_<?php echo $i;?>" class="select1">
                                                <option>[Seleccionar Interes]</option>
                                                </select>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php }?>

                                     </tbody>
                                </table>
        
                                <div class="form-group"><label>Fecha Ingreso :</label></div>
                                <div class=""><input type="text" name="fecha_inicio" class="form-control" id="fecha_inicio" /></div>

                                <div class="form-group"><label>Fecha Final :</label></div>
                                <div class=""><input type="text" name="fecha_final" class="form-control" id="fecha_final" /></div>


                                <div class="form-group"><label>Teléfonos :</label></div>
                                <div class=""><input type="text" name="telefonos" class="form-control" id="telefonos" /></div>

                                <div class="form-group"><label>Anexo :</label></div>
                                <div class=""><input type="text" name="anexo" class="form-control" id="anexo" /></div>

                        <div class="form-group"><br>
                        <button type="button" onclick="xajax_nuevoActividad(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Enviar</button>
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
    <!-- Calendar-->
    <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
            // Ejecutar calendario
            $(document).ready(function () {
                
                $('#fecha_inicio').datepicker({format: "yyyy-mm-dd"    });  
                $('#fecha_final').datepicker({format: "yyyy-mm-dd"    });  
            
            });
        </script>
</body>
</html>
