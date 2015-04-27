<?php
include("../dsSQL/conexion.php");
class funcionesModel {

	public function tallasPorSerie($campania,$marca,$modelo,$color,$serie){
        try {
            $cn = Conexion::getInstancia();
			$sql="EXEC PA_LOG_STOCK_DISPONIBLE_WEB_DIF '0001','".$campania."','".$marca."','".$modelo."','".$color."','".$serie."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}
				
}
?>