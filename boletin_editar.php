<?php 
session_start();
include('validar.session.php');
require("ds/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("model/functions.php");
include('controllers/boletines.process.php');
$model       = new funcionesModel();

$boletin         = $model->listarTablaGeneral("*","boletin"," where id = '".$_GET['id_boletin']."' ");
$boletinAdjuntos = $model->listarTablaGeneral("*","boletin_archivos"," where boletin_id = '".$_GET['id_boletin']."' ");

$difusion   = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$clientes   = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$saludos    = $model->listarTablaGeneral("*","saludos","");
$listas     = $model->listarTablaGeneral("*","listas"," where cliente_id = '".$boletin[0]['cliente_id']."' ");
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
    #cargador{display: none;}
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
                    <h1 class="page-header">Editar </h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_editarBoletin(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="boletines.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">

                         <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id_boletin']?>" /> 
                         <input type="hidden" name="HDDEstate" id="HDDEstate" value="<?php echo $boletin[0]['estado'];?>" /> 
                         <input type="hidden" name="query" id="query" value="2" /> 
                         <input type="hidden" name="HddUrl" id="HddUrl" value="0" /> 
                        <div class="row show-grid">

                            <div class="col-md-4" >
                                Nombre del documento :<br />
                                <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo utf8_encode($boletin[0]['nombres']);?>" /> 
                            </div>


                            <div class="col-md-4" >
                                Fecha de registro :<br />
                                <input type="text" readonly="yes" id="fecha_registro" name="fecha_registro" class="form-control" value="<?php echo $boletin[0]['fecha_registro'];?>" /> 
                            </div>
                            
                            <div class="col-md-4" >
                                Programar envio :<br />

                                <input type="text" id="fecha_envio" <?php if($boletin[0]['programar_envio']==0){?> readonly<?php }?> style="width:37%;float:left" name="fecha_envio" class="form-control" value="<?php echo substr($boletin[0]['fecha_envio'], 0,11);?>" /> 
                                
                                <select name="hora" id="hora">
                                    <?php for($i=1;$i<=24;$i++){?>
                                    <option <?php if(substr($boletin[0]['fecha_envio'], 10 ,3)==str_pad($i, 2, "0", STR_PAD_LEFT)){?> selected <?php }?> value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select> : <select name="minuto" id="minuto">
                                    <?php for($m=1;$m<=60;$m++){?>
                                    <option <?php if(substr($boletin[0]['fecha_envio'], 14 ,2)==str_pad($m, 2, "0", STR_PAD_LEFT)){?> selected <?php }?> value="<?php echo str_pad($m, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($m, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select>: <select name="segundo" id="segundo">
                                    <?php for($s=1;$s<=60;$s++){?>
                                    <option <?php if(substr($boletin[0]['fecha_envio'], 17 ,3)==str_pad($s, 2, "0", STR_PAD_LEFT)){?> selected <?php }?> value="<?php echo str_pad($s, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($s, 2, "0", STR_PAD_LEFT);?></option>
                                    <?php }?>
                                </select>
                                <br />
                                
                                <input type="checkbox" style=" float:rigth" <?php if($boletin[0]['programar_envio']==1){?> checked <?php }?> id="confirmoEnvio" name="confirmoEnvio" value="1" />  PROGRAMAR
                            </div>

                             <div class="col-md-4">
                                Tipo de Difusión <br />
                                <select id="difusion"  name="difusion" class="form-control" >
                                    <option value="0">[Seleccionar]</option>
                                    
                                    <?php for($w=0;$w<count($difusion);$w++){?>
                                    <option <?php if($boletin[0]['difusion_id']== $difusion[$w]["id"]){?>selected<?php }?> value="<?php echo $difusion[$w]["id"];?>"><?php echo utf8_encode($difusion[$w]["nombres"]);?></option>   

                                    <?php $difusion2  = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = '".$difusion[$w]["id"]."' order by nombres asc ");
                                    ?>
                                    
                                    <?php for($m=0;$m<count($difusion2);$m++){?>
                                    <option <?php if($boletin[0]['difusion_id'] == $difusion2[$m]["id"]){?>selected<?php }?> value="<?php echo $difusion2[$m]["id"];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo utf8_encode($difusion2[$m]["nombres"]);?></option>  
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
                                    <option <?php if($boletin[0]['cliente_id'] == $clientes[$i]["id"]){?>selected<?php }?>   value="<?php echo $clientes[$i]["id"];?>"><?php echo utf8_encode($clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                                  </select>
                            </div>

    
                            <div class="col-md-4">
                                Lista <br />
                                <span id="HTML_LISTAS">
                                <select id="Lista" class="form-control" name="Lista">
                                 <option value="0">[Seleccionar Lista]</option>
                                  <?php for($t=0;$t<count($listas);$t++){?>
                                 <option <?php if($boletin[0]['lista_id'] == $listas[$t]["id"]){?>selected<?php }?>   value="<?php echo $listas[$t]["id"];?>"><?php echo utf8_encode($listas[$t]["nombres"]);?></option>    
                                    <?php }?>
                                </select>
                                </span>
                            </div>

                            <div class="col-md-4" style="width:100%;text-align: left;">
                                <h4>Personalizar Boletin</h4>
                            </div>

                            <div class="col-md-4" >
                                Asunto: <br />
                                <input type="text" name="asunto" id="asunto" value="<?php echo utf8_encode($boletin[0]['asunto']);?>" class="form-control" />
                            </div>    

                            <div class="col-md-4" >
                                Saludo :
                                <select id="saludo" name="saludo" class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php for($s=0;$s<count($saludos);$s++){?>
                                    <option <?php if($boletin[0]['saludo_id'] == $saludos[$s]["id"]){?>selected<?php }?> value="<?php echo $saludos[$s]["id"];?>"><?php echo utf8_encode($saludos[$s]["nombres"])."  -  ".utf8_encode($saludos[$s]["nombres_femenino"]);?></option>    
                                    <?php }?>
                                  </select>
                            </div>

                            <div class="col-md-4" style="width: 100%;">
                            Cuerpo del mensaje: <br />
                            <textarea name="mensaje"  id="mensaje" class="form-control"><?php echo utf8_encode($boletin[0]['resumen']);?></textarea>   
                            </div>

                             <div class="col-md-4" >
                                Imagen adjunta cuerpo(JPG): <br />
                                <input type="file" name="imagen" id="imagen"  />
                                <?php if($boletin[0]['imagen']!=''){?>
                                <img height="130" src="images/boletines/<?php echo $boletin[0]['imagen'];?>" />
                                <?php }?>
                            </div>         

                             <div class="col-md-4"  style="width: 60%;">
                                <a onclick="addField();" style="text-decoration:underline" >Agregar archivos (+)</a><br />
                                <input type="file" name="documentos[]" id="documentos[]" class='dynamic-file' />
                             </div>

                             <div class="col-md-4" style="float: right;" >
                                <p><b style="font-size:15px">>> ARCHIVOS ADJUNTOS</b></p>
                                 <?php for($ba=0;$ba<count($boletinAdjuntos);$ba++){?>
                                 <div class="botones_<?php echo $boletinAdjuntos[$ba]['id']?>">
                                    <a href="images/boletines/adjuntos/<?php echo $boletinAdjuntos[$ba]['nombres'];?>" target="_blank">Ver archivo adjunto</a> &nbsp;|&nbsp; <a  onclick="xajax_borrarAdjunto('<?php echo $boletinAdjuntos[$ba]['nombres']?>','<?php echo $boletinAdjuntos[$ba]['id']?>');">Eliminar</a></div>
                                 <?php  } ?>
                             </div>

                             <div id="cargador" class="col-md-4" style="float: left;" >
                             <img src="images/enviando.gif" />
                             </div>

                        </div>
                          
                        <div class="form-group">
                        <button type="button" onclick="xajax_guardarBoletin(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar Difusión</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="xajax_editarBoletin(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar & Cerrar</button>
                        &nbsp;&nbsp;&nbsp;
                         <a id="btnLista" href="vista_previa_boletin.php?id_boletin=<?php echo $_GET['id_boletin'];?>" rel="modal:open" class="btn1 btn-primary" role="button">Vista Previa</a>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="xajax_enviarMailPrueba('<?php echo $_GET['id_boletin'];?>');" class="btn1 btn-primary">Enviar Correo Prueba </button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="xajax_enviarMailista('<?php echo $_GET['id_boletin'];?>');" class="btn1 btn-primary">Enviar Difusión</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="xajax_programarBoletin(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Programar Difusión</button>
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


    <!-- Modal -->        
    <script src="assets/plugins/modal/jquery.modal.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="assets/plugins/modal/jquery.modal.css" type="text/css" media="screen" />
    <script src="assets/plugins/modal/highlight/highlight.pack.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
    hljs.initHighlightingOnLoad(); 
    </script>




    <style type="text/css">
      .modal a.close-modal[class*="icon-"] {top: -10px;right: -10px;width: 20px;height: 20px;color: #fff;line-height: 1.25;text-align: center;text-decoration: none;  text-indent: 0;background: #900;border: 2px solid #fff;-webkit-border-radius: 26px;-moz-border-radius: 26px;-o-border-radius: 26px;-ms-border-radius: 26px;-moz-box-shadow:    1px 1px 5px rgba(0,0,0,0.5);-webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.5);box-shadow:1px 1px 5px rgba(0,0,0,0.5);}
    </style>


    <script type="text/javascript">
        $(function() {

               $('#fecha_envio').datepicker({format: "yyyy-mm-dd" });  
               $('#confirmoEnvio').click(function(event) {  //on click 
                                   
                    if(this.checked) { // check select status
                        $('#fecha_envio').attr('readonly', false);       
                    }else{
                        $('#fecha_envio').attr('readonly', true);
                    }
                    
             });// ENf function                   
         });

        function addField(){
            $('<input type="file" name="documentos[]" id="documentos[]" class="dynamic-file" /><br />').insertAfter($('.dynamic-file').last());
         };
      </script>  

</body>

</html>
