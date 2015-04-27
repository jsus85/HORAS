<?php
error_reporting(0);
class Conexion {

    // Singleton

    private static $instancia=null;

    private $cn=null;





    public static function getInstancia() {

        try {

            if(self::$instancia==null) {

                self::$instancia=new Conexion();

            }

        }

        catch (Exception $e) {

            throw $e;

        }

        return self::$instancia;

    }



    // Singleton

    function __construct() {

        try {

 
            $cn=mysql_connect("localhost","root","44540735@");
//            mysql_set_charset('utf8'); 
            mysql_select_db("prensa"); 
 //           mysql_query("SET NAMES 'utf8'"); 
			//mysql_close($cn);



        }

        catch(Exception $ex) {

            throw new Exception("Error al intentarse Conectarse...");

        }

    }



    public function ejecutarConsulta($sql) {

        try {

            $lista=array();

            $rs=mysql_query($sql);

            while($fila=@mysql_fetch_assoc($rs)) {

                $lista[]=$fila;				

            }

            if(count($lista)>0) {

                return $lista;

            }

            else {

                throw new Exception("No se obtuvieron datos en la consulta...");

            }

			mysql_free_result($rs);

			unset($fila);            

        }

        catch(Exception $ex) {

            throw $ex;

        }

    }





    public function ejecutarActualizacion($sql) {

        try {

            mysql_query($sql);

        }

        catch(Exception $ex) {

            throw $ex;

        }

    }

	

	public function cerrarConexion() {

        try {

            mysql_close();

        }

        catch(Exception $ex) {

            throw $ex;

        }

    }	

}





    function validar_email($address)

    {   



        if(preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-\.]+$/i",$address))      return true;

        else        return false;

    }





    function validar_passwd($cadena)

    {  



        if(preg_match("/^[a-zA-Z0-9_$]+$/i",$cadena))   return true;

        else                                return false;

    }





function array_cobertura(){



    $valor = array();



    $valor['1'] = "Internacional";

    $valor['2'] = "Local";

    $valor['3'] = "Nacional";        

    $valor['4'] = "Regional Internacional";

    $valor['5'] = "Regional Nacional";


    return $valor;

}



function array_periocidad(){

    $valor = array();

    $valor['1']   = "Lunes a Viernes";
    $valor['2']  = "Sábados";
    $valor['3']   = "Domingos";        
    $valor['4']   = "Lunes";
    $valor['5']   = "Martes";
    $valor['6']  = "Miércoles";
    $valor['7']   = "Jueves";
    $valor['8']   = "Viernes";
    $valor['9']  = "Diario";
    $valor['10']   = "Quincenal";
    $valor['11'] = "Mensual";
    $valor['12']   = "Bimestral";
    $valor['13'] = "Semanal";
    $valor['14'] = "Sin Periocidad";

    return $valor;   

}

function array_tipoUsuario(){

    $valor = array();

    $valor['0']   = "Usuario";
    $valor['1']  = "Administrador";

    return $valor;   

}


function array_suplemento(){

    $valor = array();

    $valor['1']   = "Luces";
    $valor['2']   = "Casa y más";
    $valor['3']   = "DT";
    $valor['4']   = "Portafolio";
    $valor['5']   = "Escape";
    $valor['6']   = "Vamos"; 
    $valor['7']   = "Viú"; 
    $valor['8']   = "Mi hogar"; 
    $valor['9']   = "Paladares"; 
    $valor['10']   = "Cuerpo";     
    $valor['11']   = "Día 1";         
    $valor['12']   = "Domingo";         
    $valor['13']   = "Cheka";             
    return $valor;   

}


function array_atributos(){

    $valor = array();

    $valor['1']   = "Lectura";
    $valor['2']   = "Nuevo";
    $valor['3']   = "Editar";
    $valor['2']   = "Nuevo";
    $valor['3']   = "Eliminar";

    return $valor;   

}



define('VAR_NROITEMS', 40);
?>