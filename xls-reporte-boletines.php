<?php 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"detalle_seguimientos_".date("Y-m-d").".xls\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include('validar.session.php');
include("model/functions.php");
$model     = new funcionesModel();


$fecha             = $_REQUEST['fecha'];
$fecha2            = $_REQUEST['fecha2'];
$clientes_control  = $_REQUEST['clientes'];
$lista_control     = $_REQUEST['Lista'];
$difusion_control  = $_REQUEST['difusion'];
$nombres           = $_REQUEST['nombres'];
$estado            = $_REQUEST['estado'];

$idboletines = '0';
if($_POST['HddidActividad'] !=0){
    $idboletines  =  $_POST['HddidActividad'];
}
    // End if

$lista             = $model->datosBoletines($nombres,$clientes_control,$difusion_control,$fecha,$fecha2,$lista_control,$estado,$idboletines);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$difusion          = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$cobertura         = array_cobertura();
$periocidad        = array_periocidad();


?>
<html>
<meta charset="utf-8">
<head>
<style type="text/css">
body{ont-family: arial;font-size: 12px;}
td{text-align: center;margin: 10px;padding: 5px;border: #CCC 1px solid}
</style>
</head>
<body>
                            <p style="font-family:arial;font-size:11px"><?php echo "TOTAL DE REGISTROS:".count($lista);?></p>
                                      <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <?php if($_POST['CHKDocumento']==1){?>   
                                            <th>DOCUMENTO</th>
                                            <?php }?>
                                            <?php if($_POST['CHKEstado']==1){?>
                                            <th>ESTADO</th>
                                            <?php }?>
                                            <?php if($_POST['CHKCliente']==1){?>
                                            <th>CLIENTE</th>
                                            <?php }?>
                                            <?php if($_POST['CHKDifusion']==1){?>
                                            <th>DISUFION</th>
                                            <?php }?>
                                            <?php if($_POST['CHKLista']==1){?>
                                            <th>LISTA</th>
                                            <?php }?>
                                            <?php if($_POST['CHKFecRegistro']==1){?>
                                            <th>F. REGISTRO</th>
                                            <?php }?>
                                            <?php if($_POST['CHKFecEnvio']==1){?>
                                            <th>F. ENVIO</th>
                                            <?php } ?>
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

                                        ?>
                                        <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                                            
                                            <?php if($_POST['CHKDocumento']==1){?>
                                            <td><?php echo utf8_encode($lista[$i]["nombres"]);?></td>
                                            <?php }?>
                                            
                                            <?php if($_POST['CHKEstado']==1){?>
                                            <td><?php 
                                                    $nombreEstado = '';
                                                        if($lista[$i]["estado"]==1){
                                                            $nombreEstado = 'Borrador';
                                                        }else if($lista[$i]["estado"]==2){
                                                            $nombreEstado = 'Programado';   
                                                        }else if($lista[$i]["estado"]==3){
                                                            $nombreEstado = 'Enviado';
                                                        }
                                                            echo $nombreEstado;
                                                    ?>
                                            </td>
                                            <?php }?>

                                            <?php if($_POST['CHKCliente']==1){?>
                                            <td><?php echo utf8_encode($data1[0]["nombres"]);?></td>
                                            <?php }?>

                                            <?php if($_POST['CHKDifusion']==1){?>
                                            <td><?php echo utf8_encode($data4[0]["nombres"]);?></td>                                            
                                            <?php }?>

                                            <?php if($_POST['CHKLista']==1){?>                                                                                           
                                            <td><?php echo utf8_encode($data3[0]["nombres"]);;?></td>
                                            <?php }?>

                                            <?php if($_POST['CHKFecRegistro']==1){?>
                                            <td><?php echo ($lista[$i]["fecha_registro"]);?></td>
                                            <?php }?>

                                             <?php if($_POST['CHKFecEnvio']==1){?>
                                            <td><?php echo ($lista[$i]["fecha_envio"]);?></td>
                                             <?php }?>

                                              <?php if($_POST['CHKUsuario']==1){?>                                           
                                              <td><?php echo utf8_encode($data2[0]["nombres"]);;?></td>
                                              <?php }?> 
                                        </tr>
                                        <?php }?> 
                                            

                                        </tbody>

                                    </table>
</body>
</html>