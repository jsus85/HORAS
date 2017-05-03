<?php

class TareasxArea_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

      
        public function get_last_tareas($area)
        {

                $this->db->order_by("id", "desc"); 
                $query = $this->db->get('areas_config');

                $this->db->select('areas_config.id,areas_config.estado,areas_config.nombres,areas.nombres as nombrearea');
                $this->db->from('areas_config');

                if($area!=0){
                    $this->db->where('areas_config.area_id',$area);     
                }
                
                $this->db->join('areas', 'areas.id = areas_config.area_id');
              
                $this->db->order_by("areas_config.id", "desc");   


               // return $query->result();

                return $this->db->get()->result();   
        }

      
        /**
        * TareaxArea nuevo registro en la  database
        * @param array $data - associative array with data to areas
        * @return boolean 
        */
        function guardar_tareaxarea($data)
        {
                $insert = $this->db->insert('areas_config', $data);
                return $insert;
        }




            /**
            * Get TareaxArea by his is
            * @param int $id 
            * @return array
            */
            public function get_tareasxarea_by_id($id)
            {
                        
                $this->db->select('*');
                $this->db->from('areas_config');
                $this->db->where('id', $id);
                $query = $this->db->get();

                return $query->result_array(); 
            }

            /**
            * Update TareaxArea
            * @param array $data - associative array with data to store
            * @return boolean
            */
            function actualizar_tareasxarea($id, $data)
            {
                $this->db->where('id', $id);
                $this->db->update('areas_config', $data);
              
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
            * Delete TareaxArea
            * @param int $id - tareaxArea id
            * @return boolean
            */
            function delete_tareasxarea($id){

                $this->db->where('id', $id);
                $this->db->delete('areas_config'); 
            }


            /**
            * Estate tareasxarea
            * @param int $id - tarea id
            * @return boolean
            */
            function state_tareasxarea($id){

                $this->db->select('estado');
                $this->db->from('areas_config');
                $this->db->where('id', $id);
                $query = $this->db->get();
                
                $estado = ($query->result_array()[0]['estado']==1)?'0':'1';


                    $data_to_areas = array(

                            'estado'   => $estado
                    );


                $this->db->where('id', $id);
                $this->db->update('areas_config', $data_to_areas);


            }


}
?>