<?php session_start();
include('validar.session.php');
include("model/functions.php");

$model       = new funcionesModel();

if(isset($_POST['accion'])){
     $where = " where query = '".$_POST['accion']."' ";
}

$variable = date("W");

$Periodistas      = $model->listarTablaGeneral("*","periodistas","");
$Actividades      = $model->listarTablaGeneral("*","actividad_periodista","");
$HistorialQuerys  = $model->listarTablaGeneral("*","historial_querys"," ".$where." order by id desc limit 100");
$cumpleanos       = $model->listarTablaGeneral("nombres,nacimiento,apellidos","periodistas"," where WEEKOFYEAR(nacimiento) = '".(int) $variable."' ");

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet Periodistas | Pacific Latam</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->

    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />

     <script src="assets/plugins/jquery-1.10.2.js"></script>

     <script src="assets/scripts/jquery.cookie.js"></script>

   </head>

<body>

    <!--  wrapper -->

    <div id="wrapper">

        <!-- navbar top -->

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            
            <!-- navbar-header -->
                <?php include('include/header.php');?>    
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
            
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">¡Hola <?php echo utf8_encode($_SESSION['sNOMBRES']);?>!</h1>
                </div>
                <!--End Page Header -->

            </div>

            <div class="row">

                  
                <?php if($_SESSION['sTipoUsuario']==1){?>
                <div class="panel panel-default">

                        <div class="panel-heading">Historial de Registros</div>
                        <div class="panel-body"><br />
                        <!-- Welcome -->
                        <div class="col-lg-12">
                        <div class="alert alert-warning">
                        <i class="fa fa-folder-open"></i><b>&nbsp; Numeros de Periodistas:  <?php echo count($Periodistas);?> registros.</b> <b></b>
                        <!--<i class="fa  fa-pencil"></i><b>&nbsp;2,000 </b>Registros alterados. &nbsp;-->                     
                        </div>

                        </div>

                        <!--end  Welcome -->

                   <!-- Welcome -->

                    <div class="col-lg-12">
                        <div class="alert alert-success">
                            <i class="fa fa-folder-open"></i><b>&nbsp; Numeros de Actividades:  <?php echo count($Actividades);?> registros.</b> 
                            <!--<i class="fa  fa-pencil"></i><b>&nbsp;2,000 </b>Registros alterados. &nbsp;-->
                        </div>
                    </div>
                    <!--end  Welcome -->

                    </div>
                </div>
                <?php }?>


                <div class="col-lg-3" style="width:100%;padding-bottom: 20px;">
                <i class="fa fa-calendar fa-3x" style="float:left;margin-top: 24px; font-size: 2em;"></i>&nbsp;<h4 style="width:428px">¿Quién cumple años de esta semana?:</h4><br>
  
                <?php for($z=0;$z<count($cumpleanos);$z++){?>
                <img src="assets/img/cumpleanos.png" /> <span style="font-size:14px"><?php echo $cumpleanos[$z]["nombres"]." ".$cumpleanos[$z]["apellidos"];?> &nbsp;-&nbsp; <?php echo ($cumpleanos[$z]["nacimiento"]);?></span><br />

                <?php 
                  }
                 ?>  
                </div>


            </div>





      
            <?php if($_SESSION['sTipoUsuario']==1){?>
       


                <h4 style="width:428px">Últimas modificaciones</h4>
                <!-- Simple table example -->
                    <div class="panel panel-primary" >
                        <form id="formHistorial" name="formHistorial" method="post">

                        
                            <div class="panel-heading" style="padding:10px">
     


                                <i class="fa fa-bar-chart-o fa-fw"></i>Registros alterados

                                <div class="pull-right">

                                    <div class="btn-group">
                                    
                                       <select id="accion" name="accion" onchange="cambiar_historial(this.value);">
                                           <option <?php if($_POST['accion']==0){?> selected <?php } ?> value="0">[Select Acción]</option>                                        
                                           <option <?php if($_POST['accion']=='login'){?>selected<?php } ?> value="login">Login</option>
                                           <option <?php if($_POST['accion']=='insert'){?>selected<?php } ?> value="insert">Insert</option>
                                           <option <?php if($_POST['accion']=='update'){?>selected<?php } ?> value="update">Update</option>
                                           <option <?php if($_POST['accion']=='delete'){?>selected<?php } ?> value="delete">Delete</option>
                                           <option <?php if($_POST['accion']=='salir'){?>selected<?php } ?> value="salir">Salir</option>
                                       </select>
                                    </div>

                                </div>

                            </div>



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="$('.ocultar').show();">Mostrar más</a></p>

                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Operación</th>
                                                    <th>Tabla</th>
                                                    <th># ID</th>
                                                    <th>Fecha</th>                                                   
                                                    <th>Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php 
                                                 for($i=0;$i<count($HistorialQuerys);$i++){
                                                    $data1 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$HistorialQuerys[$i]["usuario_id"]."'");
                                               ?>     
                                                <tr <?php if($i>=5){?>class="ocultar"<?php }?>>
                                                    <td><?php echo ($HistorialQuerys[$i]["query"]);?></td>
                                                    <td><?php echo ($HistorialQuerys[$i]["tabla"]);?></td>
                                                  
                                                    <td><?php echo ($HistorialQuerys[$i]["table_id"]);?></td>
                                                    <td><?php echo ($HistorialQuerys[$i]["fecha_query"]);?></td>
                                                    <td><?php echo utf8_encode($data1[0]["nombres"]);?></td>                                                    
                                                </tr>                                             
                                               <?php 
                                                }
                                               ?> 
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                             <!--/.row -->
                        </div>
                        <!-- /.panel-body -->
                        </form>
                    </div>
                    <!--End simple table example -->
                    <?php }?>
        </div>

        <!-- end page-wrapper -->



    </div>

    <!-- end wrapper -->



    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
    <script type="text/javascript">

    $(".ocultar").hide();  

    function cambiar_historial(data){

        if(data==0){
            window.location = 'panel.php';
        }else{
            document.formHistorial.submit();
        }
    }
    </script>

</body>
</html>