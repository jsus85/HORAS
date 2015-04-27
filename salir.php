<?php 

session_start();
include("model/functions.php");
$model       = new funcionesModel();
$campos	 = array("tabla","table_id","query","fecha_query","usuario_id","ip");
$valores = array("usuarios",$_SESSION['sID'],"salir",date('Y-m-d H:i:s'),$_SESSION['sID'],$_SERVER['REMOTE_ADDR']);
$model->insertarRegistro("historial_querys",$campos,$valores);

unset($_SESSION['sID']);
unset($_SESSION['sEMAIl']);
unset($_SESSION['sNOMBRES']);
unset($_SESSION['sTipoUsuario']);
unset($_SESSION['sAtributos']);             
session_destroy();

header("Location: index.php");
?>