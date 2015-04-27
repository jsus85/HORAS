<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/periodistas.process.php');
$model       = new funcionesModel();

$ciudad      = $_POST['ciudad'];
$nombres     = $_POST['nombres'];
$fecha       = $_POST['fecha_nacimiento'];

$listaTotal  = $model->datosPeriodista($_POST['nombres'],$ciudad,$fecha,$_POST['cargo'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['clientes'],$_POST['tema_interes'],$_POST['seccionEditar_']);

$cargos      = $model->listarTablaGeneral("id,nombres","cargos","");
$tipoMedios  = $model->listarTablaGeneral("id,nombres","tipo_medios","");
$Medios      = $model->listarTablaGeneral("id,nombres","medios","");
$TemaInteres = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");
$Clientes    = $model->listarTablaGeneral("id,nombres","clientes"," where estado = 1  order by nombres asc");

$total       = count($listaTotal);

$pag    = $_POST['pg'];
if ($pag=='') $pag = 1;
$numPags = ceil($total/VAR_NROITEMS);
$reg     = ($pag-1) * VAR_NROITEMS;
    

$lista   = $model->datosPeriodistaPaginacion($nombres,$ciudad,$fecha,$_POST['cargo'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['clientes'],$_POST['tema_interes'],$_POST['seccionEditar_'],$reg);



$ciudades = $model->listarTablaGeneral("*","ciudades","");
$cobertura   = array_cobertura();
$periocidad  = array_periocidad();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css tables -->
    <link href="table.css" rel="stylesheet" type="text/css" />
    <title>Intranet Periodistas | Pacific Latam</title>
    <!-- Core CSS - Include with every page -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek,cyrillic' rel='stylesheet' type='text/css'>    
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- css tables -->
     <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css" media="screen">
        .ingr{width: auto;}  
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
                    <h1 class="page-header">Mantenimientos de Periodistas</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form action="periodistas.php" id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
                <div class="panel-heading">
                    <div class="form-group1">
                        
                        <div class="ingr">
                            T. Medios: 
                        <select id="tipo_medio" name="tipo_medio" class="select1"  onchange="xajax_mostrarMedioslist(this.value,'','1');">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($tipoMedios);$i++){?>
                                    <option <?php if($_POST['tipo_medio'] == $tipoMedios[$i]["id"]){?>selected<?php }?> value="<?php echo $tipoMedios[$i]["id"];?>"><?php echo utf8_encode($tipoMedios[$i]["nombres"]);?></option>    
                                    <?php }?>
                        </select>
                        </div> 

                       <div class="ingr">
                        Medio:     
                        <span id="HTMLMEDIOS_1">
                        <select id="medios"  name="medios" class="select1">
                                    <option value="0">[Todos]</option>
                        </select>
                        </span>
                        </div>

                        <div class="ingr">    
                        Cargo:                        
                        <select id="cargo"  name="cargo" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($cargos);$i++){?>
                                    <option <?php if($_POST['cargo'] == $cargos[$i]["id"]){?>selected<?php }?> value="<?php echo $cargos[$i]["id"];?>"><?php echo utf8_encode($cargos[$i]["nombres"]);?></option>    
                                    <?php }?>
                        </select>
                        </div>
                        
                        <div class="ingr">
                        Ciudad                        
                            <select id="ciudad" onchange="document.form_buscar.submit();" name="ciudad" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($ciudades);$i++){?>
                                    <option <?php if($ciudad==$ciudades[$i]["id"]){?>selected<?php }?> value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                         </div>    
                         


                          <div class="ingr">Nombres <input type="text" id="nombres" value="<?php echo $nombres;?>" name="nombres"></div>

                        
                                
                               
                        </div>
                   <div class="form-group1">
                    <div class="ingr">
                            T. Interes: 
                        <select id="tema_interes"  name="tema_interes" onchange="xajax_consultarSeccion(this.value,'');" class="select1">
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
                        </select></div>

                  <div class="ingr"> 
                        Clientes
                            <select id="clientes"  name="clientes" class="select1">
                                 <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($Clientes);$i++){?>
                                    <option <?php if($_POST['clientes'] == $Clientes[$i]["id"]){?>selected<?php }?> value="<?php echo $Clientes[$i]["id"];?>"><?php echo utf8_encode($Clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                         </div>
  
                      <div class="ingr"> 
                      Sección
                          <span id="HTTMLSeccion" name="HTTMLSeccion">
                          <select id="seccion"  name="seccion" class="select1">
                              <option>[Seleccionar]</option>
                          </select>
                          </span>
                       </div>

                          <div class="ingr">
                            <button title="Buscar Actividad del Periodista" class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i>
                            </button>
                          </div>

                          <a href="test.php?punto=ssssssssss" rel="modal:open">first example</a>

                </div>
                    
                    </div>

                    <div class="form-group1">
                         <div style="clear:both">
                         <input type="checkbox" checked="checked" value="1" id="CHKCodigo" name="CHKCodigo"  /> &nbsp; Código   |
                         <input type="checkbox" checked="checked" value ="1" id="CHKNombres" name="CHKNombres"  />&nbsp; Nombres |
                         <input type="checkbox" checked="checked" value= "1" id="CHKTelefonos" name="CHKTelefonos"  />&nbsp; Teléfonos |
                         <input type="checkbox" checked="checked" value="1" id="CHKAnexo" name="CHKAnexo"  /> &nbsp; Anexo   |
                         <input type="checkbox" checked="checked" value="1" id="CHKMovil" name="CHKMovil"  /> &nbsp; Movil   |
                         <input type="checkbox" checked="checked" value="1" id="CHKEmail" name="CHKEmail"  /> &nbsp; Email   |
                         <input type="checkbox" checked="checked" value="1" id="CHKCumple" name="CHKCumple"  />&nbsp; Cumpleaños   |
                        <input type="checkbox" checked="checked" value="1" id="CHKCiudad" name="CHKCiudad"  /> &nbsp; Ciudad  
                        </div>
                       
                    </div>
                      <div class="form-group1">
                              
                              <a href="#" onclick="imprimir();" style="color:#FFF !important"><img height="25" src="assets/img/exc.png" />&nbsp;<b>EXPORTAR A EXCEL</b></a>
                              
                          <!-- Botones de nuevo y Eliminar-->
                        <?php                                                   
                           
                            if($_SESSION['sTipoUsuario']==1){
                                
                                 $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 
                                 if(in_array(2, $extraer_permisos)){

                            ?>

                              <div class="nuev">
                              <a style="color: #FFF !important" href="periodistas_nuevo.php"><img src="images/nuev.png"> Nuevo</a>
                              </div>
                              
                              <div class="elim"><a href="#" style="color: #FFF !important" onclick="if(confirm('&iquest;Esta seguro de eliminar registro(s)?')) xajax_deletePeriodista(xajax.getFormValues('form_buscar'));" ><img src="images/elim.png"> Eliminar</a>
                              </div> 
                       <?php
                                }// End permiso

                         }// Tipo Usuario ?>
                      </div>

                </div>
               
                    <div class="box">
                                    
                        <div class="box-body table-responsive">
                                   
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" /></th>
                                                <th title="Tipo de Medio">CODIGO</th>
                                                <th>NOMBRES</th>
                                                <th>TELEFONOS</th>
                                                <th>ANEX.</th>
                                                <th>MOVIL</th>
                                                <th>EMAIL #1</th>
                                                <th>CUMPLEAÑOS</th>                                          
                                                <th>CIUDAD</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                     <?php 

                                        for($i=0;$i<count($lista);$i++){

                                        $data1 = $model->listarTablaGeneral(" nombres ","ciudades","where id='".$lista[$i]["ciudad_id"]."'");
                                        ?>
                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            <td><input type="checkbox" id="idPeriodista[]" name="idPeriodista[]" value="<?php echo $lista[$i]["id"];?>" /></td>
                                            <td><?php echo $lista[$i]["codigo"];?></td>
                                            <!--<td><a title="Editar Periodista" href="EditarPeriodista-<?php echo $lista[$i]["id"];?>.html"><?php echo utf8_encode($lista[$i]["nombres"]);?></a></td>-->
                                            <td><a title="Editar Periodista" href="periodistas_editar.php?id=<?php echo $lista[$i]["id"];?>"><?php echo utf8_encode($lista[$i]["nombres"]);?></a></td>
                                            <td><?php echo utf8_encode($lista[$i]["telefono"]);?></td>
                                            <td><?php echo utf8_encode($lista[$i]["anexo"]);?></td>
                                            <td><?php echo utf8_encode($lista[$i]["celularA"]);?></td>
                                            <td><?php echo $lista[$i]["emailA"];?></td>
                                            
                                            <td><?php echo $lista[$i]["nacimiento"];?></td>                                            
                                            <td><?php echo utf8_encode($data1[0]["nombres"]);?></td>
                                           
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
                                        <!--
                             $('#example2 th:eq(0)').hide();$('#example2 td:nth-child(1)').hide();
                                        <thead>
                                            <tr>
                                            <th><input type="checkbox" /></th>
                                                <th title="Tipo de Medio">CODIGO</th>
                                                <th>NOMBRES</th>
                                                <th>TELEFONOS+ANEX.</th>
                                                <th>MOVIL</th>
                                                <th>EMAIL #1</th>
                                                
                                                <th>CUMPLEAÑOS</th>                                          
                                                <th>CIUDAD</th>
                                          
                                            </tr>
                                        </thead>-->
                                    </table>
                                       <?php include ("sisweb_incpaginacion.php");?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
        <!-- DATA TABES SCRIPT -->
        <script src="assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="assets//plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

      <script src="assets/plugins/modal/jquery.modal.js" type="text/javascript" charset="utf-8"></script>
      <link rel="stylesheet" href="assets/plugins/modal/jquery.modal.css" type="text/css" media="screen" />
      <script src="assets/plugins/modal/highlight/highlight.pack.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript" charset="utf-8">
      hljs.initHighlightingOnLoad(); 
      </script>

        <!-- page script -->
        <script type="text/javascript">
        function imprimir(){

            var ciudad   = document.getElementById('ciudad').value;   
            var nombres  = document.getElementById('nombres').value;
            var codigo   = null;            
            var name  = null;
            var telefonos  = null;       
            var anexo  = null; 
            var movil  = null; 
            var email  = null; 
            var cumpleanios  = null; 
            var ciuda  = null; 

            if($('#CHKCodigo').is(':checked')){ codigo = 1;}else{codigo = 0;}
            if($('#CHKNombres').is(':checked')){ name = 1;}else{ name = 0;}
            if($('#CHKTelefonos').is(':checked')){ telefonos = 1;}else{telefonos = 0;}
            if($('#CHKAnexo').is(':checked')){ anexo = 1;}else{anexo = 0;}            
            if($('#CHKMovil').is(':checked')){ movil = 1;}else{movil = 0;}            
            if($('#CHKEmail').is(':checked')){ email = 1;}else{email = 0;}
            if($('#CHKCumple').is(':checked')){ cumpleanios = 1;}else{cumpleanios = 0;}
            if($('#CHKCiudad').is(':checked')){ ciuda = 1;}else{ciuda = 0;}
         

            window.location  ='01simple-download-xlsx.php?ciudad='+ciudad+'&nombres='+nombres+'&codigo='+codigo+'&name='+name+'&telefonos='+telefonos+'&anexo='+anexo+'&movil='+movil+'&email='+email+'&cumpleanios='+cumpleanios+'&ciu='+ciuda ;

        }

            // ----- ocultar columnas de la tabla -----
            $( "#CHKCodigo" ).click(function() {
                if($('#CHKCodigo').is(':checked')){
                     $('#example2 th:eq(1)').show();$('#example2 td:nth-child(2)').show();
                 } else{
                     $('#example2 th:eq(1)').hide();$('#example2 td:nth-child(2)').hide();
                 }
            });

            $( "#CHKNombres" ).click(function() {
                if($('#CHKNombres').is(':checked')){
                     $('#example2 th:eq(2)').show();$('#example2 td:nth-child(3)').show();
                 } else{
                     $('#example2 th:eq(2)').hide();$('#example2 td:nth-child(3)').hide();
                 }
            });

            $( "#CHKTelefonos" ).click(function() {
                if($('#CHKTelefonos').is(':checked')){
                     $('#example2 th:eq(3)').show();$('#example2 td:nth-child(4)').show();
                 } else{
                     $('#example2 th:eq(3)').hide();$('#example2 td:nth-child(4)').hide();
                 }
            });

            $( "#CHKAnexo" ).click(function() {
                if($('#CHKAnexo').is(':checked')){
                     $('#example2 th:eq(4)').show();$('#example2 td:nth-child(5)').show();
                 } else{
                     $('#example2 th:eq(4)').hide();$('#example2 td:nth-child(5)').hide();
                 }
            });

            $( "#CHKMovil" ).click(function() {
                if($('#CHKMovil').is(':checked')){
                     $('#example2 th:eq(5)').show();$('#example2 td:nth-child(6)').show();
                 } else{
                     $('#example2 th:eq(5)').hide();$('#example2 td:nth-child(6)').hide();
                 }
            });

            $( "#CHKEmail" ).click(function() {
                if($('#CHKEmail').is(':checked')){
                     $('#example2 th:eq(6)').show();$('#example2 td:nth-child(7)').show();
                 } else{
                     $('#example2 th:eq(6)').hide();$('#example2 td:nth-child(7)').hide();
                 }
            });

            $( "#CHKCumple" ).click(function() {
                if($('#CHKCumple').is(':checked')){
                     $('#example2 th:eq(7)').show();$('#example2 td:nth-child(8)').show();
                 } else{
                     $('#example2 th:eq(7)').hide();$('#example2 td:nth-child(8)').hide();
                 }
            });

            $( "#CHKCiudad" ).click(function() {
                if($('#CHKCiudad').is(':checked')){
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();
                 } else{
                     $('#example2 th:eq(8)').hide();$('#example2 td:nth-child(9)').hide();
                 }
            });
            // ----- ocultar columnas de la tabla -----


    function MostrarSeccion(valor,selected){
      
        $.post("dataSecc.php", { medio: valor , select:selected } , function( data ) {
          $( "#HTTMLSeccion" ).html( data );
          $( "#seccionEditar_" ).removeClass("form-control");
        });
    }

            $(function() {              

                <?php if($_POST['tipo_medio']!=0){?>
                xajax_mostrarMedioslist('<?php echo $_POST['tipo_medio'];?>','<?php echo $_POST['medios_1'];?>','1');
                <?php } 

                if($_POST['medios_1']!=0){?>

                MostrarSeccion('<?php echo $_POST['medios_1']?>','<?php echo $_POST['seccionEditar_'];?>');
               <?php }   ?> 
               
                $('#example2').dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": true
                });
            });
        </script>

       
<style type="text/css">
  .modal a.close-modal[class*="icon-"] {top: -10px;right: -10px;width: 20px;height: 20px;color: #fff;line-height: 1.25;text-align: center;text-decoration: none;  text-indent: 0;background: #900;border: 2px solid #fff;-webkit-border-radius: 26px;-moz-border-radius: 26px;-o-border-radius: 26px;-ms-border-radius: 26px;-moz-box-shadow:    1px 1px 5px rgba(0,0,0,0.5);-webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.5);box-shadow:1px 1px 5px rgba(0,0,0,0.5);}
</style>

<script type="text/javascript" charset="utf-8">
  $(function() {


    $(document).on($.modal.BEFORE_BLOCK, log_modal_event);
    $(document).on($.modal.BLOCK, log_modal_event);
    $(document).on($.modal.BEFORE_OPEN, log_modal_event);
    $(document).on($.modal.OPEN, log_modal_event);
    $(document).on($.modal.BEFORE_CLOSE, log_modal_event);
    $(document).on($.modal.CLOSE, log_modal_event);
    $(document).on($.modal.AJAX_SEND, log_modal_event);
    $(document).on($.modal.AJAX_SUCCESS, log_modal_event);
    $(document).on($.modal.AJAX_COMPLETE, log_modal_event);

    $('#more').click(function() {
      $(this).parent().after($(this).parent().next().clone());
      $.modal.resize();
      return false;
    });

    $('#manual-ajax').click(function(event) {
      event.preventDefault();
      $.get(this.href, function(html) {
        $(html).appendTo('body').modal();
      });
    });

    $('a[href="#ex5"]').click(function(event) {
      event.preventDefault();
      $(this).modal({
        escapeClose: false,
        clickClose: false,
        showClose: false
      });
    });

    $('a[href="#ex7"]').click(function(event) {
      event.preventDefault();
      $(this).modal({
        fadeDuration: 250
      });
    });

    $('a[href="#ex8"]').click(function(event) {
      event.preventDefault();
      $(this).modal({
        fadeDuration: 1000,
        fadeDelay: 0.50
      });
    });

    $('a[href="#ex9"]').click(function(event) {
      event.preventDefault();
      $(this).modal({
        fadeDuration: 1000,
        fadeDelay: 1.75
      });
    });

    $('a[href="#ex10"]').click(function(event){
      event.preventDefault();
      $(this).modal({
        closeClass: 'icon-remove',
        closeText: '!'
      });
    });

  });
</script>
</body>

</html>
