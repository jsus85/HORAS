<?php

class Area_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

      
        public function get_last_areas()
        {

                $this->db->order_by("id", "desc"); 
                $query = $this->db->get('areas');
                return $query->result();
        }

      
        /**
        * Areas nuevo registro en la  database
        * @param array $data - associative array with data to areas
        * @return boolean 
        */
        function guardar_areas($data)
        {
                $insert = $this->db->insert('areas', $data);
                return $insert;
        }



            /**
            * Get areas by his is
            * @param int $id 
            * @return array
            */
            public function get_areas_by_id($id)
            {
                        
                $this->db->select('*');
                $this->db->from('areas');
                $this->db->where('id', $id);
                $query = $this->db->get();

                return $query->result_array(); 
            }

            /**
            * Update employer
            * @param array $data - associative array with data to store
            * @return boolean
            */
            function actualizar_areas($id, $data)
            {
                $this->db->where('id', $id);
                $this->db->update('areas', $data);
              
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
            function delete_areas($id){

                $this->db->where('id', $id);
                $this->db->delete('areas'); 
            }


            /**
            * Estate areas
            * @param int $id - employer id
            * @return boolean
            */
            function state_areas($id){

                $this->db->select('estado');
                $this->db->from('areas');
                $this->db->where('id', $id);
                $query = $this->db->get();
                
                $estado = ($query->result_array()[0]['estado']==1)?'0':'1';


                    $data_to_areas = array(

                            'estado'   => $estado
                    );


                $this->db->where('id', $id);
                $this->db->update('areas', $data_to_areas);


            }


}
?>