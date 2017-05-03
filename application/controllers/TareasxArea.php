<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TareasxArea extends CI_Controller {

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
			    $this->load->model('TareasxArea_model');	
			    $this->load->model('Empleado_model');	
			               
        }

		public function index()
		{
			

			$this->load->model('Empleado_model');	  
			$data['areas_list'] =  $this->Empleado_model->get_last_areas();

			// listado de las tareas por area
			$area_id = $this->security->xss_clean($this->input->post('area'));
		    
		    $data['listado']    =  $this->TareasxArea_model->get_last_tareas($area_id);  			
			
			$this->load->view('tareasxarea',$data);
		}


		public function add(){

				$data['areas_list'] =  $this->Empleado_model->get_last_areas();

				//datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('area', 'Area', 'trim|required|is_natural_no_zero');
					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');

					if($this->form_validation->run() == FALSE)
					{

						$data['message_error'] = TRUE;

					}else{

							$data_to_campos = array(
													'nombres'     => $this->input->post('nombres'),          
													'fecha'		  => 'now()',
													'descripcion' => $this->input->post('descripcion'),
													'area_id'     => $this->input->post('area')

							);

		                //si inserta correctamente  retorna true
		                if($this->TareasxArea_model->guardar_tareaxarea($data_to_campos)){

								redirect('index.php/tareasxarea', 'refresh');

		                }else{
		                    $data['message_error'] = FALSE; 
		                }


					}// Else	

				}// IF		

		// 
			
								
			$this->load->view('tareasxarea_nuevo.php',$data);  
		}	// End Funcion Add



		public function edit(){

			//empleado id 
	        $id = $this->uri->segment(3);
				$data['areas_list'] =  $this->Empleado_model->get_last_areas();

	        //datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');

					if($this->form_validation->run() == FALSE){

							$data['message_error'] = TRUE;

					}else{

							$data_to_campos = array(
													'nombres'     => $this->input->post('nombres'),          
													
													'descripcion' => $this->input->post('descripcion'),
													'area_id'     => $this->input->post('area')
							);

							$this->TareasxArea_model->actualizar_tareasxarea($id, $data_to_campos);
							redirect('index.php/tareasxarea', 'refresh');
							
					}
				}			
	        
	        //employer data 
	        $data['employer'] = $this->TareasxArea_model->get_tareasxarea_by_id($id);
	        $this->load->view('tareasxarea_editar.php',$data); 

		}


		/**
	    * Delete tareasxarea by his id
	    * @return void
	    */

	    public function delete()
	    {
	      
	        //tareasxarea id 
	        $id = $this->uri->segment(3);
	        $this->TareasxArea_model->delete_tareasxarea($id);
	        redirect('index.php/tareasxarea');
	    
	    }//delete


	    /**
	    * State tareasxarea by his id
	    * @return void
	    */
	    public function state()
	    {


	    
	    
	        //tareasxarea id 
	        $id = $this->uri->segment(3);
	        $this->TareasxArea_model->state_tareasxarea($id);
	        redirect('index.php/tareasxarea');
	    
	    }//update




}
