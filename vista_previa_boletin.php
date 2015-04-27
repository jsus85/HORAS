<?php 
header('Content-Type: text/html; charset=UTF-8'); 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();

$boletin         = $model->listarTablaGeneral("*","boletin"," where id = '".$_GET['id_boletin']."' ");
$boletinAdjuntos = $model->listarTablaGeneral("*","boletin_archivos"," where boletin_id = '".$_GET['id_boletin']."' ");

$difusion   = $model->listarTablaGeneral("id,nombres","difusion"," where categoria_id = 0 order by nombres asc ");
$clientes   = $model->listarTablaGeneral("*","clientes"," where id in (".$_SESSION['sClientes'].") ");
$saludos    = $model->listarTablaGeneral("*","saludos"," where id = '".$boletin[0]['saludo_id']."' ");
$listas     = $model->listarTablaGeneral("*","listas"," where cliente_id = '".$boletin[0]['cliente_id']."' ");

?>
<style>
.col-md-4{clear: both;width: 100%}
</style>
<h5>Vista Previa Boletin</h5>
<div class="col-md-4" >
<b>Asunto: </b><br />
<p><?php echo utf8_encode($boletin[0]['asunto']);?></p>
</div>    

                            <div class="col-md-4" >
                                <b>Saludo :</b>
                                <p><?php echo utf8_encode($saludos[0]['nombres'])." - ".utf8_encode($saludos[0]['nombres_femenino'])." - ".utf8_encode($saludos[0]['ninguno']);?></p>
                            </div>

                            <div class="col-md-4" style="width: 100%;">
                            Cuerpo del mensaje: <br />
                            <?php echo utf8_encode($boletin[0]['resumen']);?>   
                            </div>

                             <div class="col-md-4" >
                                Imagen adjunta cuerpo(JPG): <br />
                                <?php if($boletin[0]['imagen']!=''){?>
                                <img height="50" src="images/boletines/<?php echo $boletin[0]['imagen'];?>" />
                                <?php }?>
                            </div>         



                             <div class="col-md-4" style="float: right;" >
                                <p><b>Archivos adjuntos</b></p>
                                 <?php for($ba=0;$ba<count($boletinAdjuntos);$ba++){?>
                                 <div class="botones_<?php echo $boletinAdjuntos[$ba]['id']?>">
                                    <a href="images/boletines/adjuntos/<?php echo $boletinAdjuntos[$ba]['nombres'];?>" target="_blank">Ver archivo adjunto</a> &nbsp;|&nbsp; <a  onclick="xajax_borrarAdjunto('<?php echo $boletinAdjuntos[$ba]['nombres']?>','<?php echo $boletinAdjuntos[$ba]['id']?>');">Eliminar</a></div>
                                 <?php  } ?>
                             </div>