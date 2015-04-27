<?php 
session_start();
include('validar.session.php');
include("model/functions.php");
include('controllers/periodistas.process.php');
$model       = new funcionesModel();
$ciudades = $model->listarTablaGeneral("*","ciudades","");
$cobertura   = array_cobertura();
$periocidad  = array_periocidad();
//$SUPLEMENTOS = array_suplemento();

$tipo_medios = $model->listarTablaGeneral("*","tipo_medios","");

$periodistas   = $model->listarTablaGeneral(" apellidos,nombres,telefono,telefonoB,telefonoC,anexo,celularA,celularB,celularC,emailA,emailB,emailC,nacimiento,comentarios,foto,direccion,cv,ciudad_id,tema_interes,sexo ","periodistas","where id='".mysql_real_escape_string($_GET['id'])."'");
$Cargos       = $model->listarTablaGeneral("id,nombres","cargos"," order by nombres asc");
$TemaInteres = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");

$dia   = substr($periodistas[0]['nacimiento'], 8,10);
$mes   = substr($periodistas[0]['nacimiento'], 5,2);
$anio  = substr($periodistas[0]['nacimiento'], 0,4);
$suplementos = $model->listarTablaGeneral("id,nombres","suplementos"," order by nombres asc");
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
    <style type="text/css" media="screen">
    .form-control{ display: inline-block;width: 80%;  }    
    .show-grid [class^="col-"]{ font-size: 14px;}
    .paginas{float: left;width: 33%}
     .Actividades{float: left;width: 100%;margin-top: 5px;margin-bottom: 5px}
     a{cursor: pointer;}
</style>

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
                        
                        <div class="opci" style="width:100%">
                        
                        <?php                                                   
                           
                        if($_SESSION['sTipoUsuario']==1){
                            
                             $extraer_permisos = explode(",", $_SESSION['sPermisos']);                             
                             if(in_array(2, $extraer_permisos)){

                        ?>    
                        <div class="nuev"><a href="#" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));"><img src="images/guar.png"> Guardar</a></div>
                        <div class="edit"><a onclick="xajax_borrarPeriodista('<?php echo $_GET['id']?>')" href="#"><img src="images/elim.png"> Eliminar Periodista</a></div>
                        <?php
                                }// End permiso

                         }// Tipo Usuario ?>

                        <div class="elim"><a href="actividades.php"><img src="images/cerr.png"> Cerrar</a></div>

                         <div style="float:right">
                             
                             <a id="btnLista" href="vista_previa_asistencias.php?idperiodista=<?php echo $_GET['id'];?>" rel="modal:open" class="btn1 btn-primary" role="button">Total de Difusiones</a>

                             <a href="reporte-periodista-eventos.php?idperiodista=<?php echo $_GET['id'];?>" target="_blank" title="Exportar a EXCEL" style="color:#FFF"><img height="25" src="assets/img/exc.png" /></a>
                              &nbsp;&nbsp;
                              
                             <a  href="pdf_detalle_eventos.php?idperiodista=<?php echo $_GET['id'];?>" title="Exportar a PDF" target="_blank"  style="color:#FFF"><img height="25" src="images/pdf.png" /></a>
                            </div>
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

                        <div class="row show-grid">
                             <div class="col-md-4">
                                <?php if($periodistas[0]['foto']!=''){?>
                                <img src="images/periodistas/<?php echo $periodistas[0]['foto'];?>" width="150" height="150"  />
                                <?php }else{?>
                                <img src="images/No_imagen_disponible.gif" width="150" height="150"  />                        
                                <?php }?>
                                <p><input type="file" id="foto" name="foto"  />
                                <?php                                                   
                                if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                 if(in_array(2, $extraer_permisos)){
                                ?>
                                <button type="button" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar</button>
                                <?php
                                    }// End permiso
                                 }// Tipo Usuario 
                                 ?>
                                </p>
                             </div>

                            <div class="col-md-4" style="width:65%" >
                                 Observaciones  :<br />
                                 <input type="text" id="comentario"  style="width:90%;border:1px solid red"  value="<?php echo $periodistas[0]['comentarios'];?>" name="comentarios" class="form-control" />
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','comentarios',$('#comentario').val());"><img src="assets/img/save.png"  /></a>
                             </div>


                             <div class="col-md-4">
                             Nombres<br />
                             <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo utf8_encode($periodistas[0]['nombres']);?>" />
                            <?php                                                   
                             if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                             <a title="Editar Nombres" onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','nombres',$('#nombres').val());" ><img src="assets/img/save.png" /></a>
                             <?php
                                }// End permiso
                             }// Tipo Usuario 
                             ?>
                             </div>   

                             <div class="col-md-4">
                             Apellidos<br />
                             <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo utf8_encode($periodistas[0]['apellidos']);?>" />
                             <?php                                                   
                             if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                             ?>
                             <a title="Editar Nombres" onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','apellidos',$('#apellidos').val());" ><img src="assets/img/save.png" /></a>
                             <?php
                                }// End permiso
                             }// Tipo Usuario 
                             ?>
                             </div>


                                                           
                             <div class="col-md-4">
                                 Teléfono #1 <br />
                                 <input type="text" id="telefono" name="telefono" value="<?php echo $periodistas[0]['telefono'];?>" class="form-control" />
                                 <?php                                                   
                                if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                     if(in_array(2, $extraer_permisos)){
                                 ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','telefono',$('#telefono').val());" ><img src="assets/img/save.png" /></a>
                                 <?php
                                    }// End permiso
                                 }// Tipo Usuario 
                               ?>
                             </div>

                            <div class="col-md-4">
                                  Anexo: <br />
                                   <input type="text" id="anexo" name="anexo" class="form-control" value="<?php echo $periodistas[0]['anexo'];?>" />

                                    <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                    ?>

                                    <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','anexo',$('#anexo').val());" ><img src="assets/img/save.png" /></a>
                                    <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                   ?>
                              </div>


                             <div class="col-md-4">
                                 Teléfono #2 <br />
                                 <input type="text" id="telefono2" name="telefono2" value="<?php echo $periodistas[0]['telefonoB'];?>" class="form-control" />
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','telefonoB',$('#telefono2').val());" ><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                 ?>
                             </div>

                            <div class="col-md-4">
                                 Teléfono #3 <br />
                                 <input type="text" id="telefono3" name="telefono3" value="<?php echo $periodistas[0]['telefonoC'];?>" class="form-control" />
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','telefonoC',$('#telefono3').val());" ><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                 ?>
                             </div>

                             
                             
                             <div class="col-md-4">
                                 Celular #1: <br />
                                 <input type="text" id="celularA" name="celularA" value="<?php echo $periodistas[0]['celularA'];?>" class="form-control" />
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','celularA',$('#celularA').val());"><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                 ?>
                             </div>   

                             <div class="col-md-4">
                                   Celular #2:<br />
                                   <input type="text" id="celularB" name="celularB" class="form-control" value="<?php echo $periodistas[0]['celularB'];?>" />
                                    <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                   <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','celularB',$('#celularB').val());"><img src="assets/img/save.png" /></a>
                                   <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                    ?>
                             </div>

                             <div class="col-md-4">
                                   Celular #3:<br />
                                   <input type="text" id="celularC" name="celularC" class="form-control" value="<?php echo $periodistas[0]['celularC'];?>" />
                                   <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                   <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','celularC',$('#celularC').val());"><img src="assets/img/save.png" /></a>
                                   <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                    ?>
                             </div>



                             <div class="col-md-4">
                                 Email #1: <br />
                                <input type="text" id="emailA"  value="<?php echo $periodistas[0]['emailA'];?>" name="emailA" class="form-control" />
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','emailA',$('#emailA').val());" ><img src="assets/img/save.png" /></a>
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                    ?>                               
                             </div>

                             <div class="col-md-4">
                                Email #2: <br />
                                <input type="text" id="emailB" style="width:80%"value="<?php echo $periodistas[0]['emailB'];?>" name="emailB" class="form-control" />
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                  ?>
                                <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','emailB',$('#emailB').val());"><img src="assets/img/save.png" /></a>   
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>                             
                             </div>

                            <div class="col-md-4">
                                Email #3: <br />
                                <input type="text" id="emailC" style="width:80%"value="<?php echo $periodistas[0]['emailC'];?>" name="emailC" class="form-control" />
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','emailC',$('#emailC').val());"><img src="assets/img/save.png" /></a>
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>                                
                             </div>

                            
                            <div class="col-md-4">
                                Ciudad: <br /> 
                                <select id="ciudad" name="ciudad" class="form-control" onchange="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','ciudad_id',this.value);">
                                <option value="0">[Todos]</option>
                                <?php for($i=0;$i<count($ciudades);$i++){?>
                                <option <?php if($periodistas[0]['ciudad_id']==$ciudades[$i]["id"]){?> selected <?php }?> value="<?php echo $ciudades[$i]["id"];?>"><?php echo utf8_encode($ciudades[$i]["nombres"]);?></option>    
                                <?php }?>
                                </select>
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','ciudad_id',$('#ciudad').val());"><img src="assets/img/save.png"  /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             </div>

                            <div class="col-md-4">
                                 Dirección :<br />
                                
                                   <input type="text" id="direccion"   value="<?php echo $periodistas[0]['direccion'];?>" name="direccion" class="form-control" />
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','direccion',$('#direccion').val());"><img src="assets/img/save.png"  /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             </div>


                             <div class="col-md-4">
                                 Cumpleaños: <br />
                                 <input type="text" id="nacimiento"   value="<?php echo $dia."-".$mes."-".$anio;?>" name="nacimiento" class="form-control" />
                                 <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','nacimiento',$('#nacimiento').val());"><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             </div>

                                <div class="col-md-4">

                                    Sexo:<br />                                   
                                    <input type="radio" <?php if($periodistas[0]['sexo']=='M'){?>checked <?php }?> name="sexo" value="M" /> Masculino &nbsp;&nbsp;
                                    <input type="radio" <?php if($periodistas[0]['sexo']=='F'){?>checked <?php }?> name="sexo" value="F" /> Femenino  
                                    <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                 <a onclick="xajax_EditarDatosPeriodista('<?php echo $_GET['id'];?>','sexo', $('input:radio[name=sexo]:checked').val() );"><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                                </div> 


                                  <?php
                           // ############## TEMA DE INTERES ################## 
                           $TemaInteres2 = $model->listarTablaGeneral("id,nombres ","tema_interes"," where id in (".$periodistas[0]["tema_interes"].")  order by nombres asc ");
                           $TemaInteres  = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");               
                             for($TEi=0;$TEi<count($TemaInteres2);$TEi++){
                           ?>
                            <div class="col-md-4">
                                Tema de Interés:<br />
                            <select id="TemaEditar1[]"  name="TemaEditar1[]" class="form-control">
                                <option value="0">[Todos]</option>
                                <?php  for($z=0;$z<count($TemaInteres);$z++){?>
                                <option <?php if($TemaInteres2[$TEi]['id']==$TemaInteres[$z]["id"]){?> selected <?php }?> value="<?php echo $TemaInteres[$z]["id"];?>"><?php echo utf8_encode($TemaInteres[$z]["nombres"]);?></option>    

                                <?php 
                                $TemaInteres3 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$z]["id"]."' order by nombres asc");

                                for($y=0;$y<count($TemaInteres3);$y++){
                                ?>
                                <option <?php if($TemaInteres2[$TEi]['id']==$TemaInteres3[$y]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres3[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres3[$y]["nombres"]);?></option> 

                                <?php }// For 2?>

                                <?php }// End For 1?>
                                </select>
                            </div>  
                            <?php  } // FOR ?>  
                              <div class="col-md-4">
                                 Tema de Interés:<br />  
                                 <a title="Clic Agregar Tema Interes" style="cursor:pointer" onclick="AgregasTemaInteres('1');" >Agregar <img src="assets/img/new.png" /></a>
                                 
                              </div>   
                                <div id="HTMLTemaInteres1"></div>

                             
                             

                             <div style="clear: both;padding-top: 20px;text-align: left;">
                             PERFIL  :<br /><br />
                             <textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $periodistas[0]['cv'];?></textarea>
                            <br /> 
                             <div>
                                <center>    
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <button type="button" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar Periodista</button>
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                                </center>
                            </div>
                             </div> 

                        </div>
                        
                            <!-- --------------------------- Actividades --------------------------------- -->

                           <br> 
                        <div class="panel panel-default">
                            <h1 class="page-header" style="margin-top:1px">Actividades</h1>
                        <?php 
                        // -------------------- SQL Actividades ------------ 
                        $lista  = $model->datosActividadesPeriodista($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccion'],$_POST['clientes'],$_GET['id']);
                      
                ?>
                               
              <div class="row show-grid">
                                            
<?php 
                   for($i=0;$i<count($lista);$i++){
                                        
                       $Medios = $model->listarTablaGeneral("id,nombres","medios"," where tipo_medios_id = '".$lista[$i]["tipo_medio_id"]."' and estado = 1 order by nombres asc ");                       
                       $dataSecciones   = $model->listarTablaGeneral(" nombres ","secciones","where id in(".$lista[$i]["secciones_id"].")");


?>                             

                             <div id="HTML_Actividad<?php echo $i;?>"> 
                             
                             <input type="hidden" name="idActividad_<?php echo $i;?>" id="idActividad_<?php echo $i;?>" value="<?php echo $lista[$i]["id"];?>" /> 
                              <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                             <div style="text-align: right;padding: 10px;">ELIMINAR ACTIVIDAD
                                <button title="Eliminar Registro" onclick="xajax_EliminarActividad('<?php echo $lista[$i]["id"];?>','<?php echo $i;?>');" type="button" style="background:red" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></button>      
                             </div>
                             <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             <div class="col-md-4">
                                <b>Tipo Medio:</b> <br />
                                
                                <select id="tipo_medio_<?php echo $i;?>" onchange="xajax_mostrarMedios(this.value,'',<?php echo $i;?>);" name="tipo_medio_<?php echo $i;?>" class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php for($TPi=0;$TPi<count($tipo_medios);$TPi++){?>
                                    <option <?php if($lista[$i]["tipo_medio_id"]==$tipo_medios[$TPi]["id"]){?>selected<?php }?> value="<?php echo $tipo_medios[$TPi]["id"];?>"><?php echo utf8_encode($tipo_medios[$TPi]["nombres"]);?></option>    
                                    <?php }?>
                                </select>
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','tipo_medio_id',$('#tipo_medio_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>   
                                </a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             </div> 

                             <div class="col-md-4">
                                 Medio: <br />
                                <span id="HTMLMEDIOS_<?php echo $i;?>">
                                <select id="medios_<?php echo $i;?>"  name="medios_<?php echo $i;?>" class="form-control">
                                    <option value="0">[Todos]</option>
                                    <?php for($Mi=0;$Mi<count($Medios);$Mi++){?>
                                    <option <?php if($lista[$i]["medio_id"] == $Medios[$Mi]["id"]){?>selected<?php }?> value="<?php echo $Medios[$Mi]["id"];?>"><?php echo utf8_encode($Medios[$Mi]["nombres"]);?></option>    
                                    <?php }?>
                                </select>                                
                                </span>
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','medio_id',$('#medios_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>                           
                             </div>



                             <div id="suple_<?php echo $i;?>" class="col-md-4 SSuplementos">    
                             Suplementos: <br />
                             <span id="HTMLSUMPLEMENTOS_<?php echo $i;?>">       
                             <?php if($lista[$i]["tipo_medio_id"] == 2 or $lista[$i]["tipo_medio_id"] == 4){?>

                                                                 
                               
                                <select id="suplementos_<?php echo $i;?>"  name="suplementos_<?php echo $i;?>" class="form-control">
                                    <option value="0">[Seleccionar]</option>

                                    
                                    <?php for($SSS=0;$SSS<count($suplementos);$SSS++){?>
                                    <option <?php if($lista[$i]["suplemento_id"]==$suplementos[$SSS]["id"]){?>selected<?php }?> value="<?php echo $suplementos[$SSS]["id"];?>"><?php echo utf8_encode($suplementos[$SSS]["nombres"]);?></option>    
                                    <?php }?>    

                                </select>                                
                                                        
                             <?php } ?>
                                </span>
                                <?php                                                   
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','suplemento_id',$('#suplementos_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>
                             </div>


                             <div class="col-md-4">
                                 Secciones/Programas <br />    <br /> 
                                <!--- Secciones -->
                                <?php 
                                    // validacion por permiso  de usuario                                               
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a style="cursor:pointer;text-decoration:underline" onclick="AgregasSeccion('<?php echo $i;?>','<?php echo $lista[$i]["id"];?>');" ><img src="assets/img/add.png" /> <b>Agregar</b></a>
                                 &nbsp;|&nbsp;                                 
                                <a onclick="xajax_GuardarSeccionEditar(xajax.getFormValues('form_nuevo'),'<?php echo $i?>','<?php echo $lista[$i]["id"];?>');" title="Guardar PROGRAMA / SECCIÓN"><img src="assets/img/save.png" /> <b>Guardar Seccion/Progr.</b></a> 
                                <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?>    

                                  <?php
                           // ############## Secciones ################## 
                             
                           $Seccion2 = $model->listarTablaGeneral("id,nombres ","secciones"," where id in (".$lista[$i]["secciones_id"].")  order by nombres asc ");
                           $Seccion  = $model->listarTablaGeneral("id,nombres","secciones"," where estado = 1 and medios_id = '".$lista[$i]["medio_id"]."'  order by nombres asc");               
                             for($SEEEi=0;$SEEEi<count($Seccion2);$SEEEi++){
                           ?>
                            <div class="paginas">
                            <select id="seccionEditar<?php echo $i;?>[]"  name="seccionEditar<?php echo $i;?>[]" class="form-control">
                                <option value="0">[Todos]</option>
                                <?php  for($j=0;$j<count($Seccion);$j++){?>
                                <option <?php if($Seccion2[$SEEEi]['id']==$Seccion[$j]["id"]){?> selected <?php }?> value="<?php echo $Seccion[$j]["id"];?>"><?php echo utf8_encode($Seccion[$j]["nombres"]);?></option>    
                                <?php }// End For 1?>
                                </select>
                            </div>  
                            <?php  } // FOR ?>                                
                               


                                <!--- end secciones -->
                             </div>   <div id="HTMLSeccion<?php echo $i;?>"></div> 

                            <div class="col-md-4">
                                 Cargo: <br />
                                <select id="cargos_<?php echo $i;?>" name="cargos_<?php echo $i;?>" class="form-control">
                                <option value="0">[Todos]</option>
                                <?php for($Ci=0;$Ci<count($Cargos);$Ci++){?>
                                <option <?php if($lista[$i]['cargo_id']==$Cargos[$Ci]["id"]){?>selected<?php }?>  value="<?php echo $Cargos[$Ci]["id"];?>"><?php echo utf8_encode($Cargos[$Ci]["nombres"]);?></option>    
                                <?php }?>
                                </select>
                                <?php 
                                    // validacion por permiso  de usuario                                               
                                    if($_SESSION['sTipoUsuario']==1){                                
                                    $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                    if(in_array(2, $extraer_permisos)){
                                ?>
                                <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','cargo_id',$('#cargos_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>
                                 <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                                ?> 
                            </div>

                            <div class="col-md-4">
                                 F. Ingreso: <br />
                                 <input type="text" name="fecha_inicio_<?=$i;?>" class="form-control fecha_inicio" value="<?php echo $lista[0]['fecha_inicio'];?>" id="fecha_inicio_<?=$i;?>" />
                            
                            <?php 
                                // validacion por permiso  de usuario                                               
                                if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                            <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','fecha_inicio',$('#fecha_inicio_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>
                            <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                             ?>
                            </div>

                            <div class="col-md-4">
                                 F. Salida: <br />
                                 <input type="text" name="fecha_final_<?php echo $i;?>" class="form-control fecha_final" id="fecha_final_<?php echo $i;?>" value="<?php echo $lista[$i]["fecha_final"];?>" />
                            <?php 
                                // validacion por permiso  de usuario                                               
                                if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                            <a onclick="xajax_EditarDatosActividad('<?php echo $lista[$i]["id"];?>','fecha_final',$('#fecha_final_<?php echo $i;?>').val());"><img src="assets/img/save.png" /></a>
                            <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                            ?>
                            </div>
                
                       
                            <!-- Secciones-->                  

                            

                            <!-- Clientes-->
                            <div style="clear: both;text-align: left;display: block;padding-top: 12px;margin-left: 20px;padding-bottom:10px ">
                            <a style="cursor:pointer;text-decoration:underline" onclick="AgregasCliente('<?php echo $i;?>');" ><img src="assets/img/new.png" /><b>AGREGAR CLIENTES</b></a>
                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <?php 
                                // validacion por permiso  de usuario                                               
                                if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                            <a onclick="xajax_GuardarClientesEditar(xajax.getFormValues('form_nuevo'),'<?php echo $i?>','<?php echo $lista[$i]["id"];?>');" title="Guardar CLIENTE."><img src="assets/img/save.png" /></a> GUARDAR REGISTRO
                            </div>
                           <?php
                                        }// End permiso
                                     }// Tipo Usuario 
                            ?>
                           <?php
                           // ############## CLIENTES ################## 
                           $Clientes2 = $model->listarTablaGeneral("id,nombres ","clientes"," where id in (".$lista[$i]["clientes_id"].")  order by nombres asc ");
                           $Clientes = $model->listarTablaGeneral(" id,nombres ","clientes"," order by nombres asc ");                                   
                               
                                for($CLi=0;$CLi<count($Clientes2);$CLi++){
                           ?>
                            <div class="paginas">
                            <select id="clientesEditar<?php echo $i;?>[]"  name="clientesEditar<?php echo $i;?>[]" class="form-control">
                                <option value="0">[Selecionar]</option>
                                <?php  for($CLLi=0;$CLLi<count($Clientes);$CLLi++){         ?>
                                <option <?php if($Clientes2[$CLi]["id"]==$Clientes[$CLLi]["id"]){?> selected <?php }?> value="<?php echo $Clientes[$CLLi]["id"];?>"><?php echo utf8_encode($Clientes[$CLLi]["nombres"]);?></option>    
                                <?php }?>
                            </select>
                            </div>  
                            <?php  } // FOR ?>                               
                            <div id="HTMLClientes<?php echo $i;;?>"></div>


                            <!-- Tema Interes-->
                            <div style="clear: both;text-align: left;display: none;padding-top: 12px;margin-left: 20px;padding-bottom:10px">
                            <a style="cursor:pointer;text-decoration:underline" onclick="AgregasTemaInteres('<?php echo $i;?>');" ><img src="assets/img/new.png" /><b>AGREGAR TEMA INTERES</b></a>
                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a onclick="xajax_GuardarInteresEditar(xajax.getFormValues('form_nuevo'),'<?php echo $i?>','<?php echo $lista[$i]["id"];?>');" title="Guardar TEMA INTERES."><img src="assets/img/save.png" /></a> GUARDAR REGISTRO

                            </div>      
                            
                            <?php
                           // ############## TEMA DE INTERES ################## 
                           $TemaInteres2 = $model->listarTablaGeneral("id,nombres ","tema_interes"," where id in (".$lista[$i]["tema_interes_id"].")  order by nombres asc ");
                           $TemaInteres  = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent = 0 order by nombres asc");               
                             for($TEi=0;$TEi<count($TemaInteres2);$TEi++){
                           ?>
                            <div class="paginas">
                            <select id="TemaEditar<?php echo $i;?>[]"  name="TemaEditar<?php echo $i;?>[]" class="form-control">
                                <option value="0">[Todos]</option>
                                <?php  for($z=0;$z<count($TemaInteres);$z++){?>
                                <option <?php if($TemaInteres2[$TEi]['id']==$TemaInteres[$z]["id"]){?> selected <?php }?> value="<?php echo $TemaInteres[$z]["id"];?>"><?php echo utf8_encode($TemaInteres[$z]["nombres"]);?></option>    

                                <?php 
                                $TemaInteres3 = $model->listarTablaGeneral("id,nombres","tema_interes"," where estado = 1 and parent <> 0 and parent = '".$TemaInteres[$z]["id"]."' order by nombres asc");

                                for($y=0;$y<count($TemaInteres3);$y++){
                                ?>
                                <option <?php if($TemaInteres2[$TEi]['id']==$TemaInteres3[$y]["id"]){?>selected<?php }?> value="<?php echo $TemaInteres3[$y]["id"];?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($TemaInteres3[$y]["nombres"]);?></option> 

                                <?php }// For 2?>

                                <?php }// End For 1?>
                                </select>
                            </div>  
                            <?php  } // FOR ?>        
                            <div id="HTMLTemaInteres<?php echo $i;?>"></div>

                            <hr />

                         </div>
                        <?php }// FOR?> 
                           </div>               

                        <!-- Actividad -->
                         <?php 
                                // validacion por permiso  de usuario                                               
                                if($_SESSION['sTipoUsuario']==1){                                
                                $extraer_permisos = explode(",", $_SESSION['sPermisos']);
                                if(in_array(2, $extraer_permisos)){
                            ?>
                        <button type="button" onclick="xajax_AgregarActividad('<?php echo $_GET['id']?>');" class="btn btn-primary">Nueva Actividad</button>
<?php
                                        }// End permiso
                                     }// Tipo Usuario 
                            ?>
                        <br><br>
                        <div id="HTMLACTIVIDAD" style="border: #CCC 1px solid;float: left;width: 100%;clear: both;"></div>
                        <!-- Actividad -->

                                        
                        </div>


                        <div class="form-group"><br>
                        <!--<button type="button" onclick="xajax_editarPeriodista(xajax.getFormValues('form_nuevo'));" class="btn1 btn-primary">Guardar</button>-->
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
    
       <!-- Modal-->  
      <script src="assets/plugins/modal/jquery.modal.js" type="text/javascript" charset="utf-8"></script>
      <link rel="stylesheet" href="assets/plugins/modal/jquery.modal.css" type="text/css" media="screen" />
      <script src="assets/plugins/modal/highlight/highlight.pack.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript" charset="utf-8">
      hljs.initHighlightingOnLoad(); 
      </script>

     <!-- Calendar-->
    <script src="assets/plugins/calendar/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        $(function() {
          $('.nacimiento').datepicker({format: "dd-mm-yyyy"    });  
          $('.fecha_inicio').datepicker({format: "yyyy-mm-dd"    });  
          $('.fecha_final').datepicker({format: "yyyy-mm-dd"    });  
        });

    // Agregar SECCION 
    var page = 0;
    function AgregasSeccion(indice,id_actividad){
      page++;
      
        $("#HTMLSeccion"+indice).append("<div class='paginas' id = 'programas"+page+"'></div>");

        $.post("data.php", { TipMedio:$('#tipo_medio'+indice).val() , medio: $('#medios_'+indice).val() , indice:indice , IdActividad: id_actividad , suplemento:$('#suplementos_'+indice).val() } , function( data ) {
          $( "#programas"+page ).html( data );
        });

    }

    // Agregar CLiente 
    var page = 0;
    function AgregasCliente(indice){
      page++;
      
        $("#HTMLClientes"+indice).append("<div class='paginas' id = 'programas"+page+"'></div>");
        $.post("dataClientes.php",{indice:indice} , function( data ) {
          $( "#programas"+page ).html( data );
        });
    }

     // Agregar Tema Interes
    var page = 0;
    function AgregasTemaInteres(indice){
      page++;
      
        $("#HTMLTemaInteres"+indice).append("<div class='paginas col-md-4' id = 'programas"+page+"'></div>");
        $.post("dataTemaInteres.php", {indice:indice} ,function( data ) {
          $( "#programas"+page ).html( data );
        });
    }

    // -.-.-.-.-.-.-.--.-..-.-.-.--.-.-..-.--.-.-.-.-.-.-.-.-.-.-..-.--.-.-.-.-.-.-.-.
    // ------------.------------.....---- ACTIVIDAD  ---------------------.-.-.-..--.-
    // -.-.-.-.-.-.-.--.-..-.-.-.--.-.-..-.--.-.-.-.-.-.-.-.-.-.-..-.--.-.-.-.-.-.-.-.

/*    var actividad = 0;
    function AgregarActividad(idPeriodista){
        actividad++; 

        $("#HTMLACTIVIDAD").append("<div class='Actividades' id = 'actividad"+actividad+"'></div>");
        $.post("dataActividad.php", { indice: actividad , periodista:idPeriodista} , function( data ) {
          $( "#actividad"+actividad ).html( data );
          $('.fecha_inicio').datepicker({format: "yyyy-mm-dd"    });
          $('.fecha_final').datepicker({format: "yyyy-mm-dd"    });    
        });

    }
*/
    // Agregar SECCION EN ACTIVIDAD
    var seccion = 0;
    function AgregasSeccionActividad(indice){
      seccion++;
      
        $("#HTMLSeccionNuevo_"+indice).append("<div class='paginas' id = 'programas"+seccion+"'></div>");
        $.post("data.php", { medio: $('#NuevoMedios_'+indice).val() } , function( data ) {
          $( "#programas"+seccion ).html( data );
        });
    }    


    // Agregar CLIENTE EN ACTIVIDAD
    var seccion = 0;
    function AgregasClienteActividad(indice){
      seccion++;
      
        $("#HTMLClienteNuevo_"+indice).append("<div class='paginas' id = 'programas"+seccion+"'></div>");
        $.post("dataClientes.php",  function( data ) {
          $( "#programas"+seccion ).html( data );
        });
    }    

   // Agregar Tema Interes
    var interes = 0;
    function AgregasTemaActividad(indice){
      interes++;
      
        $("#HTMLTemaNuevo_"+indice).append("<div class='paginas ' id = 'programas"+interes+"'></div>");
        $.post("dataTemaInteres.php",  function( data ) {
          $( "#programas"+interes ).html( data );
        });
    }    


    </script>
<!-- CK Editor -->
    <script src="assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
 
    <script type="text/javascript">
        $(function() {
                $('.SSuplementos').hide();
                $('#nacimiento').datepicker({format: "dd-mm-yyyy"    });  
            
            // Replace the <textarea id="editor1"> with a CKEditor.
            // instance, using default configuration.
            CKEDITOR.replace('editor1');
            
        });
    </script>
</body>
</html>
