<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function array_horas(){

    $valor = array();
  





    $valor['0']    = "00:00";

    $valor['5']    = "00:05";
    $valor['10']   = "00:10";
    $valor['15']   = "00:15";
    $valor['30']   = "00:30";        
    $valor['45']   = "00:45"; 

    $valor['60']   = "01:00";
    $valor['75']   = "01:15";
    $valor['90']   = "01:30";
    $valor['105']  = "01:45";   

    $valor['120'] = "02:00";
    $valor['135'] = "02:15";    
    $valor['150'] = "02:30";
    $valor['165'] = "02:45";    

    $valor['180'] = "03:00";     
    $valor['195'] = "03:15";            
    $valor['210'] = "03:30";  
    $valor['225'] = "03:45";        

    $valor['240'] = "04:00";  
    $valor['255'] = "04:15"; 
    $valor['270'] = "04:30"; 
    $valor['285'] = "04:45";     

    $valor['300'] = "05:00"; 
    $valor['315'] = "05:15";     
    $valor['330'] = "05:30";
    $valor['345'] = "05:45";                       

    $valor['360'] = "06:00";  
    $valor['375'] = "06:15";      
    $valor['390'] = "06:30";   
    $valor['405'] = "06:45";       

    $valor['420'] = "07:00";      
    $valor['435'] = "07:15";              
    $valor['450'] = "07:30";   
    $valor['465'] = "07:45";             

    $valor['480'] = "08:00";  
    $valor['495'] = "08:15";  
    $valor['510'] = "08:30";              
    $valor['525'] = "08:45";                  

    $valor['540'] = "09:00";              

    return $valor;
}


// Para la vista web
function conversorSegundosHoras($tiempo_en_segundos) {

    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
 
    $hora_texto = "";
    if ($horas > 0 ) {
        $hora_texto .= $horas . "H ";
    }
 
    if ($minutos > 0 ) {
        $hora_texto .= $minutos . "m ";
    }
 
    if ($segundos > 0 ) {
        $hora_texto .= $segundos . "s";
    }
 
    return $hora_texto;
}

// Para el reporte excel
function conversorSegundosHorasExcel($tiempo_en_segundos) {

    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
 
    $hora_texto = "";
   // if ($horas > 0 ) {

        $hora_texto .= str_pad($horas, 2, "0", STR_PAD_LEFT)  . ":".str_pad($minutos, 2, "0", STR_PAD_LEFT);


   // }
 /*
    if ($minutos > 0 ) {

        $hora_texto .=   . ":";
    }
 
    if ($segundos > 0 ) {
        $hora_texto .= str_pad($segundos, 2, "0", STR_PAD_LEFT)  . ":";
    }*/
 
    return $hora_texto;
}


function toHours($min,$type){ 

 
 if($type==1){

        if($min>=60){
            
            $text =   conversorSegundosHoras($min*60); 

        }else{
            $text = $min." Min";    
            if($text==0){
            $text = $min;    
            }

        }

}else

   if($type==0 ){

   
        
            //$text =   conversorSegundosHorasExcel($min*60);    
          //  $text = number_format( ($min/60),2);
            

            $text = number_format(($min/60), 2) ;
             //      $text = $min;
   
    }
    
    


/*
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
     

     }*/

     return $text; 

 }