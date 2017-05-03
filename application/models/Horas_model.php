<?php



class Horas_model extends CI_Model {





        public function __construct()

        {

                // Call the CI_Model constructor

                parent::__construct();

        }


        public function consultar_horas($tarea, $usuario,$dia)

        {



         //   $query = $this->db->query("call consultar_horas(".$tarea.",".$usuario.",'".$dia."');");



                $this->db->select('hora,id');

                $this->db->from('tarea_detalle');

                $this->db->where('tarea_id', $tarea);

                $this->db->where('usuario_id', $usuario);

                $this->db->where('fecha', $dia);

                $query = $this->db->get();

                 //   echo $this->db->last_query();


                return $query->result_array();       

        }



        public function guardar_horas($data){



                $insert = $this->db->insert('tarea_detalle', $data);

                return $insert;

        }



        public function actualizar_horas($id, $data)

        {

                $this->db->where('id', $id);

                $this->db->update('tarea_detalle', $data);

        }





        public function sumaVertical($fecha,$usuario_id){



                $query = $this->db->query("select  sum(hora) as SumaVertical from tarea_detalle where fecha = '".$fecha."' and usuario_id = '".$usuario_id."' ");



                return $query->result_array();       

        }



        public function sumaHorizontal($fecha1,$fecha2,$tarea,$usuario_id){

                $query = $this->db->query(" select  sum(hora) as SumaHorizontal from tarea_detalle where fecha BETWEEN   '".$fecha1."' and  '".$fecha2."' and tarea_id = '".$tarea."' and usuario_id = '".$usuario_id."' ");


                return $query->result_array();

        }


        public function sumaTotal($fecha1,$fecha2,$usuario_id){

            $query = $this->db->query(" select  sum(hora) as SumaTotal from tarea_detalle where fecha BETWEEN   '".$fecha1."' and   '".$fecha2."' and usuario_id = '".$usuario_id."' ");

            return $query->result_array();
        }            

 
         public function LimpiarFilas($fecha1,$fecha2,$tarea_id,$usuario){


        //SELECT * FROM `tarea_detalle` where fecha between '2016-07-18' and '2016-07-24' and tarea_id = 10
            
            $query = $this->db->query(" update tarea_detalle set hora = 0 
                                                                            where
                                                                                 fecha between '".$fecha1."' and '".$fecha2."' and  
                                                                                 tarea_id = '".$tarea_id."' and
                                                                                 usuario_id = '".$usuario."'

                                                                                 ");


         }   

}

?>