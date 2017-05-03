<?php



class TareasxEmpleado_model extends CI_Model {





        public function __construct()

        {

                // Call the CI_Model constructor

                parent::__construct();

        }



        /*

        * consulta para el listado principal

        */

        public function get_last_empleados()

        {



              //  $this->db->order_by("id", "desc"); 



                $this->db->select('empleados.id, empleados.nombres , empleados.email , areas.nombres as nombrearea');

                $this->db->from('empleados');

                

                $this->db->join('areas', 'areas.id = empleados.area_id');

              

                $this->db->order_by("empleados.id", "desc");   





               // return $query->result();

                return $this->db->get()->result();   

        }







        public function get_last_tareas($empleado)

        {



                $this->db->select('tareas.area_config_id, areas_config.descripcion, areas_config.nombres as nombretarea, tareas.cliente_id,tareas.id,clientes.nombres as nombrecliente'); 

                $this->db->from('tareas');    

                $this->db->join('areas_config', 'areas_config.id = tareas.area_config_id');

                $this->db->join('clientes', 'clientes.id = tareas.cliente_id');    

                $this->db->where('tareas.empleado_id',$empleado);            

                $this->db->order_by("tareas.cliente_id,tareas.area_config_id", "desc");     

                return $this->db->get()->result();               



        }

      



        /**

        * TareaxEmpleado nuevo registro en la  database

        * @param array $data - associative array with data to areas

        * @return boolean 

        */

        function guardar_tareaxempleado($data)

        {

                $insert = $this->db->insert('tareas', $data);

                return $insert;

        }





        /**

        * Get TareaxEmpleado by his is

        * @param int $id_empleado 

        * @return array

        * extrae las tareas por empleado

        */

        public function get_tareasxempleado_by_id($empleado)

        {

                    

            $this->db->select('*');

            $this->db->from('tareas');

            $this->db->where('empleado_id', $empleado);

            $query = $this->db->get()->result();



            //return $query->result_array(); 

        }







        /**

         * Obtener las tareas por el area del empleado

         * @param int $area_id

         */

        public function get_tareasxarea_by_id($area){





            $this->db->select('*');

            $this->db->from('areas_config');

            $this->db->where('area_id', $area);

            return $this->db->get()->result();



            //return $query->result_array(); 



        }

    



        /**

        * Delete TareaxEmpleado

        * @param int $id - tareaxEmpleado id

        * @return boolean

        */

        function delete_tareasxempleado($id){



            $this->db->where('id', $id);

            $this->db->delete('tareas'); 

        }





          



}

?>