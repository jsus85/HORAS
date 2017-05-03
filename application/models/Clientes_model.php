<?php

class Clientes_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

      
        public function get_last_clientes()
        {

                $this->db->order_by("id", "desc"); 
                $query = $this->db->get('clientes');
                return $query->result();
        }

      
        /**
        * Clientes nuevo registro en la  database
        * @param array $data - associative array with data to areas
        * @return boolean 
        */
        function guardar_clientes($data)
        {
                $insert = $this->db->insert('clientes', $data);
                return $insert;
        }



            /**
            * Get areas by his is
            * @param int $id 
            * @return array
            */
            public function get_clientes_by_id($id)
            {
                        
                $this->db->select('*');
                $this->db->from('clientes');
                $this->db->where('id', $id);
                $query = $this->db->get();

                return $query->result_array(); 
            }


            /**
            * Update employer
            * @param array $data - associative array with data to store
            * @return boolean
            */
            function actualizar_clientes($id, $data)
            {
                $this->db->where('id', $id);
                $this->db->update('clientes', $data);
              
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
            * Delete clientes
            * @param int $id - clientes id
            * @return boolean
            */
            function delete_clientes($id){

                $this->db->where('id', $id);
                $this->db->delete('clientes'); 
            }


            /**
            * Estate clientes
            * @param int $id - employer id
            * @return boolean
            */
            function state_clientes($id){

                $this->db->select('estado');
                $this->db->from('clientes');
                $this->db->where('id', $id);
                $query = $this->db->get();
                
                $estado = ($query->result_array()[0]['estado']==1)?'0':'1';


                    $data_to_areas = array(

                            'estado'   => $estado
                    );


                $this->db->where('id', $id);
                $this->db->update('clientes', $data_to_areas);


            }


}
?>