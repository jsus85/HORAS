<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=reporte-horas.xls");
header("Pragma: no-cache");
header("Expires: 0");
/*
 <table>
      <tr>
            <td style="mso-number-format:'0.00';">12346579.00</td>
      </tr>
</table>
----------------------
mso-number-format:"0"                  Sin Decimales
mso-number-format:"0.00"               02 Decimals
mso-number-format:"#,##0.000"            Coma separadora de miles y 03 decimales
mso-number-format:"mm/dd/yy"            Formato de Fecha Completa
mso-number-format:"mmmm d, yyyy"         Formato de Fecha Literal
mso-number-format:"m/d/yy h:mm AM/PM"      Formato de Fecha Corta con Hora y AM/PM
mso-number-format:"Short Date"            Formato de Fecha Corta
mso-number-format:"Medium Date"            Formato de Fecha Mediana
mso-number-format:"d-mmm-yyyy"            Fecha Mediana separada por guiones
mso-number-format:"Short Time"            Formato corto de hora
mso-number-format:"Medium Time"         Formato mediana de hora
mso-number-format:"Long Time"            Formato de Hora Larga
mso-number-format:"Percent"            Porcentaje con 02 decimales
mso-number-format:"0%"               Porcentaje sin decimale
mso-number-format:"0.E+00"               Notación Cientifica
mso-number-format:"@"               Texto
mso-number-format:"# ???/???"            Fracciones - de 3 dígitos a más (312/943)
mso-number-format:"0022£0022#,##0.00"         Formato de Moneda (Libras Esterlinas)
mso-number-format:"#,##0.00_ ;[Red]-#,##0.00"   Formato de Número con negativos en rojo y signo -

Ingresar en cada celda las horas dedicadas a cada tarea utilizando números con 2 decimales, por ejemplo:

1.00 = 1 hora
1.25 = 1 hora 15 minutos
1.50 = 1 hora 30 minutos
1.75 = 1 hora 45 minutos

 */

     // llamar al modelo

      $ci = &get_instance();

      $ci->load->model("Horas_model");

  





          $primer_dia = mktime();

          $ultimo_dia = mktime();

          while(date("w",$primer_dia)!=1){

            $primer_dia -= 3600;

          }

          while(date("w",$ultimo_dia)!=0){

            $ultimo_dia += 3600;

          }



          $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');



          $fecha1 = trim((isset($fecha_inicial))?$fecha_inicial:date("Y-m-d",$primer_dia));



          $fecha2 = trim( (isset($fecha_final))? $fecha_final:date("Y-m-d",$ultimo_dia));

?>

  <table cellspacing="4" cellpadding="4" class="table table-striped table-advance table-hover">                            

                           <thead>



                              <tr>

                                  <th><i class="fa fa-tags"></i> Tareas</th>
                                  <th>&nbsp;</th>

                                  <?php for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ ?>

                                  <th style="padding-left:5px;padding-right:5px" align="center">
                                    <?php //echo substr($dias[date('N', strtotime($i))],0,3).".";?> <?php //echo substr($i,8,5);?>
                                    <?php echo $i;?>
                                  </th>

                                  <?php }?>

                                  <td><i class="fa fa-tags"></i> <b>TOTAL</b><td>

                              </tr>

                              </thead>

                              

                              <tbody>

                           <?php        



                        $array_sumaVertical   = array();      

                        $array_sumaHorizontal = array();      

                        

                        foreach ($tareacliente_empleados as $value) {

                    ?>

                              <tr>

                                  <td ><?php echo utf8_decode($value->nombrecliente);?></td>
                                  <td ><?php echo utf8_decode($value->nombretarea);?></td>                                  
                            <?php
                            $cantidadHoras="";
                            $sumaTotalVertical_Horitonzal=0;

                            for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

                                
                                   // tarea - usuario - fecha
                                  $cantidadHoras = $ci->Horas_model->consultar_horas($value->id,$idEmpleado,$i);                  



                                    // sumas Vertical y Horizontal  

                                    $array_sumaHorizontal['sumaHorizontal'][$value->id] += $cantidadHoras[0]['hora'];
                                    $array_sumaVertical['sumaVertical'][$i] += $cantidadHoras[0]['hora'];

                                     // 

                                  

                                    



                             ?>

                                  <td style="mso-number-format:'0.00';" align="center"  class="hidden-phone">

                                        <?php echo ($cantidadHoras[0]['hora']!='')?toHours($cantidadHoras[0]['hora'],0):'0';?>

                                     </td>

                                  <?php 



                                      }// FOR DE DIAS





                                  ?>

                            

                            <!-- Suma Totales Horizontal -->                          

                            <td style="mso-number-format:'0.00';" id="Tarea<?php echo $value->id;?>" align="center" >

                              <b>

                                  <?php echo toHours($array_sumaHorizontal['sumaHorizontal'][$value->id],0);?>

                              </b>

                            </td>

                            <!-- Suma Totales Horizontal -->                                  

                          



                            </tr>







                               <?php } // while tareas ?>

                               

                               <!-- Suma ToTales Vertical -->

                                <tr>                                

                                      <td class="sumVert">

                                          <i class="fa fa-tags"></i> <b>TOTAL:</b>

                                      </td>
                                      <td class="sumVert">&nbsp;</td>
                                      <?php for($x=$fecha1;$x<=$fecha2;$x = date("Y-m-d", strtotime($x ."+ 1 days"))){ ?>

                                      <td style="mso-number-format:'0.00';" id="fec<?php echo $x;?>" align="center" class="hidden-phone">
                                        <b><?php echo toHours($array_sumaVertical['sumaVertical'][$x],0);?></b>

                                      </td>



                                <?php }?>     



                                  <!--Suma Totales-->

                                  <td style="mso-number-format:'0.00';" id="SumaTotalVerticalHorizontal" align="center">

                                    <b>

                                    <?php

                                     

                                   echo $TotalMinutos =    number_format((array_sum($array_sumaVertical['sumaVertical'])/60),2) ;


                                        //echo toHours($TotalMinutos,0);



                                      ?>

                                    </b>

                                  </td>

                                  <!--Suma Totales-->



                                </tr>

                              <!-- Suma Totales Vertical -->





                              </tbody>

                          </table>       

           