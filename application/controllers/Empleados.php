<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

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
			    $this->load->model('Empleado_model');	  
			               
        }

		public function index()
		{
			
			if (!$this->session->userdata('idEmpleado'))
			{
				redirect(base_url(), 'refresh');
			}

		    $data['emplados_list'] =  $this->Empleado_model->get_last_empleados();  			
			$this->load->view('empleados',$data);

		}
// 

		public function add(){

			     $data['areas_list'] =  $this->Empleado_model->get_last_areas();

				//datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
					$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required|is_natural_no_zero');
					$this->form_validation->set_rules('area', 'Area', 'trim|required|is_natural_no_zero');

					if($this->form_validation->run() == FALSE)
					{

						$data['message_error'] = TRUE;

					}else{

							$data_to_empleados = array(
													'nombres'   => $this->input->post('nombres'),
													'email' 	=> $this->input->post('email'),
													'password'  => $this->input->post('password'),
													'tipo' 		=> $this->input->post('tipo'),          
													'fecha'		=> 'now()',
													'area_id'   => $this->input->post('area')
							);



		                //si inserta correctamente  retorna true
		                if($this->Empleado_model->guardar_empleados($data_to_empleados)){

								     redirect('index.php/empleados', 'refresh');

		                }else{
		                    $data['message_error'] = FALSE; 
		                }


					}// Else	

				}// IF		

		// 
			
								
			$this->load->view('empleados_nuevo.php',$data);  
		}	// End Funcion Add



		public function edit(){

			//empleado id 
	        $id = $this->uri->segment(3);
	        $data['areas_list'] =  $this->Empleado_model->get_last_areas();



	        //datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
					$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required|is_natural_no_zero');
					$this->form_validation->set_rules('area', 'Area', 'trim|required|is_natural_no_zero');

					if($this->form_validation->run() == FALSE){

							$data['message_error'] = TRUE;

					}else{

							$data_to_empleados = array(

													'nombres'   => $this->input->post('nombres'),
													'email' 	=> $this->input->post('email'),
													'password'  => $this->input->post('password'),
													'tipo' 		=> $this->input->post('tipo'),          
													'fecha'		=> 'now()',
													'area_id'   => $this->input->post('area')
							);

							$this->Empleado_model->actualizar_empleados($id, $data_to_empleados);
							redirect('index.php/empleados', 'refresh');
							
					}
				}			
	        
	        //employer data 
	        $data['employer'] = $this->Empleado_model->get_empleado_by_id($id);
	        $this->load->view('empleados_editar.php',$data); 

		}


		/**
	    * Delete employer by his id
	    * @return void
	    */
	    public function delete()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Empleado_model->delete_empleados($id);
	        redirect('index.php/empleados');
	    
	    }//delete


	    /**
	    * State employer by his id
	    * @return void
	    */
	    public function state()
	    {
	      
	        //employer id 
	        $id = $this->uri->segment(3);
	        $this->Empleado_model->state_empleados($id);
	        redirect('index.php/empleados');
	    
	    }//update




}
