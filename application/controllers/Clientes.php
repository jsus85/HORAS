<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

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
			    $this->load->model('Clientes_model');	  
			               
        }

		public function index()
		{
			
		    $data['listado'] =  $this->Clientes_model->get_last_clientes();  			
			$this->load->view('clientes',$data);

		}
// 

		public function add(){

				$data = null;
				//datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');

					if($this->form_validation->run() == FALSE)
					{

						$data['message_error'] = TRUE;

					}else{

							$data_to_clientes = array(
													'nombres'   => $this->input->post('nombres'),          
													'fecha'		=> 'now()'
							);



		                //si inserta correctamente  retorna true
		                if($this->Clientes_model->guardar_clientes($data_to_clientes)){

								     redirect('index.php/clientes', 'refresh');

		                }else{
		                    $data['message_error'] = FALSE; 
		                }


					}// Else	

				}// IF		

		// 
			
								
			$this->load->view('clientes_nuevo.php',$data);  
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

							$data_to_clientes = array(

									'nombres'   => $this->input->post('nombres')
							);

							$this->Clientes_model->actualizar_clientes($id, $data_to_clientes);
							redirect('index.php/clientes', 'refresh');
							
					}
				}			
	        
	        //employer data 
	        $data['employer'] = $this->Clientes_model->get_clientes_by_id($id);
	        $this->load->view('clientes_editar.php',$data); 

		}


		/**
	    * Delete clientes by his id
	    * @return void
	    */
	    public function delete()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Clientes_model->delete_clientes($id);
	        redirect('index.php/clientes');
	    
	    }//delete


	    /**
	    * State clientes by his id
	    * @return void
	    */
	    public function state()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Clientes_model->state_clientes($id);
	        redirect('index.php/clientes');
	    
	    }//update




}
