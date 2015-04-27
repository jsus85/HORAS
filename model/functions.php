<?php
include("ds/conexion.php");

class funcionesModel {
	
    private $text_log = 'Funciones_Model';

    public function verificarInicioDeSession($correo,$clave){
    		
		try {
            
            $cn = Conexion::getInstancia();
			$sql="select id,nombres,email,atributos,tipo_usuario from usuarios where usuario ='".$correo."' and clave = '".$clave."' and estado=1 ";
			//echo $sql;
			$rs   = $cn->ejecutarConsulta($sql);
			return $rs;

			$cn->cerrarConexion();
        }
        catch (Exception $e) 
		{
        }

}

public function datosUsuarioSession($correo,$clave){

        try {
            	$cn  = Conexion::getInstancia();

				$sql = "select id,nombres,email,atributos,tipo_usuario,permisos,clientes from usuarios where usuario ='".$correo."' and clave = '".$clave."' and estado=1 ";
			
				//echo $sql;
				$rs = $cn->ejecutarConsulta($sql);
				return $rs;
				$cn->cerrarConexion();

        }catch (Exception $e) 
		{        
		}
	
}

/*
 * Buscador de medios
 * medios.php 
 */
public function datosMedios($tipo_medio,$nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campoTipo   = NULL;
        	$campNombres = NULL;

        	if($tipo_medio !=0){	$campoTipo = " and tipo_medios_id = '".$tipo_medio."' ";	}
        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from medios where estado = 1 ".$campoTipo.$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) 
		{        
		}

}

/*
 * Buscador de listas
 * listas.php 
 */
public function datosListas($cliente,$nombres,$idListas){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campoTipo   = NULL;
        	$campNombres = NULL;
        	$campLista   = NULL;

        	if($cliente !=0){	  $campoTipo = " and cliente_id = '".$cliente."' ";	}
        	if($nombres !=''){	  $campNombres = " and nombres like '%".$nombres."%' ";	}        	
        	if($idListas !='0'){  $campLista  = " and id in (".$idListas.")";	}  

			 $sql = "select * from listas where cliente_id in (".$_SESSION['sClientes'].") and estado = 1 ".$campoTipo.$campNombres.$campLista."  order by id desc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) 
		{        
		}

}


/*
 * Buscador de Clientes
 * Clientes.php 
 */
public function datosClientes($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from clientes where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Buscador de TemaInteres
 * temas_interes.php 
 */
public function datosTemaInteres($nombres,$temas_interes){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres 	 = NULL;
        	$campTemaInteres = NULL;

        	if($nombres !=''){			$campNombres     = " and nombres like '%".$nombres."%' ";	}        	
        	if($temas_interes !='0'){	$campoTemaInteres = " and parent = '".$temas_interes."' ";	}        	

			 $sql = "select nombres,id,fecha_registro,parent from tema_interes where estado = 1 ".$campNombres.$campoTemaInteres." order by nombres,parent asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Buscador de Difusion
 * difusion.php 
 */
public function datosDifusion($nombres,$temas_interes){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres 	 = NULL;
        	$campTemaInteres = NULL;

        	if($nombres !=''){			$campNombres     = " and nombres like '%".$nombres."%' ";	}        	
        	if($temas_interes !='0' && $temas_interes!=''){	$campoTemaInteres = " and categoria_id = '".$temas_interes."' ";	}        	

			$sql = "select nombres,id,fecha_registro,categoria_id from difusion where estado = 1 ".$campNombres.$campoTemaInteres." order by nombres,categoria_id asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}




/*
 * Buscador de secciones
 * secciones.php 
 */
public function datosSecciones($nombres,$temas_interes,$suplemento){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres 	 = NULL;
        	$campTemaInteres = NULL;
        	$campSuplemento  = NULL;

        	if($nombres !=''){									$campNombres     = " and nombres like '%".$nombres."%' ";	}        	
        	if($temas_interes !='0' && isset($temas_interes)){	$campoTemaInteres = " and medios_id = '".$temas_interes."' ";	}        	
        	if($suplemento !='0' && isset($suplemento)){		$campSuplemento = " and suplemento = '".$suplemento."' ";	}        	

			$sql = "select nombres,id,suplemento,medios_id from secciones where estado = 1 ".$campNombres.$campoTemaInteres.$campSuplemento." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}


/*
 * Buscador de Cargos
 * Cargo.php 
 */
public function datosCargos($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from cargos where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}


/*
 * Buscador de suplementos
 * Suplementos.php 
 */
public function datosSuplementos($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from suplementos where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Buscador de saludos
 * saludos.php 
 */
public function datosSaludos($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from saludos where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}


/*
 * Buscador de Cargos
 * Ciudades.php 
 */
public function datosCiudades($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select * from ciudades where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Buscador de Usuarios
 * Usuarios.php 
 */
public function datosUsuarios($nombres){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres = NULL;

        	if($nombres !=''){		$campNombres = " and nombres like '%".$nombres."%' ";	}        	

			 $sql = "select nombres,email,tipo_usuario,clave,fecha_registro,usuario,id from usuarios where estado = 1 ".$campNombres." order by nombres asc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}



/*
 * Buscador de Boletines
 * boletines.php 
 */
public function datosBoletines($nombres,$clientes,$difusion,$fecha,$fecha2,$lista,$estado,$idBoletines){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campNombres   = NULL;
        	$campClientes  = NULL;
			$campDifusion  = NULL;
			$campFecha	   = NULL;
			$campLista 	   = NULL;
			$campEstado	   = NULL;
			$campBoletines = NULL;

 	      	if($idBoletines !='0'){		$campBoletines  = " and id in (".$idBoletines.")";	}        	

        	if($nombres !=''){		$campNombres  = " and nombres like '%".$nombres."%' ";	}        	
        	if($clientes !='0' && $clientes !=''){	$campClientes = " and cliente_id = '".$clientes."' ";	}        	
        	if($difusion !='0' && $difusion !=''){	$campDifusion = " and difusion_id = '".$difusion."' ";	}        	
        	if($fecha  !='' && $fecha2  !=''){		$campFecha    = " and fecha_registro  BETWEEN '".$fecha."' AND '".$fecha2."'  ";	}      	
        	if($lista !='0' && $lista !=''){		$campLista    = " and lista_id = '".$lista."' ";	}       
        	if($estado !='0' && $estado !=''){		$campEstado   = " and estado = '".$estado."' ";	}       

			$sql = "select * from boletin where cliente_id in (".$_SESSION['sClientes'].")  ".$campNombres.$campClientes.$campDifusion.$campFecha.$campLista.$campEstado.$campBoletines." order by id desc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Buscador de Seguimientos
 * seguimientos.php 
 */
public function datosSeguimientos($cliente,$difusion,$lista,$fecha,$fecha2,$idSeguimientos){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campClientes 	   = NULL;
			$campDifusion      = NULL;
			$campLista         = NULL;
			$campFecha	  	   = NULL;
			$campSeguimientos  = NULL;


 	      	if($idSeguimientos !='0'){		$campSeguimientos  = " and id in (".$idSeguimientos.")";	}        	

        	if($cliente !='0' && $cliente !=''){	$campClientes = " and cliente_id = '".$cliente."' ";	}        	
        	if($difusion !='0' && $difusion !=''){	$campDifusion = " and difusion_id = '".$difusion."' ";	}        	
        	if($lista    !='0' && $lista    !=''){	$campLista    = " and lista_id = '".$lista."' ";	}        	
        	if($fecha  !='' && $fecha2  !=''){		$campFecha    = " and fecha_registro  BETWEEN '".$fecha."' AND '".$fecha2."'  ";	}     


			 $sql = "select * from seguimientos where cliente_id in (".$_SESSION['sClientes'].")  ".$campClientes.$campDifusion.$campLista.$campFecha.$campSeguimientos." order by id desc";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}

/*
 * Reporte
 * reporte.php 
 */
public function datosReporte($cliente,$difusion,$lista,$nombres,$fecha,$fecha2){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	$campClientes = NULL;
			$campDifusion = NULL;
			$campLista    = NULL;
			$campNombres  = NULL;
			$campFecha    = NULL;

        	if($cliente !='0' && $cliente !=''){	$campClientes = " and s.cliente_id = '".$cliente."' ";		}        	
        	if($difusion !='0' && $difusion !=''){	$campDifusion = " and s.difusion_id = '".$difusion."' ";	}        	
        	if($lista    !='0' && $lista    !=''){	$campLista    = " and s.lista_id = '".$lista."' ";			}        	
        	if($nombres  !='0' && $nombres    !=''){						$campNombres  = " and b.id = '".$nombres."' ";	}
        	if($fecha  !='' && $fecha2  !=''){						$campFecha    = " and s.fecha_registro  BETWEEN '".$fecha."' AND '".$fecha2."'  ";	}


			 $sql = "SELECT s.lista_id
			 								 from 
														seguimientos s , boletin b 	
													where 
														s.boletin_id = b.id  ".$campClientes.$campDifusion.$campLista.$campNombres.$campFecha;
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e){ }

}// End function 




/*
 * Buscador de Periodistas
 * periodistas.php 
 */
public function datosPeriodista($nombres,$ciudad,$fecha_nacimiento,$cargo,$tipo_medios,$medios,$clientes,$tema_interes,$seccion){

	try {
        	$cn  = Conexion::getInstancia();


        	if($ciudad !=0){	$campoCiudad     = " and p.ciudad_id = '".$ciudad."' ";	}
        	if($nombres !=''){		$campNombres = " and p.nombres like '%".$nombres."%' ";	}        	
        	if($fecha_nacimiento !=''){		$campFecNac = " and p.nacimiento = '".$fecha_nacimiento."' ";	}        	
        	if($fecha_nacimiento !=''){		$campFecNac = " and p.nacimiento = '".$fecha_nacimiento."' ";	}        	
			if($cargo !=0){		    $campoCargo 	  = " and ap.cargo_id = '".$cargo."' ";	}
   	       	if($tipo_medios !=0){	$campoTipMedio    = " and ap.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and ap.medio_id = '".$medios."' ";	}

			if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , ap.clientes_id)  ";	}
			if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , ap.tema_interes_id)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , ap.secciones_id) ";	}
			
			$sql = "select 
			 				p.id,p.codigo,p.nombres,p.telefono,p.anexo,p.celularA,p.emailA,p.emailB,p.nacimiento,p.ciudad_id 
			 			from 
			 				periodistas p left join actividad_periodista ap on p.id = ap.periodista_id
			 			where 
			 					p.estado = 1 ".$campoCiudad.$campNombres.$campFecNac.$campoCargo.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion." order by p.nombres ";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) {  }

} // End function

/*
 * Buscador de Periodistas con paginacion
 * periodistas.php 
 */
public function datosPeriodistaPaginacion($nombres,$ciudad,$fecha_nacimiento , $cargo, $tipo_medios, $medios,$clientes,$tema_interes,$seccion,$reg){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
        	
        	if($ciudad !=0){	$campoCiudad     = " and p.ciudad_id = '".$ciudad."' ";	}
        	if($nombres !=''){		$campNombres = " and p.nombres like '%".$nombres."%' ";	}        	
        	if($fecha_nacimiento !=''){		$campFecNac = " and p.nacimiento = '".$fecha_nacimiento."' ";	}        	
			if($cargo !=0){		    $campoCargo 	  = " and ap.cargo_id = '".$cargo."' ";	}
			if($tipo_medios !=0){	$campoTipMedio    = " and ap.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and a.medio_id = '".$medios."' ";	}

			if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , ap.clientes_id)  ";	}
			if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , ap.tema_interes_id)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , a.secciones_id) ";	}


			$sql = "select 
			 				p.id,p.codigo,p.nombres,p.telefono,p.anexo,p.celularA,p.emailA,p.emailB,p.nacimiento,p.ciudad_id 
			 			from 
			 				periodistas p left join actividad_periodista ap on p.id = ap.periodista_id 
			 			where 
			 					p.estado = 1 ".$campoCiudad.$campNombres.$campFecNac.$campoCargo.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion." order by p.nombres asc LIMIT " .$reg." , ".VAR_NROITEMS;
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();


    }catch (Exception $e) {  }        	

} // End function


/*
 * Buscador de Actividades *******
 * actividades.php 		   *******	
 */
public function datosActividades($nombres,$tipo_medios,$medios,$cargo,$tema_interes,$seccion,$clientes,$idActividadSeleccionadas,$suplemento,$ciudad,$filtro,$nombres2,$apellidos){

	try {
        	$cn  = Conexion::getInstancia();

        	if($ciudad !=0){		$campoCiudad     = " and p.ciudad_id = '".$ciudad."' ";	}
     //   	if($nombres !=''){		$campNombres	  = " and ( p.nombres like    '%".$nombres."%'  or p.apellidos like   '%".$nombres."%' ) ";	} 
        
        if($filtro==1){	
        	
        	if($nombres !=''){		$campNombres	  = " and MATCH ( p.nombres, p.apellidos)      AGAINST ('".$nombres."' IN BOOLEAN MODE) ";	}

        }else if($filtro==2){

        	if($nombres2 !=''){		$campNombres	  = " and  p.nombres = '".$nombres2."' ";	}
        	if($apellidos !=''){	$campApellidos	  = " and  p.apellidos = '".$apellidos."' ";	}

        }	
     	

   	       	if($tipo_medios !=0){	$campoTipMedio    = " and a.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and a.medio_id = '".$medios."' ";	}
   	       	
   	       	if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , a.clientes_id)  ";	}
   	       	if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , p.tema_interes)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , a.secciones_id) ";	}

   	       	if($cargo !=0){		    $campoCargo 	  = " and a.cargo_id = '".$cargo."' ";	}

   	       	if($idActividadSeleccionadas != '' ){ $campoActividad = " and p.id in (".$idActividadSeleccionadas.") ";}

   	       	if($suplemento !=0){		    $campoSuplemento	  = " and a.suplemento_id = '".$suplemento."' ";	}

			 $sql = "select p.tema_interes, p.nombres, p.apellidos , a.tipo_medio_id, a.medio_id,a.clientes_id,a.secciones_id,a.cargo_id , a.fecha_inicio, a.fecha_final , a.tema_interes_id ,p.telefono , p.anexo,p.celularA,p.emailA, p.id as periodista_id , a.id as actividad_id
			 			from 
			 				periodistas p left join actividad_periodista a on p.id = a.periodista_id 
			 			where 
			 					p.estado = 1
			 				".$campoCargo.$campNombres.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion.$campoActividad.$campoSuplemento.$campoCiudad.$campApellidos." group by p.id order by p.nombres asc  ";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) {  }

} // End function


/*
 * Buscador de Actividades para el Reporte XLS, PDF *******
 * actividades.php 		   *******	
 */
public function datosActividadesReporte($nombres,$tipo_medios,$medios,$cargo,$tema_interes,$seccion,$clientes,$idActividadSeleccionadas,$suplemento,$ciudad){

	try {
        	$cn  = Conexion::getInstancia();

        	if($ciudad !=0){		$campoCiudad     = " and p.ciudad_id = '".$ciudad."' ";	}
        	if($nombres !=''){		$campNombres	  = " and ( p.nombres like    '%".$nombres."%'  or p.apellidos like   '%".$nombres."%' ) ";	}        	
   	       	if($tipo_medios !=0){	$campoTipMedio    = " and a.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and a.medio_id = '".$medios."' ";	}
   	       	
   	       	if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , a.clientes_id)  ";	}
   	       	if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , p.tema_interes)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , a.secciones_id) ";	}

   	       	if($cargo !=0){		    $campoCargo 	  = " and a.cargo_id = '".$cargo."' ";	}

   	       	if($idActividadSeleccionadas != '' ){ $campoActividad = " and p.id in (".$idActividadSeleccionadas.") ";}

   	       	if($suplemento !=0){		    $campoSuplemento	  = " and a.suplemento_id = '".$suplemento."' ";	}

			 $sql = "select p.tema_interes , p.nombres, p.apellidos , a.tipo_medio_id, a.medio_id,a.clientes_id,a.secciones_id,a.cargo_id , a.fecha_inicio, a.fecha_final , a.tema_interes_id ,p.telefono,p.telefonoB , p.telefonoC , p.anexo,p.celularA, p.celularB , p.celularC ,p.emailA , p.emailB, p.emailC, p.id as periodista_id , a.id as actividad_id
			 			from 
			 				periodistas p left join actividad_periodista a on p.id = a.periodista_id 
			 			where 
			 					p.estado = 1
			 				".$campoCargo.$campNombres.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion.$campoActividad.$campoSuplemento.$campoCiudad."  order by p.nombres asc  ";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) {  }

} // End function




/* Actividades en periodista.php */
public function datosActividadesPeriodista($nombres,$tipo_medios,$medios,$cargo,$tema_interes,$seccion,$clientes,$id_periodista){

	try {
        	$cn  = Conexion::getInstancia();

        	if($nombres !=''){		$campNombres	  = " and p.nombres like '%".$nombres."%' ";	}        	
   	       	if($tipo_medios !=0){	$campoTipMedio    = " and a.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and a.medio_id = '".$medios."' ";	}
   	       	
   	       	if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , a.clientes_id)  ";	}
   	       	if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , p.tema_interes)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , a.secciones_id) ";	}

   	       	if($cargo !=0){		    $campoCargo 	  = " and a.cargo_id = '".$cargo."' ";	}


			 $sql = "select 
			 				a.id,p.tema_interes ,p.nombres, p.telefono, a.tipo_medio_id, a.medio_id,a.clientes_id,a.secciones_id,a.cargo_id , a.fecha_inicio, a.fecha_final , a.tema_interes_id , a.suplemento_id 
			 			from 
			 				actividad_periodista a , periodistas p
			 			where 
			 					a.periodista_id =  p.id and a.periodista_id = '".$id_periodista."'
			 				".$campoCargo.$campNombres.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion." order by a.fecha_final desc ";
		
			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();

        }catch (Exception $e) {  }

} // -------------- End function


/*
 * Buscador de Actividades con paginacion--------------------------------
 * actividades.php 
 */
public function datosActividadesPaginacion($nombres,$tipo_medios,$medios,$cargo,$tema_interes,$seccion,$clientes,$suplemento , $ciudad, $filtro,$nombres2,$apellidos,$reg){
	
	try {
        	$cn  = Conexion::getInstancia();
        	
           	if($ciudad !=0){		$campoCiudad     = " and p.ciudad_id = '".$ciudad."' ";	}	
        	//if($nombres !=''){		$campNombres	  = " and ( p.nombres like   '%".$nombres."%'  or p.apellidos like  '%".$nombres."%' ) ";	}  

        	 if($filtro==1){	
        	
        	if($nombres !=''){		$campNombres	  = " and MATCH ( p.nombres, p.apellidos)      AGAINST ('".$nombres."') ";	}

        }else if($filtro==2){

        	if($nombres2 !=''){		$campNombres	  = " and  p.nombres = '".$nombres2."' ";	}
        	if($apellidos !=''){	$campApellidos	  = " and  p.apellidos = '".$apellidos."' ";	}

        }	
   	       	if($tipo_medios !=0){	$campoTipMedio    = " and a.tipo_medio_id = '".$tipo_medios."' ";	}
   	       	if($medios !=0){		$campoMedio       = " and a.medio_id = '".$medios."' ";	}

   	       	if($clientes !=0){		$campoCliente     = " and FIND_IN_SET(".$clientes." , a.clientes_id)  ";	}
   	       	if($tema_interes !=0){	$campoTemaInteres = " and FIND_IN_SET(".$tema_interes." , p.tema_interes)  ";	}
   	       	if($seccion !=0){		$campoSeccion 	  = " and FIND_IN_SET(".$seccion." , a.secciones_id) ";	}     	
			
			if($cargo !=0){		    $campoCargo 	  = " and a.cargo_id = '".$cargo."' ";	}
			if($suplemento !=0){		    $campoSuplemento	  = " and a.suplemento_id = '".$suplemento."' ";	}

			 $sql = "select 
			 				  p.tema_interes , p.nombres, p.apellidos ,  a.tipo_medio_id, a.medio_id,a.clientes_id,a.secciones_id,a.cargo_id , a.fecha_inicio, a.fecha_final , a.tema_interes_id  ,p.telefono , p.anexo,p.celularA,p.emailA, p.id as periodista_id , a.id as actividad_id
			 			from 
			 				periodistas p left join actividad_periodista a on p.id = a.periodista_id 
			 			where 
			 					p.estado = 1
			 				".$campoCargo.$campNombres.$campoTipMedio.$campoMedio.$campoCliente.$campoTemaInteres.$campoSeccion.$campoSuplemento.$campoCiudad.$campApellidos." group by p.id order by p.nombres asc LIMIT " .$reg." , ".VAR_NROITEMS;


			$rs = $cn->ejecutarConsulta($sql);
			return $rs;
			$cn->cerrarConexion();


    }catch (Exception $e) {  }        	

} // End function



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
				$search=array("&", "ñ", "Ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "'", "#", "-", "[", "]", "{", "}", "$", "!", "¡", "?", "¿", "°","(",")","%",'"',":");
				$replace=array("y", "n", "N", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "", "","", "", "", "", "", "","","","","","","","","","","");			
				$cadena_transformada=strtolower(str_replace($search,$replace,$cadena_sin_espacios));	
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

	public function ultimoRegistroSegunTabla($tabla,$campo,$etiqueta,$condicion){
        try {
            $cn = Conexion::getInstancia();
			$sql="select max(".$campo.") as '".$etiqueta."' from ".$tabla." ".$condicion;
			
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
			$sql="insert into ".$tabla." (";
			for($i=0;$i<count($campos);$i++)
			{
				if($i<count($campos)-1)$sql.="".$campos[$i].",";
				if($i==count($campos)-1)$sql.="".$campos[$i].") values (";
			}
			for($j=0;$j<count($valores);$j++)
			{
				if($j<count($valores)-1)$sql.="'".utf8_decode($valores[$j])."',";
				if($j==count($valores)-1)$sql.="'".utf8_decode($valores[$j])."');";
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
				if($i<count($campos)-1)$sql.="".$campos[$i]."='".utf8_decode($valores[$i])."', ";
				if($i==count($campos)-1)$sql.="".$campos[$i]."='".utf8_decode($valores[$i])."' where ";
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
			//echo $sql."<br>";
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
					$instMail=new phpmailer(); # Crea una instancia
					$instMail->IsSMTP(true);
					$instMail->From = $remitente;//de...
					$instMail->Port = 25;
					$instMail->FromName = utf8_decode($mascaraRemitente); 
					$instMail->AddAddress($emailAEnviar[$i]);//para.../		
					$instMail->Subject = utf8_decode($asunto);
					$instMail->Body = utf8_decode($mensajeContent);
					$instMail->IsHTML (true);
					
					if (!$instMail -> Send ()){
					$men = "no"; 
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
	
	







				
}
?>