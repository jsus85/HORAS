<?php



class Reportes_model extends CI_Model {





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



                return $query->result_array();       

        }





        public function get_last_tareas($empleado,$cliente)

        {



                $this->db->select('tareas.area_config_id, areas_config.descripcion,areas_config.nombres as nombretarea, tareas.cliente_id,tareas.id,clientes.nombres as nombrecliente'); 

                $this->db->from('tareas');    

                $this->db->join('areas_config', 'areas_config.id = tareas.area_config_id');

                $this->db->join('clientes', 'clientes.id = tareas.cliente_id');    

                $this->db->where('tareas.empleado_id',$empleado);

                

                if($cliente!=0){

                $this->db->where('tareas.cliente_id',$cliente);

                }   

                                         

                $this->db->order_by("tareas.cliente_id,tareas.area_config_id", "desc");  



                return $this->db->get()->result();               



        }

          

            public function get()

            {

            $fields = $this->db->field_data('empleados');

            $query = $this->db->select('*')->get('empleados');

            return array("fields" => $fields, "query" => $query);

            }

}

?>