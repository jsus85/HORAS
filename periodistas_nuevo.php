<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/periodistas.process.php');
$model       = new funcionesModel();
$ciudades = $model->listarTablaGeneral("*","ciudades","");
$cobertura   = array_cobertura();
$periocidad  = array_periocidad();
$TemaInteres = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");
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
                    <h1 class="page-header">Nuevo Periodista</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_nuevoPeriodista(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="actividades.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="query" id="query" value="1" />                           
                        <div class="row show-grid">

                            <div class="col-md-4" style="width:65%">
                                Observaciones :<br />                                   
                                 <input type="text" id="comentario" style="border:1px solid red" name="comentario" class="form-control" />
                            </div> 

                            <div class="col-md-4">
                                Nombres<br />
                                <input type="text" id="nombres" name="nombres" class="form-control" value="">
                            </div>

                            
                            <div class="col-md-4">
                                Apellidos<br />
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="" />
                            </div>


                                <div class="col-md-4">
                                    Cumpleaños:<br />
                                    <input type="text" id="nacimiento" name="nacimiento" class="form-control" />
                                 </div>   
                            
                            <div class="col-md-4">
                                Ciudad<br />
                                <select id="ciudad" name="ciudad" class="form-control">
                                <option value="0">[Todos]</option>
                                <?php for($i=0;$i<count($ciudades);$i++){?>
                                <option value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                                <?php }?>
                                </select>
                            </div>

                            
                             <div class="col-md-4" style="width: 66%;">
                                Dirección:<br />
                                <input type="text" id="direccion" name="direccion" class="form-control" />

                               </div>
                            

                            <div class="col-md-4">
                                <div style="width: 70%;float: left;">
                                Teléfono #1<br />
                                <input type="text" id="telefono" name="telefono" class="form-control" />
                                </div>

                                <div style="width: 28%;float: right;
}">
                                Anexo<br />
                                <input type="text" id="anexo" name="anexo" class="form-control" />
                                </div>
                           
                            </div>


                            <div class="col-md-4">
                                Teléfono #2<br />
                                <input type="text" id="telefono2" name="telefono2" class="form-control" />
                            </div>

                            <div class="col-md-4">
                                Teléfono #3<br />
                                <input type="text" id="telefono3" name="telefono3" class="form-control" />
                            </div> 

                            <div class="col-md-4">
                                Celular #1: <br />
                                <input type="text" id="celularA" name="celularA" class="form-control" />
                            </div>


                          <div class="col-md-4">
                                Celular #2: <br />
                                <input type="text" id="celularB"  name="celularB" class="form-control" />
                            </div>


                          <div class="col-md-4">
                                Celular #3: <br />
                                <input type="text" id="celularC"  name="celularC" class="form-control" />
                            </div>

                            <div class="col-md-4">
                                Email #1:<br />
                                <input type="text" id="emailA"  name="emailA" class="form-control" />
                            </div>  

                            <div class="col-md-4">
                                Email #2:<br />
                                <input type="text" id="emailB" name="emailB" class="form-control" />
                            </div>  

                            <div class="col-md-4">
                                Email #3:<br />
                                <input type="text" id="emailC" name="emailC" class="form-control" />
                            </div>  

                                
                             


                            <div class="col-md-4">
                                Sexo:<br />                                   
                                <input type="radio" name="sexo" value="M" checked /> Masculino &nbsp;&nbsp;
                                <input type="radio" name="sexo" value="F" /> Femenino  
                            </div> 

                                 <div class="col-md-4">
                                 
                                 <a title="Clic Agregar Tema Interes" style="cursor:pointer" onclick="AgregasTemaInteres('1');" ><img src="assets/img/new.png" /></a>

                                    Tema de Interes:<br />                                   
                                    <select id="TemaEditar1[]"  name="TemaEditar1[]"  class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php  for($i=0;$i<count($TemaInteres);$i++){?>
                                    <option <?php if($_POST['tema_interes']==$TemaInteres[$i]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres[$i]["id"];?>"><?php echo utf8_encode($TemaInteres[$i]["nombres"]);?></option>    
                                    
                                        <?php 
                                        $TemaInteres2 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$i]["id"]."' order by nombres asc");

                                            for($y=0;$y<count($TemaInteres2);$y++){

                                        ?>
                                             <option <?php if($_POST['tema_interes']==$TemaInteres2[$y]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres2[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres2[$y]["nombres"]);?></option> 

                                        <?php }// For 2?>

                                    <?php }// End For 1?>
                                </select>
                                 
                                </div> 

                                <div style="clear:both" id="HTMLTemaInteres1"></div>

                                <div class="col-md-4">
                                    Foto:<br />
                                    <input type="file" id="foto" name="foto" /><br ><small>150px - 150px , JPG</small>
                                </div>

                             

                                
                                <div style="clear: both;padding-top: 20px;text-align: left;">
                                PERFIL  :<br /><br />
                                <textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
                                </div>     
                          

                        </div>     

                        <div class="form-group"><br>
                        <button type="button" onclick="xajax_nuevoPeriodista(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Enviar</button>
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
    <!-- CK Editor -->
    <script src="assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
 
    <script type="text/javascript">
        $(function() {

                $('#nacimiento').datepicker({format: "yyyy-mm-dd"    });  
            
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1');
            
        });

// Agregar Tema Interes
    var page = 0;
    function AgregasTemaInteres(indice){
      page++;
      
        $("#HTMLTemaInteres"+indice).append("<div class='paginas col-md-4' id = 'programas"+page+"'></div>");
        $.post("dataTemaInteres.php", {indice:indice} ,function( data ) {
          $( "#programas"+page ).html( data );
        });
    }

    </script>
</body>

</html>
