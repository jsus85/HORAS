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
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <style type="text/css">
    .form-control{height: 30px;font-size: 12px;width:auto; }
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
                        <style type="text/css" media="screen">
                         .box{ width: 25%;float: left;padding:10px;margin-left: auto;margin-right: auto}  
                         .form-group label{font-size: 14px;} 
                        </style>
                        <div class="box">
                        
                        <?php if($periodistas[0]['foto']!=''){?>
                        <img src="images/periodistas/<?php echo $periodistas[0]['foto'];?>" width="150" height="150"  />
                        <?php }else{?>
                        <img src="images/No_imagen_disponible.gif" width="150" height="150"  />                        
                        <?php }?>
                        <p><input type="file" id="foto" name="foto"  /></p>
                        </div>
                         
                        <div class="box">
                           <div class="form-group"><label>Ciudad</label></div>
                            <select id="ciudad" name="ciudad" class="form-control">
                        <option value="0">[Todos]</option>
                        <?php for($i=0;$i<count($ciudades);$i++){?>
                        <option <?php if($periodistas[0]['ciudad_id']==$ciudades[$i]["id"]){?> selected <?php }?> value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                        <?php }?>
                        </select>
                        </div> 

                       <div class="box">
                        <div class="form-group"><label>Nombres :</label></div>                           
                        <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo utf8_encode($periodistas[0]['nombres']);?>" />
                       </div>

                        <div class="box">
                        <div class="form-group"><label>Teléfono :</label></div> 
                        <input type="text" id="telefono" name="telefono" value="<?php echo $periodistas[0]['telefono'];?>" class="form-control" />
                        </div>    

                        <div class="box"><div class="form-group"><label>Anexo :</label></div>
                        <input type="text" id="anexo" name="anexo" class="form-control" value="<?php echo $periodistas[0]['anexo'];?>" />
                        </div>
                        

                        <div class="box"><div class="form-group"><label>Celular #1:</label></div> <input type="text" id="celularA" name="celularA" value="<?php echo $periodistas[0]['celularA'];?>" class="form-control" /></div>
                    
                        <div class="box"><div class="form-group"><label>Celular #2:</label></div>
                        <input type="text" id="celularB" name="celularB" class="form-control" value="<?php echo $periodistas[0]['celularB'];?>" />
                        </div>

                        <div class="box" style="width:35%">
                        <div class="form-group"><label>Email #1:</label></div>
                        <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="emailA" style="width:100%" value="<?php echo $periodistas[0]['emailA'];?>" name="emailA" class="form-control" />
                        </div>
                        </div>
        
                        <div class="box" style="width:35%">
                        <div class="form-group"><label>Email #2:</label></div>
                        <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="emailB" style="width:100%"value="<?php echo $periodistas[0]['emailB'];?>" name="emailB" class="form-control" />
                        </div>
                        </div>
            
                        <div class="box">
                        <div class="form-group"><label>Cumpleaños:</label></div>     
                        <input type="text" id="nacimiento" value="<?php echo $periodistas[0]['nacimiento'];?>" name="nacimiento" class="form-control" />
                        </div>   
                        

                        <div class="box">
                        <div class="form-group"><label>Comentario :</label></div>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" ><?php echo $periodistas[0]['comentarios'];?></textarea>
                        </div>
                        
                        <div class="box">
                        <div class="form-group"><label>Dirección :</label></div>
                        <textarea class="form-control" id="direccion" name="direccion" rows="3" ><?php echo $periodistas[0]['direccion'];?></textarea>
                        </div>

                        <div class="form-group"><label>CV:</label></div>
                        <div class=""><textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $periodistas[0]['cv'];?></textarea>
                        </div>
                           <br> 
                        <div class="panel panel-default">
                            <h1 class="page-header" style="margin-top:1px">Actividades</h1>
                <?php 
                        $lista  = $model->datosActividadesPeriodista($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccion'],$_POST['clientes'],$_GET['id']);
                      
                ?>
                <button type="button" onclick="window.location='actividades_nuevo.php?periodista=<?php echo $_GET['id'];?>'" class="btn btn-primary">Nueva Actividad</button> <br><br>

                 <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" /></th>
                                                <th title="Tipo Medio">T. MEDIO</th>
                                                <th>MEDIO</th>
                                                <th>CLIENTE</th>
                                                <th>T.INTERES</th>
                                                <th>SECCIÓN</th>                                          
                                                <th>CARGO</th>
                                                <th title="Fecha Inicio y Fecha Fin">INI/FIN</th>                                                
                                                <th title="Telefonso y Anexo">TEL./ANE.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
<?php 
                   for($i=0;$i<count($lista);$i++){
                                        
                       $dataTipoMedio   = $model->listarTablaGeneral(" nombres ","tipo_medios","where id='".$lista[$i]["tipo_medio_id"]."'");
                       $dataMedios      = $model->listarTablaGeneral(" nombres ","medios","where id='".$lista[$i]["medio_id"]."'");
                      
                       $dataClientes    = $model->listarTablaGeneral(" nombres ","clientes","where id in (".$lista[$i]["clientes_id"].") ");
                       $dataTemaInteres = $model->listarTablaGeneral(" nombres ","tema_interes","where id  in (".$lista[$i]["tema_interes_id"].") ");
                       
                       $dataSecciones   = $model->listarTablaGeneral(" nombres ","secciones","where id in(".$lista[$i]["secciones_id"].")");

                       $dataCargo       = $model->listarTablaGeneral(" nombres ","cargos","where id='".$lista[$i]["cargo_id"]."'");
?>
                  <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            <td><input type="checkbox" id="idActividad[]" name="idActividad[]" value="<?php echo $lista[$i]["id"];?>" /></td>
                                            <td><a title="Editar Actividad" href="EditarActividad-<?php echo $lista[$i]["id"];?>.html"><?php echo trim(utf8_encode($dataTipoMedio[0]["nombres"]));?></a></td>
                                            <td><?php echo utf8_encode($dataMedios[0]["nombres"]);?></td>

                                            <td><?php for($y=0;$y<count($dataClientes);$y++){  echo "/".utf8_encode($dataClientes[$y]['nombres']);}?></td>                                        
                                            <td><?php for($z=0;$z<count($dataTemaInteres);$z++){  echo "/".utf8_encode($dataTemaInteres[$z]['nombres']);}?></td>
                                            <td><?php for($x=0;$x<count($dataSecciones);$x++){  echo "/".utf8_encode($dataSecciones[$x]['nombres']);}?></td>                                            
                                            <td><?php echo utf8_encode($dataCargo[0]['nombres'])?></td>
                                            <td><?php echo  $lista[$i]["fecha_inicio"]."/".$lista[$i]["fecha_final"];?></td>
                                            <td><?php echo  utf8_encode($lista[$i]["telefonos"]."<br />Anex:".$lista[$i]["anexo"]);?></td>                                           
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              <th><input type="checkbox" /></th>
                                               
                                                <th title="Tipo Medio">T. MEDIO</th>
                                                <th>MEDIO</th>
                                                <th>CLIENTE</th>
                                                <th>T.INTERES</th>
                                                <th>SECCIÓN</th>                                          
                                                <th>CARGO</th>
                                                <th>F. INI/FIN</th>                                                
                                                <th>TEL/ANE.</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  


    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    
    <!-- x-editable (bootstrap version) -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //toggle `popup` / `inline` mode
            $.fn.editable.defaults.mode = 'inline';     
            

            //make username editable
            $('#nombres').editable({
                type: 'text' ,
                title: 'Enter username',
                value:'hola'

            });
            



        });

    </script>

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
