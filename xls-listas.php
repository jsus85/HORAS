<?php 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"detalle_lista_".date("Y-m-d").".xls\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include('validar.session.php');
include("model/functions.php");
$model     = new funcionesModel();



$idboletines = '0';
if($_POST['HddidActividad'] !=0){
    $idboletines  =  $_POST['HddidActividad'];
}
    // End if

$clientes_control  = $_REQUEST['clientes'];
$nombres           = $_REQUEST['nombres'];
$lista             = $model->datosListas($clientes_control,$nombres,$idboletines);
$clientes          = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");

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

             <p style="font-family:arial;font-size:11px"><?php echo "TOTAL DE  LISTAS :".count($lista);?></p>
                                      

                  <table id="example2" class="table table-bordered table-striped">
                         <thead>
                        <tr>

                        <th>NOMBRES</th>
                        <th>CLIENTES</th>
                        <th>NUM. PERIODISTAS</th>
                        <th>FECHA REGISTRO</th>
                        <th>USUARIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php 
            $arrai_periodistas = "";    
            for($i=0;$i<count($lista);$i++){

                $arrai_periodistas =  explode(",", $lista[$i]["periodistas"]);
                $data1 = $model->listarTablaGeneral(" nombres ","clientes","where id='".$lista[$i]["cliente_id"]."'");
                $data2 = $model->listarTablaGeneral(" nombres ","usuarios","where id='".$lista[$i]["usuario_id"]."'");

                $periodistas_listado = $model->listarTablaGeneral(" nombres , apellidos","periodistas","where id in(".$lista[$i]["periodistas"].") ");

?>
                    <tr id="rw_<?php echo $lista[$i]["id"];?>" class="odd gradeX">
                        <td><?php echo utf8_encode($lista[$i]["nombres"]);?></td>
                        <td><?php echo ($data1[0]["nombres"]);?></td>
                        <td><?php echo count($arrai_periodistas);?></td>
                        <td><?php echo ($lista[$i]["fecha_registro"]);?></td>
                        <td><?php echo utf8_encode($data2[0]["nombres"]);?></td>
                        
                    </tr>
                    <?php 

                               for($p=0;$p<count($periodistas_listado);$p++){
                    ?>
                    <tr class="odd gradeX">
                        <td style="text-align:left" colspan="5"><?php echo utf8_encode($periodistas_listado[$p]["nombres"]." ".$periodistas_listado[$p]["apellidos"]);?></td>
                        
                    </tr>
                    <?php 
                                }
                          ?>

                    
                    <?php }?> 
                        

                    </tbody>
                    
                </table>
</body>
</html>