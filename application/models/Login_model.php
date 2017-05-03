<?php

class Login_model extends CI_Model {

        public $title;
        public $content;
        public $date;

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function validate($email, $password)
        {


            $query = $this->db->query("select * from empleados where email = '".$email."' and password = '".$password."' ");
            //return  $query->num_rows();
            return $query->result();                

        }

        public function get_last_ten_entries()
        {
                $query = $this->db->get('empleados', 10);
                return $query->result();
        }

      
        public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->insert('entries', $this);
        }

        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->update('entries', $this, array('id' => $_POST['id']));
        }

}
?>