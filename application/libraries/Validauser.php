<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validauser{
	    
	     public function __construct()
        {

        	if(!$_SESSION['idEmpleado']){
        		redirect('http://solucionperu.com/pacific/');

        	}
			 	               
        }

    
}
