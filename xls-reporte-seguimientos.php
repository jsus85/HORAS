<?php 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"detalle_seguimientos_".date("Y-m-d").".xls\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
/*header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=reporte_seguimiento".date("Y-m-d").".doc");
header("Pragma: no-cache");
header("Expires: 0");*/
session_start();
include('validar.session.php');
include("model/functions.php");
$model     = new funcionesModel();
$fecha             = $_REQUEST['fecha'];
$fecha2            = $_REQUEST['fecha2'];
$clientes_control  = $_REQUEST['clientes'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];

$idseguimientos = '0';
if($_POST['HddidActividad'] !=0){
    $idseguimientos  =  $_POST['HddidActividad'];
}

$lista             = $model->datosSeguimientos($clientes_control,$difusion_control,$lista_control,$fecha,$fecha2,$idseguimientos);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$cobertura         = array_cobertura();
$periocidad        = array_periocidad();
?>
<html>
<meta charset="utf-8">
<head>
<style type="text/css">
body{ont-family: arial;font-size: 14px;}
p{font-family: arial;}
th{font-family: arial;border: #CCC 1px solid;background: #DDD}
td{text-align: center;margin: 10px;padding: 5px;border: #CCC 1px solid;font-family: arial;}
</style>
</head>
<body>
    <p><img  style="float:right" src="http://solucionperu.com/pacific/images/logo.png" /></p>
    <p><center><b style="font-family:arial;font-size:16px">REPORTE DE SEGUIMIENTOS</b></center></p>
    <p>TOTAL DE REGISTROS: <b><?php echo count($lista);?></b> </p>
                                        <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                          
                                            <?php if($_POST['CHKCliente']==1){?> 
                                            <th>CLIENTE</th>
                                            <?php }?>
                                            
                                            <?php if($_POST['CHKDifusion']==1){?> 
                                            <th>DIFUSION</th>
                                            <?php }?>

                                            <?php if($_POST['CHKLista']==1){?> 
                                            <th>LISTA</th>
                                            <?php }?>

                                            <?php if($_POST['CHKDocumento']==1){?>                                             
                                            <th>DOCUMENTO</th>
                                            <?php }?>

                                            <?php if($_POST['CHKFecRegistro']==1){?>  
                                            <th>F. REGISTRO</th>
                                            <?php }?>

                                            <?php if($_POST['CHKUsuario']==1){?>
                                            <th>USUARIO</th>
                                            <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                     <?php 
                                        $arrai_periodistas = "";    
                                        for($i=0;$i<count($lista);$i++){

                                       
                                        $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");// Cliente
                                        $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");// usuario
                                        $data3 = $model->listarTablaGeneral(" nombres ","listas","where id='".$lista[$i]["lista_id"]."'");//Lista
                                        $data4 = $model->listarTablaGeneral(" nombres ","difusion","where id='".$lista[$i]["difusion_id"]."'");//Lista
                                        $data5 = $model->listarTablaGeneral(" nombres ","boletin","where id='".$lista[$i]["boletin_id"]."'");//Lista

                                        ?>

                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            <?php if($_POST['CHKCliente']==1){?>     
                                            <td><?php echo utf8_encode($data1[0]["nombres"]);?></td>
                                            <?php }?>

                                             <?php if($_POST['CHKDifusion']==1){?> 
                                             <td><?php echo utf8_encode($data4[0]["nombres"]);?></td>    
                                             <?php }?>               

                                             <?php if($_POST['CHKLista']==1){?> 
                                            <td><?php echo utf8_encode($data3[0]["nombres"]);?></td>
                                            <?php }?>                                            

                                            <?php if($_POST['CHKDocumento']==1){?>                                            
                                            <td><?php echo utf8_encode($data5[0]["nombres"]);?></td>
                                            <?php }?>
                                            
                                            <?php if($_POST['CHKFecRegistro']==1){?>  
                                            <td><?php echo ($lista[$i]["fecha_registro"]);?></td>
                                            <?php }?>
                                            
                                            <?php if($_POST['CHKUsuario']==1){?>                                                                                            
                                            <td><?php echo utf8_encode($data2[0]["nombres"]);?></td>
                                            <?php }?>
                                            
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>
  
                                    </table>
</body>
</html>