<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/periodistas.process.php');
$model       = new funcionesModel();
$ciudades = $model->listarTablaGeneral("*","ciudades","");
$cobertura   = array_cobertura();
$periocidad  = array_periocidad();

$periodistas   = $model->listarTablaGeneral(" nombres,telefono,anexo,celularA,celularB,emailA,emailB,nacimiento,comentarios,foto,direccion,cv,ciudad_id ","periodistas","where id='".mysql_real_escape_string($_GET['id'])."'");

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
                    <h1 class="page-header">Editar Periodista</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="opci">
                        <div class="nuev"><a href="#" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <!--<div class="edit"><a href="#"><img src="images/gnue.png"> Guardar Nuevo</a></div>-->
                        <div class="elim"><a href="periodistas.php"><img src="images/cerr.png"> Cerrar</a></div>
                        </div> 

                    </div>
                    <div class="conte">
                    <form id="form_nuevo" name="form_nuevo" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="query" id="query" value="2" /> 
                        <input type="hidden" name="HDDID" id="HDDID" value="<?php echo $_GET['id'];?>" />  
                        <div class="form-group"><label>Ciudad</label></div>
                        <div class="">                                            
                        <select id="ciudad" name="ciudad" class="form-control">
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($ciudades);$i++){?>
                        <option <?php if($periodistas[0]['ciudad_id']==$ciudades[$i]["id"]){?> selected <?php }?> value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select>
                        </div>

                        <div class="form-group"><label>Nombres :</label></div>
                        <div class=""><input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo utf8_encode($periodistas[0]['nombres']);?>" /></div>

                        <div class="form-group"><label>Teléfono :</label></div>
                        <div class=""><input type="text" id="telefono" name="telefono" value="<?php echo $periodistas[0]['telefono'];?>" class="form-control" /></div>

                        <div class="form-group"><label>Anexo :</label></div>
                        <div class=""><input type="text" id="anexo" name="anexo" class="form-control" value="<?php echo $periodistas[0]['anexo'];?>" /></div>

                        <div class="form-group"><label>Celular #1:</label></div>
                        <div class=""><input type="text" id="celularA" name="celularA" value="<?php echo $periodistas[0]['celularA'];?>" class="form-control" /></div>

                        <div class="form-group"><label>Celular #2:</label></div>
                        <div class=""><input type="text" id="celularB" name="celularB" class="form-control" value="<?php echo $periodistas[0]['celularB'];?>" /></div>

                        <div class="form-group"><label>Email #1:</label></div>
                        <div class=""><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="emailA" value="<?php echo $periodistas[0]['emailA'];?>" name="emailA" class="form-control" />
                        </div>
                        </div>

                        <div class="form-group"><label>Email #2:</label></div>
                        <div class=""><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="emailB" value="<?php echo $periodistas[0]['emailB'];?>" name="emailB" class="form-control" />
                        </div></div>
                        
                        <div class="form-group"><label>Cumpleaños:</label></div>
                        <div class=""><input type="text" id="nacimiento" value="<?php echo $periodistas[0]['nacimiento'];?>" name="nacimiento" class="form-control" /></div>

                        <div class="form-group"><label>Comentario:</label></div>
                        <div class=""><textarea class="form-control" id="comentario" name="comentario" rows="3" ><?php echo $periodistas[0]['comentarios'];?></textarea></div>

                        <div class="form-group"><label>Foto:</label></div>
                        <div class=""><input type="file" id="foto" name="foto"  /> <?php if($periodistas[0]['foto']!=''){?><img src="images/periodistas/<?php echo $periodistas[0]['foto'];?>" width="100"  /><?php } ?></div>

                        <div class="form-group"><label>Dirección:</label></div>
                        <div class=""><textarea class="form-control" id="direccion" name="direccion" rows="3" ><?php echo $periodistas[0]['direccion'];?></textarea></div>

                        <div class="form-group"><label>CV:</label></div>
                        <div class="">
                                 <form>
                                        <textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $periodistas[0]['cv'];?></textarea>
                                    </form>

                        </div>

                        <div class="form-group"><br>
                        <button type="button" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Enviar</button>
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
    
    <!-- CK Editor -->
    <script src="assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
     <!-- Calendar-->
    <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $(function() {
              $('#nacimiento').datepicker({format: "yyyy-mm-dd"    });  
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1');
            
        });
    </script>
</body>

</html>
