<?php 
session_start();
include('validar.session.php');
require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("model/functions.php");
include('controllers/boletines.process.php');
$model       = new funcionesModel();

$difusion   = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$clientes   = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$saludos    = $model->listarTablaGeneral("*","saludos","");
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
    .dynamic-file{float: left;}
    .desactivar{  opacity: 0.7;}
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
                    <h1 class="page-header">Nueva Difusión</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_nuevoBoletin(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="boletines.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="query" id="query" value="1" /> 
                        <div class="row show-grid">

                            <div class="col-md-4" >
                                Nombre del documento :<br />
                                <input type="text" id="nombres" name="nombres" class="form-control" value="" /> 
                            </div>


                            <div class="col-md-4" >
                                Fecha de registro :<br />
                                <input type="text" readonly="yes" id="fecha_registro" name="fecha_registro" class="form-control" value="<?php echo date('Y-m-d');?>" /> 
                            </div>
                            
                            <div class="col-md-4" >
                                Programar envio :<br />
                                <input type="text" id="fecha_envio" readonly="yes" style="width:37%;float:left" name="fecha_envio" class="form-control" value="<?php echo date('Y-m-d H:i:s');?>" /> 
                                
                                <select name="hora" id="hora" disabled>
                                    <?php for($i=1;$i<=24;$i++){?>
                                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select> : <select name="minuto" disabled id="minuto" >
                                    <?php for($m=1;$m<=60;$m++){?>
                                    <option value="<?php echo str_pad($m, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($m, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select>: <select name="segundo" id="segundo" disabled>
                                    <?php for($s=1;$s<=60;$s++){?>
                                    <option value="<?php echo str_pad($s, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($s, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select>
                                <br />

                                <input type="checkbox" style=" float:rigth" id="confirmoEnvio" name="confirmoEnvio" value="1" />  PROGRAMAR
                            </div>

                             <div class="col-md-4">
                                Tipo de Difusión <br />
                                <select id="difusion"  name="difusion" class="form-control" >
                                    <option value="0">[Seleccionar]</option>
                                    
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
                            </div>      


                            <div class="col-md-4">
                                Cliente <br />
                                 <select id="clientes" onchange="xajax_mostrarListas(this.value,'');" name="clientes" class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($clientes);$i++){?>
                                    <option  value="<?php echo $clientes[$i]["id"];?>"><?php echo utf8_encode($clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                                  </select>
                            </div>

    
                            <div class="col-md-4">
                                Lista <br />
                                <span id="HTML_LISTAS"><select id="Lista" class="form-control" name="Lista"><option>[Seleccionar lista]</option></select>  </span>
                            </div>

                            <div class="col-md-4" style="width:100%;text-align: left;">
                                <h4>Personalizar Boletin</h4>
                            </div>

                            <div class="col-md-4" >
                                Asunto: <br />
                                <input type="text" name="asunto" id="asunto" class="form-control" />
                            </div>    

                            <div class="col-md-4" >
                                Saludo :
                                <select id="saludo" name="saludo" class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php for($s=0;$s<count($saludos);$s++){?>
                                    <option value="<?php echo $saludos[$s]["id"];?>"><?php echo utf8_encode($saludos[$s]["nombres"])."  -  ".utf8_encode($saludos[$s]["nombres_femenino"]);?></option>    
                                    <?php }?>
                                  </select>
                            </div>

                            <div class="col-md-4" style="width: 100%;">
                            Cuerpo del mensaje: <br />
                            <textarea name="mensaje"  id="mensaje" class="form-control"></textarea>   
                            </div>

                             <div class="col-md-4" >
                                Imagen adjunta cuerpo(JPG): <br />
                                <input type="file" name="imagen" id="imagen"  />
                            </div>         

                             <div class="col-md-4"  style="width: 60%;">
                                <a onclick="addField();" style="text-decoration:underline" >Agregar archivos (+)</a><br />
                                <input type="file" name="documentos[]" id="documentos[]" class='dynamic-file' />
                             </div>

                        </div>
                          
                        <div class="form-group">
                        <button type="button" onclick="xajax_nuevoBoletin(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar Boletin</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="desactivar btn1 btn-primary">Vista Previa </button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="desactivar btn1 btn-primary">Enviar Boletin </button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="desactivar btn1 btn-primary">Programar Boletin </button>
                        <br >

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

        $(function() {

            $('#confirmoEnvio').click(function(event) {  //on click 
                                   
                    if(this.checked) { // check select status
                        $('#fecha_envio').attr('readonly', false);       
                        $('#hora').attr('disabled', false);       
                        $('#minuto').attr('disabled', false);       
                        $('#segundo').attr('disabled', false);                                                                               
                    }else{
                        $('#fecha_envio').attr('readonly', true);
                        $('#hora').attr('disabled', true);       
                        $('#minuto').attr('disabled', true);       
                        $('#segundo').attr('disabled', true);                             
                    }
                    
             });// ENf function 

           $('#fecha_envio').datepicker({format: "yyyy-mm-dd"    });                       
        });

         function addField(){
               $('<input type="file" name="documentos[]" id="documentos[]" class="dynamic-file" /><br />').insertAfter($('.dynamic-file').last());
          };


      </script>  
</body>
</html>
