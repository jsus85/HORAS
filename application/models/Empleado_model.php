<?php

class Empleado_model extends CI_Model {

        public $title;
        public $content;
        public $date;

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

      
        public function get_last_empleados()
        {

                $this->db->order_by("id", "desc"); 
                $query = $this->db->get('empleados');
                return $query->result();
        }

        public function get_last_areas()
        {
                $query = $this->db->get('areas');
                return $query->result();
        }

      
        /**
        * Empleados nuevo registro en la  database
        * @param array $data - associative array with data to empleados
        * @return boolean 
        */
        function guardar_empleados($data)
        {
                $insert = $this->db->insert('empleados', $data);
                return $insert;
        }



            /**
            * Get employer by his is
            * @param int $id 
            * @return array
            */
            public function get_empleado_by_id($id)
            {
                        
                $this->db->select('*');
                $this->db->from('empleados');
                $this->db->where('id', $id);
                $query = $this->db->get();

                return $query->result_array(); 
            }

            /**
            * Update employer
            * @param array $data - associative array with data to store
            * @return boolean
            */
            function actualizar_empleados($id, $data)
            {
                $this->db->where('id', $id);
                $this->db->update('empleados', $data);
              
                /*
                $report = array();
                $report['error']   = $this->db->_error_number();
                $report['message'] = $this->db->_error_message();
           
                if($report !== 0){
                    return true;
                }else{
                    return false;
                }
                */

            }


            /**
            * Delete employer
            * @param int $id - employer id
            * @return boolean
            */
            function delete_empleados($id){

                $this->db->where('id', $id);
                $this->db->delete('empleados'); 
            }


            /**
            * Estate employer
            * @param int $id - employer id
            * @return boolean
            */
            function state_empleados($id){

                $this->db->select('estado');
                $this->db->from('empleados');
                $this->db->where('id', $id);
                $query = $this->db->get();
                
                $estado = ($query->result_array()[0]['estado']==1)?'0':'1';


                    $data_to_empleados = array(

                            'estado'   => $estado
                    );


                $this->db->where('id', $id);
                $this->db->update('empleados', $data_to_empleados);


            }


}
?>