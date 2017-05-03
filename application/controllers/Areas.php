<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */ 

	  public function __construct()
        {
                parent::__construct();
                // Your own constructor code
			    $this->load->model('Area_model');	  
			               
        }

		public function index()
		{
			
		    $data['emplados_list'] =  $this->Area_model->get_last_areas();  			
			$this->load->view('areas',$data);

		}
// 

		public function add(){

				$data = NULL;
				//datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');

					if($this->form_validation->run() == FALSE)
					{

						$data['message_error'] = TRUE;

					}else{

							$data_to_areas = array(
													'nombres'   => $this->input->post('nombres'),          
													'fecha'		=> 'now()'
							);



		                //si inserta correctamente  retorna true
		                if($this->Area_model->guardar_areas($data_to_areas)){

								     redirect('index.php/areas', 'refresh');

		                }else{
		                    $data['message_error'] = FALSE; 
		                }


					}// Else	

				}// IF		

		// 
			
								
			$this->load->view('areas_nuevo.php',$data);  
		}	// End Funcion Add



		public function edit(){

			//empleado id 
	        $id = $this->uri->segment(3);


	        //datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');

					if($this->form_validation->run() == FALSE){

							$data['message_error'] = TRUE;

					}else{

							$data_to_areas = array(

													'nombres'   => $this->input->post('nombres')
							);

							$this->Area_model->actualizar_areas($id, $data_to_areas);
							redirect('index.php/areas', 'refresh');
							
					}
				}			
	        
	        //employer data 
	        $data['employer'] = $this->Area_model->get_areas_by_id($id);
	        $this->load->view('areas_editar.php',$data); 

		}


		/**
	    * Delete employer by his id
	    * @return void
	    */
	    public function delete()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Area_model->delete_areas($id);
	        redirect('index.php/areas');
	    
	    }//delete


	    /**
	    * State employer by his id
	    * @return void
	    */
	    public function state()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Area_model->state_areas($id);
	        redirect('index.php/areas');
	    
	    }//update




}
