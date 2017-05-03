<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function array_horas(){

    $valor = array();
  

    $valor['0']   = "00:00";
    $valor['15']  = "00:15";
    $valor['30']  = "00:30";        
    $valor['60']  = "01:00";
    $valor['90']  = "01:30";
    $valor['120'] = "02:00";
    $valor['150'] = "02:30";    
    $valor['180'] = "03:00";        
    $valor['210'] = "03:30";     
    $valor['240'] = "04:00";  
    $valor['270'] = "04:30"; 
    $valor['300'] = "05:00"; 
    $valor['330'] = "05:30";                    
    $valor['360'] = "06:00";  
    $valor['390'] = "06:30";    
    $valor['420'] = "07:00";          
    $valor['450'] = "07:30";          
    $valor['480'] = "08:00";  
    $valor['510'] = "08:30";              
    $valor['540'] = "09:00";              

    return $valor;
}


function toHours($min,$type){ 

    //obtener segundos
     $sec = $min * 60;
     //dias es la division de n segs entre 86400 segundos que representa un dia
     $dias=floor($sec/86400);
     //mod_hora es el sobrante, en horas, de la division de días; 
     $mod_hora=$sec%86400;
     //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
     $horas=floor($mod_hora/3600); 
     //mod_minuto es el sobrante, en minutos, de la division de horas; 
     $mod_minuto=$mod_hora%3600;
     //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
     $minutos=floor($mod_minuto/60);
     if($horas<=0)
     {
         $text = $minutos.' min';
     }
     elseif($dias<=0)
     {
     if($type=='round')
     //nos apoyamos de la variable type para especificar si se muestra solo las horas
     {
     $text = $horas.' hrs';
     }
     else
     {
     $text = $horas." hrs ".$minutos;
     }
     }else{
          

     //nos apoyamos de la variable type para especificar si se muestra solo los dias
         if($type=='round')
         {
             $text = $dias.' dias';
         }
         else
         {
             $text = $dias." dias ".$horas." hrs ".$minutos." min";
         }
     

     }
     return $text; 

 }