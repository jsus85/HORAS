<?php 
header('Content-Type: text/html; charset=UTF-8'); 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/actividad.process.php'); // Querys para Actividades y listas 
$model       = new funcionesModel();

unset($_SESSION['idSelectPeriodistas']);
unset($_SESSION['idSelectPeriodistas2']);
$ciudad      = $_POST['ciudad'];
$nombres     = $_POST['nombres'];
$nombres2    = $_POST['nombres2'];
$apellidos   = $_POST['apellidos'];

$fecha       = $_POST['fecha_nacimiento'];
$filtro = 1;
if($_POST['filtro']){
  $filtro      = $_POST['filtro'];
} 
$listaTotal  = $model->datosActividades($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccionEditar_'],$_POST['clientes'],'',$_POST['suplementos'],$_POST['ciudad'],$filtro,$_POST['nombres2'],$_POST['apellidos']);

$total       = count($listaTotal);

$pag    = $_POST['pg'];
if ($pag=='') $pag = 1;
$numPags = ceil($total/VAR_NROITEMS);
$reg     = ($pag-1) * VAR_NROITEMS;
    

$lista       = $model->datosActividadesPaginacion($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccionEditar_'],$_POST['clientes'],$_POST['suplementos'],$_POST['ciudad'],$filtro,$_POST['nombres2'],$_POST['apellidos'],$reg); 

$tipoMedios  = $model->listarTablaGeneral("id,nombres","tipo_medios","");
$suplementos = $model->listarTablaGeneral("id,nombres","suplementos","");
$Medios      = $model->listarTablaGeneral("id,nombres","medios","");
$cargos      = $model->listarTablaGeneral("id,nombres","cargos","");
$TemaInteres = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");
$Clientes    = $model->listarTablaGeneral("id,nombres","clientes"," where estado = 1  order by nombres asc");
//$SUPLEMENTOS = array_suplemento();
$ciudades = $model->listarTablaGeneral("*","ciudades","");
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
     <style type="text/css">
     .buscador{margin-left: 5px;margin-right: 10px;display: inline-block;margin: 10px;width: 30%;vertical-align: top;}
     .select1{width: 120px}
      button span{font-family: 'Open Sans', sans-serif;}
      .btn span{font-family: 'Open Sans', sans-serif;}
  
      @media screen and (max-width: 540px) {
        .buscador  {
         width: 50%;
        }
      }
     </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
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
                    <h1 class="page-header">Periodistas</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
             <form  id="form_buscar" name="form_buscar" method="post" accept-charset="utf-8">
             <input type="hidden" name="HddidActividad" id="HddidActividad" value="0" />
                <div class="panel-heading">
                    <div class="form-group1">



                        <div class="ingr">

                        <div class="buscador">
                          Filtro: 
                          <select name="filtro" id="filtro" onchange="mostrarFiltros(this.value);">
                            <option <?php if($filtro== 1){?> selected <?php }?> value="1">Nombres y Apellidos</option>
                            <option <?php if($filtro== 2){?> selected <?php }?> value="2">Igual</option>
                          </select>
                        </div>  

                        <div class="buscador HTMLperiodistas">
                         Periodista: <input type="text" onkeypress="if(event.keyCode == '13'){ buscar(); }" id="nombres"  value="<?php echo $nombres;?>" name="nombres" style="width:120px" />
                        </div>
                       
                        <div id="HTMLNombresApellidos" class="buscador">
                         Nombres: <input type="text" onkeypress="if(event.keyCode == '13'){ buscar(); }" id="nombres2"  value="<?php echo $nombres2;?>" name="nombres2" style="width:120px" /><br />

                         Apellidos:  <input type="text" onkeypress="if(event.keyCode == '13'){ buscar(); }" id="apellidos"  value="<?php echo $apellidos;?>" name="apellidos" style="width:120px" />
                        </div>

                        <div class="buscador">
                            T. Medios: 
                        <select id="tipo_medio" name="tipo_medio" class="select1"  onchange="xajax_mostrarMedioslist(this.value,'','1');">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($tipoMedios);$i++){?>
                                    <option <?php if($_POST['tipo_medio'] == $tipoMedios[$i]["id"]){?>selected<?php }?> value="<?php echo $tipoMedios[$i]["id"];?>"><?php echo utf8_encode($tipoMedios[$i]["nombres"]);?></option>    
                                    <?php }?>
                        </select>
                        </div>

                        <div class="buscador">
                        Medio:     
                       <span id="HTMLMEDIOS_1">
                        <select id="medios_1"  name="medios_1" class="select1">
                                    <option value="0">[Todos]</option>
                        </select>
                        </span>
                        </div>

                        <div class="buscador">    
                        Cargo:                        
                        <select id="cargo"  name="cargo" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($cargos);$i++){?>
                                    <option <?php if($_POST['cargo'] == $cargos[$i]["id"]){?>selected<?php }?> value="<?php echo $cargos[$i]["id"];?>"><?php echo utf8_encode($cargos[$i]["nombres"]);?></option>    
                                    <?php }?>
                        </select>
                        </div>

                       <div class="buscador">
                        T. Interes: 
                        <select id="tema_interes"  name="tema_interes"  class="select1">
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


                          <div class="buscador suplementos"> 
                           Suplementos:
                          <select id="suplementos"  name="suplementos" onchange="MostrarSeccion($('#medios_1').val(),'',this.value);" class="select1">
                          <option value="0">[Seleccionar]</option>
                          
                            <?php for($ss=0;$ss<count($suplementos);$ss++){?>
                                    <option <?php if($_POST['suplementos'] == $suplementos[$ss]["id"]){?>selected<?php }?> value="<?php echo $suplementos[$ss]["id"];?>"><?php echo utf8_encode($suplementos[$ss]["nombres"]);?></option>    
                                    <?php }?>
                          </select>
                          </div>
  


                        <div class="buscador"> 
                        Sección
                             <span id="HTTMLSeccion" name="HTTMLSeccion">
                          <select id="seccionEditar_"  name="seccionEditar_" class="select1">
                              <option>[Seleccionar]</option>
                          </select>
                          </span>
                         </div>


                        <div class="buscador"> 
                        Clientes
                            <select id="clientes"  name="clientes" class="select1">
                                 <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($Clientes);$i++){?>
                                    <option <?php if($_POST['clientes'] == $Clientes[$i]["id"]){?>selected<?php }?> value="<?php echo $Clientes[$i]["id"];?>"><?php echo utf8_encode($Clientes[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                        </div>

                        <div class="buscador">

                          Ciudad                        
                            <select id="ciudad"  name="ciudad" class="select1">
                                    <option value="0">[Todos]</option>
                                    <?php for($i=0;$i<count($ciudades);$i++){?>
                                    <option <?php if($ciudad==$ciudades[$i]["id"]){?>selected<?php }?> value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                                    <?php }?>
                            </select>
                        </div>


                        <div class="buscador" style="width: 60%;">
                          
                          <button title="Buscar Actividad del Periodista" onclick= "buscar();" class="btn btn-default" type="button" >    <i class="fa fa-search"><span>Buscar</span></i></button>
                           &nbsp;&nbsp;&nbsp;&nbsp; 
                          
                          <a id="btnLista" href="crear-lista.php" rel="modal:open" class="btn btn-info" role="button">  <i class="fa fa-edit"><span>Crear Lista</span></i></a>
                           &nbsp;&nbsp;&nbsp;&nbsp; 
                          <a id="btnLista2" href="agregar-lista.php" rel="modal:open" class="btn btn-info" role="button">  <i class="fa fa-edit"><span>Agregar más Periodistas</span></i></a>
                        </div>   

                        
                        

                        </div>

                        <!-- Botones de nuevo y Eliminar-->
                        <?php
                           if($_SESSION['sTipoUsuario']==1){
                        
                             $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 if(in_array(2, $extraer_permisos)){

                        ?>
                        
                        <div class="opci" style="width:25%">
                        
                        <div class="nuev"><a href="periodistas_nuevo.php"><img src="images/nuev.png"> Nuevo</a></div>
                        <div class="elim"><a href="#" onclick="if(confirm('&iquest;Esta seguro de eliminar registro(s)?')) xajax_deleteActividad(xajax.getFormValues('form_buscar'));" ><img src="images/elim.png"> Eliminar</a></div>
 
                       <div style="background-color: #2056b0;text-align: left;padding-left: 21px;padding-bottom: 12px;padding-top:20px;clear:both">
                      
                        <a href="#" title="Exportar a EXCEL" onclick="imprimir();" style="color:#FFF"><img height="25" src="assets/img/exc.png" /></a>&nbsp;&nbsp;
                        <a  href="#" title="Exportar a PDF" onclick="imprimirPDF();" style="color:#FFF"><img height="25" src="images/pdf.png" /></a>
                      
                      </div>


                        </div> 
                        <?php 
                            }

                      }?>   


                    </div>



                     <div class="form-group1">
                         <div style="clear:both">
                            <input type="checkbox" checked="checked" value="1" id="CHKPeriodista" name="CHKPeriodista"  /> &nbsp; Periodista  |
                            <input type="checkbox" checked="checked" value ="1" id="CHKTelefono" name="CHKTelefono"  />&nbsp; Teléfono |
                            <input type="checkbox" checked="checked" value= "1" id="CHKEmail" name="CHKEmail"  />&nbsp; Email |
                            <input type="checkbox" checked="checked" value="1" id="CHKCelular" name="CHKCelular"  /> &nbsp; Celular   |
                            <input type="checkbox" checked="checked" value="1" id="CHKTMedio" name="CHKTMedio"  /> &nbsp; T. Medio  |
                            <input type="checkbox" checked="checked" value="1" id="CHKMedio" name="CHKMedio"  /> &nbsp; Medio   |
                            <input type="checkbox" checked="checked" value="1" id="CHKCliente" name="CHKCliente"  />&nbsp; Cliente   |
                            <input type="checkbox" checked="checked" value="1" id="CHKInteres" name="CHKInteres"  /> &nbsp; T. Interes
                            <input type="checkbox" checked="checked" value="1" id="CHKSeccion" name="CHKSeccion"  /> &nbsp; Sección
                            <input type="checkbox" checked="checked" value="1" id="CHKCargo" name="CHKCargo"  /> &nbsp; Cargo
                        </div>
                       
                    </div>
                </div>
               
                    <div class="box">
                                    
                        <div class="box-body table-responsive">
                                   
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selecctall" name="selecctall" /></th>
                                                <th>PERIODISTA</th>
                                                <th>ANEXO</th>
                                                <th>TELÉFONO</th>
                                                <th>EMAIL</th>
                                                <th>CELULAR</th>
                                                <th title="Tipo Medio">T. MEDIO</th>
                                                <th>MEDIO</th>
                                                <!--<th>CLIENTE</th>-->
                                                <th>T.INTERES</th>
                                                <th>SECCIÓN</th>                                          
                                                <th>CARGO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
<?php 
                   for($i=0;$i<count($lista);$i++){
                                        
                       $dataTipoMedio   = $model->listarTablaGeneral(" nombres ","tipo_medios","where id='".$lista[$i]["tipo_medio_id"]."'");
                       $dataMedios      = $model->listarTablaGeneral(" nombres ","medios","where id='".$lista[$i]["medio_id"]."'");
                      
                       $dataClientes    = $model->listarTablaGeneral(" nombres ","clientes","where id in (".$lista[$i]["clientes_id"].") ");
                       $dataTemaInteres = $model->listarTablaGeneral(" nombres ","tema_interes","where id  in (".$lista[$i]["tema_interes"].") ");
                       
                       $dataSecciones   = $model->listarTablaGeneral(" nombres ","secciones","where id in(".$lista[$i]["secciones_id"].")");

                       $dataCargo       = $model->listarTablaGeneral(" nombres ","cargos","where id='".$lista[$i]["cargo_id"]."'");
?>
                  <tr id="rw_<?php echo $lista[$i]["periodista_id"];?>" class="odd gradeX">
                    
                                <td><input type="checkbox" class="checkbox1" id="idActividad" name="idActividad" value="<?php echo $lista[$i]["periodista_id"];?>" /></td>
                                <td><a title="Editar Actividad" href="periodistas_editar.php?id=<?php echo $lista[$i]["periodista_id"];?>.html">
                                    <?php echo utf8_encode($lista[$i]["nombres"])." ".utf8_encode($lista[$i]["apellidos"]);?></a></td>
                                <!--<td><a title="Editar Actividad" href="EditarPeriodista-<?php echo $lista[$i]["periodista_id"];?>.html">
                                    <?php echo utf8_encode($lista[$i]["nombres"])." ".utf8_encode($lista[$i]["apellidos"]);?></a></td>-->
                                <td><?php echo $lista[$i]["anexo"];?></td>
                                <td><?php echo $lista[$i]["telefono"];?></td>
                                <td><?php echo $lista[$i]["emailA"];?></td>
                                <td><?php echo $lista[$i]["celularA"];?></td>
                                <td><?php echo utf8_encode($dataTipoMedio[0]["nombres"]);?></td>
                                <td><?php echo utf8_encode($dataMedios[0]["nombres"]);?></td>

                               <!-- <td><?php for($y=0;$y<count($dataClientes);$y++){  echo "/".utf8_encode($dataClientes[$y]['nombres']);}?></td>-->                                        
                                <td><?php for($z=0;$z<count($dataTemaInteres);$z++){  echo "/".utf8_encode($dataTemaInteres[$z]['nombres']);}?></td>
                                <td><?php for($x=0;$x<count($dataSecciones);$x++){  echo "/".utf8_encode($dataSecciones[$x]['nombres']);}?></td>                                            
                                <td><?php echo utf8_encode($dataCargo[0]['nombres'])?></td>                                       
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              <th><input type="checkbox" /></th>
                                                <th>PERIODISTA</th>
                                                 <th>ANEXO</th>
                                                <th title="Tipo Medio">T. MEDIO</th>
                                                <th>MEDIO</th>
                                                <!--<th>CLIENTE</th>-->
                                                <th>T.INTERES</th>
                                                <th>SECCIÓN</th>                                          
                                                <th>CARGO</th>
                                            
                                            </tr>
                                        </tfoot>
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

<script type="text/javascript" charset="utf-8">
  $(function() {

      function showSelectedPeriodistas()
      {
        var totalPeriodistas =   $("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(",");
        return totalPeriodistas;

      }


      // enviar los peridistas seleccinados  
     $('#btnLista').click(function() {         
         $.post( "session.periodista.php", { periodistas: showSelectedPeriodistas() }, function( data ) {          
         });
      });

      // enviar los peridistas seleccinados  
     $('#btnLista2').click(function() {         
         $.post( "session.periodista.php", { periodistas2: showSelectedPeriodistas() }, function( data ) {          
         });
      });


  });

    // Mostar Lista dependen del cliente
    function mostrarListas(idCliente){
       xajax_mostrarLista(idCliente);
    }

    // Editar Lista
   function editar_lista(){

      if($('#clientesLista').val()=='0'){
          alert('* Error seleccionar Cliente.');
          $('#clientesLista').focus();
          return 0;
      }

      if($('#Lista').val()=='0'){
          alert('* Error seleccionar lista.');
          $('#Lista').focus();
          return 0;
      }

      if( $("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(",") == ''){
          alert('Error en Periodista seleccionar al menos uno.');
          return 0;
      }

      xajax_modificarLista($('#Lista').val(),$('#clientesLista').val(),$("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));


   } // END


    // Guardar Lista
   function guardar_lista(){
     
      if($('#nombreLista').val()==''){
          alert('* Error nombre de lista.');
          $('#nombreLista').focus();
          return 0;
      }
      
      if($('#clientesLista').val()=='0'){
          alert('* Error seleccionar Cliente.');
          $('#clientesLista').focus();
          return 0;
      }

      if( $("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(",") == ''){
          alert('Error en Periodista seleccionar al menos uno.');
          return 0;
      }

      xajax_crearLista($('#nombreLista').val(),$('#clientesLista').val(),$("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));          
   }

</script>
    <!-- End Modal-->

        <!-- page script -->
        <script type="text/javascript">

           // para hacer la busqueda
          function buscar(){
            document.form_buscar.target='_self';
            document.form_buscar.action = 'actividades.php';
            document.form_buscar.submit();
          
          }

          function imprimirPDF(){

            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));
            document.form_buscar.target='_blank';
            document.form_buscar.action = 'imprimir.php';
            document.form_buscar.submit();
          }
          
         function imprimir(){

            var tipo_medio     = document.getElementById('tipo_medio').value;   
            var nombres        = document.getElementById('nombres').value;
            var medios         = document.getElementById('medios_1').value;   
            var cargo          = document.getElementById('cargo').value;   
            //var tema_interes   = document.getElementById('tema_interes').value;   
            var seccion        = document.getElementById('seccionEditar_').value;   
            var clientes       = document.getElementById('clientes').value;   
            
            $('#HddidActividad').val($("input[name=idActividad]:checked").map(function () {return this.value;}).get().join(","));

            document.form_buscar.target='_blank';
            document.form_buscar.action = 'actividad-download-xlsx.php';
            document.form_buscar.submit();

        }

      // ----- ocultar columnas de la tabla -----
            $( "#CHKPeriodista" ).click(function() {
                if($('#CHKPeriodista').is(':checked')){
                     $('#example2 th:eq(1)').show();$('#example2 td:nth-child(2)').show();
                 } else{
                     $('#example2 th:eq(1)').hide();$('#example2 td:nth-child(2)').hide();
                 }
            });

            $( "#CHKTelefono" ).click(function() {
                if($('#CHKTelefono').is(':checked')){
                     $('#example2 th:eq(2)').show();$('#example2 td:nth-child(3)').show();
                 } else{
                     $('#example2 th:eq(2)').hide();$('#example2 td:nth-child(3)').hide();
                 }
            });

        $( "#CHKEmail" ).click(function() {
                if($('#CHKEmail').is(':checked')){
                     $('#example2 th:eq(3)').show();$('#example2 td:nth-child(4)').show();
                 } else{
                     $('#example2 th:eq(3)').hide();$('#example2 td:nth-child(4)').hide();
                 }
            });


             $( "#CHKCelular" ).click(function() {
                if($('#CHKCelular').is(':checked')){
                     $('#example2 th:eq(4)').show();$('#example2 td:nth-child(5)').show();
                 } else{
                     $('#example2 th:eq(4)').hide();$('#example2 td:nth-child(5)').hide();
                 }
            });


              $( "#CHKTMedio" ).click(function() {
                if($('#CHKTMedio').is(':checked')){
                     $('#example2 th:eq(5)').show();$('#example2 td:nth-child(6)').show();
                 } else{
                     $('#example2 th:eq(5)').hide();$('#example2 td:nth-child(6)').hide();
                 }
            });

                $( "#CHKMedio" ).click(function() {
                if($('#CHKMedio').is(':checked')){
                     $('#example2 th:eq(6)').show();$('#example2 td:nth-child(7)').show();
                 } else{
                     $('#example2 th:eq(6)').hide();$('#example2 td:nth-child(7)').hide();
                 }
            });


              $( "#CHKCliente" ).click(function() {
                if($('#CHKCliente').is(':checked')){
                     $('#example2 th:eq(7)').show();$('#example2 td:nth-child(8)').show();
                 } else{
                     $('#example2 th:eq(7)').hide();$('#example2 td:nth-child(8)').hide();
                 }
            });


              $( "#CHKInteres" ).click(function() {
                if($('#CHKInteres').is(':checked')){
                     $('#example2 th:eq(8)').show();$('#example2 td:nth-child(9)').show();
                 } else{
                     $('#example2 th:eq(8)').hide();$('#example2 td:nth-child(9)').hide();
                 }
            });


              $( "#CHKSeccion" ).click(function() {
                if($('#CHKSeccion').is(':checked')){
                     $('#example2 th:eq(9)').show();$('#example2 td:nth-child(10)').show();
                 } else{
                     $('#example2 th:eq(9)').hide();$('#example2 td:nth-child(10)').hide();
                 }
            });

             $( "#CHKCargo" ).click(function() {
                if($('#CHKCargo').is(':checked')){
                     $('#example2 th:eq(10)').show();$('#example2 td:nth-child(11)').show();
                 } else{
                     $('#example2 th:eq(10)').hide();$('#example2 td:nth-child(11)').hide();
                 }
            });    

            // ----- ocultar columnas de la tabla -----

            function mostrarFiltros(data){

                if(data==1){

                  $('.HTMLperiodistas').show();
                  $('#HTMLNombresApellidos').hide();
                 
                  $('#nombres2').val('');
                  $('#apellidos').val('');

                }

                 if(data==2){
                  
                  $('#HTMLNombresApellidos').show();
                  $('.HTMLperiodistas').hide();
                  $('#nombres').val('');

                }

            }


       function MostrarSeccion(valor,selected,suplemento){
      
        $.post("dataSecc.php", { medio: valor , select:selected ,suplemento:suplemento} , function( data ) {
          $( "#HTTMLSeccion" ).html( data );
          $( "#seccionEditar_" ).removeClass("form-control");
        });
    }

            $(function() {
               <?php if($_POST['filtro']){?>

              mostrarFiltros('<?php echo $filtro;?>');
              <?php } ?>

              $('#suplementos').hide();
              $('.suplementos').hide();
              $('#HTMLNombresApellidos').hide();

              <?php if($_POST['tipo_medio']!=0){?>
                xajax_mostrarMedioslist('<?php echo $_POST['tipo_medio'];?>','<?php echo $_POST['medios_1'];?>','1');
                <?php } 

                if($_POST['medios_1']!=0){?>

                MostrarSeccion('<?php echo $_POST['medios_1']?>','<?php echo $_POST['seccionEditar_'];?>','<?php  echo $_POST['suplemento'] ?>');
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
</body>

</html>
