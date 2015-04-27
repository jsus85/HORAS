<?php
class funcionesModel {
	
    private $text_log='Funciones_Model';

	public function getVideoYoutubeInfo($id) {
		$xml = @file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$id);
		if (!$xml) {
			echo "Error, no se ha podido obtener la info del video $id <br />";
			return;
		}
		preg_match("#<yt:duration seconds='([0-9]+)'/>#", $xml, $duracion);
		$xml = simplexml_load_string($xml);
		return array($xml->title, $xml->content, $duracion[1]);
	}


	public function cambiarFormatoFecha($mes_num) 
	{
		switch($mes_num)
		{
			case 1:  {$mt="Enero";}break;
			case 2:  {$mt="Febrero";}break;
			case 3:  {$mt="Marzo";}break;
			case 4:  {$mt="Abril";}break;
			case 5:  {$mt="Mayo";}break;
			case 6:  {$mt="Junio";}break;
			case 7:  {$mt="Julio";}break;
			case 8:  {$mt="Agosto";}break;
			case 9:  {$mt="Septiembre";}break;
			case 10: {$mt="Octubre";}break;
			case 11: {$mt="Noviembre";}break;
			case 12: {$mt="Diciembre";}break;
		}
		return $mt;
	}	

	public function renombrarCadena($cadena)
	{
		$cadena_sin_espacios=str_replace(" ","_",$cadena);
				$search=array("&", "ñ", "Ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "'", "#", "-", "[", "]", "{", "}", "$", "!", "¡", "?", "¿", "°","(",")","%",'"');
				$replace=array("y", "n", "N", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "", "","", "", "", "", "", "","","","","","","","","","");			$cadena_transformada=strtolower(str_replace($search,$replace,$cadena_sin_espacios));	
		return $cadena_transformada;
	}
	public function cambiarPosicion($tabla,$pk,$campo,$posActual,$posFinal){
        try {
            $cn = Conexion::getInstancia();
			if($posActual>$posFinal)
			{
				$sql="select ".$pk.", ".$campo." from ".$tabla." where ".$campo.">='".$posFinal."' and ".$campo."<'".$posActual."'";
				$rs=$cn->ejecutarConsulta($sql);
				for($i=0;$i<count($rs);$i++)
				{
					$sqlUpd="update ".$tabla." set ".$campo."='".($rs[$i][$campo]+1)."' where ".$pk."='".$rs[$i][$pk]."'";
					$cn->ejecutarActualizacion($sqlUpd);					
				}
			}
			else if($posActual<$posFinal) 
			{
				$sql="select ".$pk.", ".$campo." from ".$tabla." where ".$campo.">'".$posActual."' and ".$campo."<='".$posFinal."'";
				$rs=$cn->ejecutarConsulta($sql);
				for($i=count($rs)-1;$i>=0;$i--)
				{
					$sqlUpd="update ".$tabla." set ".$campo."='".($rs[$i][$campo]-1)."' where ".$pk."='".$rs[$i][$pk]."'";
					$cn->ejecutarActualizacion($sqlUpd);					
				}				
			}
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }

	public function ultimoRegistroSegunTabla($tabla,$campo,$etiqueta){
        try {
            $cn = Conexion::getInstancia();
			$sql="select max(".$campo.") as '".$etiqueta."' from ".$tabla."";
			
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
        }
        catch (Exception $e) 
		{
        }
    }
	

	public function insertarRegistro($tabla,$campos,$valores){
        try {
            $cn = Conexion::getInstancia();
			$sql="insert ".$tabla." (";
			for($i=0;$i<count($campos);$i++)
			{
				if($i<count($campos)-1)$sql.="".$campos[$i].",";
				if($i==count($campos)-1)$sql.="".$campos[$i].") values (";
			}
			for($j=0;$j<count($valores);$j++)
			{
				if($j<count($valores)-1)$sql.="'".$valores[$j]."',";
				if($j==count($valores)-1)$sql.="'".$valores[$j]."');";
			}
			//echo $sql."\n";
			$cn->ejecutarActualizacion($sql);	
            $cn=null;
			//$cn->cerrarConexion();				
        }
        catch (Exception $e) 
		{
        }
    }	
	public function actualizarRegistro($tabla,$campos,$valores,$condicion){
        try {
            $cn = Conexion::getInstancia();			
			$sql="update ".$tabla." set ";
			for($i=0;$i<count($campos);$i++)
			{
				if($i<count($campos)-1)$sql.="".$campos[$i]."='".$valores[$i]."', ";
				if($i==count($campos)-1)$sql.="".$campos[$i]."='".$valores[$i]."' where ";
			}
			$sql.=$condicion;
			//echo $sql;
			$cn->ejecutarActualizacion($sql);
            $cn=null;	
        }
        catch (Exception $e) 
		{
        }
    }	
	
	public function listarTablaGeneral($campos,$tabla,$condicion){
        try {
            $cn = Conexion::getInstancia();
			$sql="select ".$campos." from ".$tabla." ".$condicion;
			//echo "consulta: ".$sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }
		
	public function eliminarRegistro($tabla,$condicion){
        try {
            $cn = Conexion::getInstancia();						
			$sql="delete from ".$tabla." where ".$condicion;
			//echo $sql;
			$cn->ejecutarActualizacion($sql);
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }
	
function borrar_directorio($dir, $borrarme)
{
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh))) 
    {
        if($obj=='.' || $obj=='..') continue;
        if (!@unlink($dir.'/'.$obj)) borrar_directorio($dir.'/'.$obj, true);
    }
    closedir($dh);
    if ($borrarme)
    {
        @rmdir($dir);
    }
}	
	
    public function enviarCorreo($asunto,$remitente,$mascaraRemitente,$emailAEnviar,$mensajeContent){
        try {
			include_once("../phpMailer/class.phpmailer.php");
			$men="";
				for($i=0;$i<count($emailAEnviar);$i++)
				{
					$instMail=new phpmailer (); # Crea una instancia
					$instMail->From = $remitente;//de...
					$instMail->FromName = utf8_decode($mascaraRemitente); 
					$instMail->AddAddress($emailAEnviar[$i]);//para.../		
					$instMail->Subject = utf8_decode($asunto);
					$instMail->Body = utf8_decode($mensajeContent);
					$instMail->IsHTML (true);
					
					if (!$instMail -> Send ()){
					$men = "no enviado"; 
					}
					else{
					$men="enviado";
					}
				}	
				return $men;				
        }
        catch (Exception $e) 
		{
        }
    }
	

    public function enviarCorreoPersonalizado($asunto,$remitente,$mascaraRemitente,$emailAEnviar,$mensajeContent,$smtp,$user_smtp,$pass_smtp){
        try {
			include_once("../phpMailer/class.phpmailer.php");
			$men="";
				for($i=0;$i<count($emailAEnviar);$i++)
				{
					$instMail=new phpmailer (); # Crea una instancia
					$instMail->IsSMTP(true);
					$instMail->Host = $smtp;				
					$instMail->Username = $user_smtp;
					$instMail->Password = $pass_smtp;
					$instMail->From = $remitente;//de...
					$instMail->Port = 25;
					$instMail->FromName = utf8_decode($mascaraRemitente); 
					$instMail->AddAddress($emailAEnviar[$i]);//para.../		
					$instMail->Subject = utf8_decode($asunto);
					$instMail->Body = utf8_decode($mensajeContent);
					$instMail->IsHTML (true);
						
					if (!$instMail -> Send ()){
					$men = "error"; 
					}
					else{
					$men="ok";
					}
				}	
				return $men;				
        }
        catch (Exception $e) 
		{
        }
    }
	
	
	
	public function campaniasActivas(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from campanias where estado='1' and id<>'005' and id<>'009' order by id asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }
	public function tallasPorSerie($campania,$marca,$modelo,$color,$serie){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from tallas where  id_campania='".$campania."' and id_marca='".$marca."' and id_modelo='".$modelo."' and id_color='".$color."' and id_serie='".$serie."' and estado='1' order by descripcion asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	}

	public function datosProductoActivosPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * from tallas where id='".$id."'";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}	
	
	public function productosActivosPorIdReporte($campania,$marca,$modelo,$color,$serie,$id){
        try {
            $cn = Conexion::getInstancia();
			$sql="
SELECT 
t.id AS 'idTalla',
ca.nombres AS 'campania',
ma.nombres AS 'marca',
mo.nombres AS 'modelo',
co.nombres AS 'color',
s.nombres AS 'serie',
t.descripcion AS 'descripcion',
t.precio AS 'precio'
FROM tallas t
INNER JOIN series s ON t.id_serie=s.id
INNER JOIN colores co ON  s.id_color=co.id
INNER JOIN modelos mo ON  co.id_modelo=mo.id
INNER JOIN marcas ma ON  mo.id_marca=ma.id
INNER JOIN campanias ca ON  ma.id_campania=ca.id
WHERE
ca.id='".$campania."' and
ma.id='".$marca."' and
mo.id='".$modelo."' and
co.id='".$color."' and
s.id='".$serie."' and
t.id='".$id."'";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}	
	
	public function productosActivosPorId($campania,$marca,$modelo,$color,$serie,$id){
        try {
            $cn = Conexion::getInstancia();
			$sql="
SELECT 
t.id AS 'idTalla',
ca.nombres AS 'campania',
ma.nombres AS 'marca',
mo.nombres AS 'modelo',
co.nombres AS 'color',
s.nombres AS 'serie',
t.descripcion AS 'descripcion',
t.precio AS 'precio'
FROM tallas t
INNER JOIN series s ON t.id_serie=s.id
INNER JOIN colores co ON  s.id_color=co.id
INNER JOIN modelos mo ON  co.id_modelo=mo.id
INNER JOIN marcas ma ON  mo.id_marca=ma.id
INNER JOIN campanias ca ON  ma.id_campania=ca.id
WHERE
t.id='".$id."'";
/*
ca.id='".$campania."' and
ma.id='".$marca."' and
mo.id='".$modelo."' and
co.id='".$color."' and
s.id='".$serie."' and

*/

			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}
	
	public function datosPromotora($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT
p.id,
p.nombres AS 'promotora',
c.nombres AS 'cd',
d.nombres AS 'directora',
a.nombres AS 'asesora',
a.correo AS 'corAsesora'
FROM promotoras p 
INNER JOIN cds c ON p.id_cd=c.id 
INNER JOIN asesoras a ON c.id=a.id_cd
INNER JOIN directoras d ON c.id=d.id_cd where p.id='".$id."' and p.estado='1'";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}		
	public function pedidosPorPromotora($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from comprobante where id_promotor='".$id."' order by fec_reg desc";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}
	
	}	
	
	public function pedidosPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from comprobante where id='".$id."'";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}	
	}			
	
	public function detallesPedidosPorPromotora($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from pedidos where id_comprobante='".$id."' order by id_talla desc";
			//echo $sql."<br>";
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}	
	}		
	public function listaCDS(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from cds where estado='1' order by nombres asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{        
		}	
	}			
	
	
	
	
	
	
	
	
	
	
	

	
	public function tiposDeCambioActivos(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from tipo_cambio where estado='1' order by nombre asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	
	
	public function tiposDeCambioPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from tipo_cambio where id='".$id."' and estado='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }		

	public function productosActivos(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from productos where estado='1' order by id desc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	
	public function productosActivosParaIndex(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from productos where vista_index='1' and estado='1' order by rand() asc limit 0,9";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }		
	

	
	public function productosActivosPorGrupoMenosProductoActual($grupo,$id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from productos where grupo_producto='".$grupo."' and id<>'".$id."' and estado='1' order by id desc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }		
	
	public function ultimosProductosValoradosActivos($limite){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT p.id AS 'id', p.nombre AS 'nombre', p.imagen AS 'imagen', p.id_categorias AS 'id_categorias', c.valoracion AS 'valoracion' FROM productos p INNER JOIN comentarios c ON p.id=c.id_producto where p.estado='1' group by p.id ORDER BY c.valoracion DESC limit 0,".$limite;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }			
	
	public function categoriaPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from categorias where id='".$id."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }
	public function bannerActivo(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from banners where estado='1' order by posicion asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }	

	public function inactivarBanner($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="update banners set estado='0' where id='".$id."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }		
	
	public function bannerActivoPorPosicion($posicion){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from banners where posicion='".$posicion."' and estado ='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }			

	public function imagenesIndexActivas(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from imagenes_index where estado='1' order by posicion asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }
	
	public function imagenesProyectos(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from fotos_proyectos order by id desc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }
		
	public function proyecto(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from proyectos order by id desc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }	
	
	public function preguntasActivas(){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from preguntas where estado='1' order by posicion asc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }	

	public function totalProductosPorGrupos($grupo){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT grupo_producto, COUNT(grupo_producto) AS 'total' FROM productos WHERE grupo_producto='".$grupo."' GROUP BY grupo_producto";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	

	public function coloresPorGrupoDelProducto($grupo){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT id, color FROM productos WHERE grupo_producto='".$grupo."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	

	public function fotosPreviasPorProductos($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM fotos_productos WHERE productos_id='".$id."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	

	public function fotosPreviasPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM fotos_productos WHERE id='".$id."'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	
	
	public function promocionesPorId($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM promociones WHERE id='".$id."' and estado='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	

	public function promocionesActivas(){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM promociones WHERE estado='1' order by rand()";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	
	
	public function ultimosProductosIngresadosMenosActual($id,$limite){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from productos where id<>'".$id."' and estado='1' order by id desc limit 0,".$limite;
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }	
	

	public function productosActivosSelectosAleatoriamente($limite){
        try {
            $cn = Conexion::getInstancia();
			$sql="select * from productos where estado='1' and vista_index='1' order by rand() desc limit 0,".$limite;
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }		
	
	public function comentariosPorProductos($id){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM comentarios WHERE id_producto='".$id."' and estado='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }			
	
	public function promedioPorValoracion($idproducto){
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT ROUND(AVG(valoracion)) AS 'promedio', COUNT(valoracion) as 'total' FROM comentarios WHERE id_producto='".$idproducto."' AND estado='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }
    }
	public function igvActivo()
	{
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM igv WHERE estado='1'";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }	

	public function comprobantesActivos()
	{
        try {
            $cn = Conexion::getInstancia();
			$sql="SELECT * FROM comprobante order by fec_reg desc";
			//echo $sql;
			$rs=$cn->ejecutarConsulta($sql);
			return $rs;
            $cn=null;
        }
        catch (Exception $e) 
		{
        }
    }	

	
	public function limitarCadena($cadena,$limite,$complemento){
        try {
			$nombre1=$cadena;
			$nombre2="";
			$tope=$limite;
			if(strlen($nombre1)>$tope)
			{
				$nombre2=substr($nombre1,0,$limite).$complemento;
			}
			else
			{
				$nombre2=$nombre1;
			}	
			return $nombre2;
        }
        catch (Exception $e) 
		{
        }
    }					
		
		
}
?>