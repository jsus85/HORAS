<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareasxempleado extends CI_Controller {

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
			    $this->load->model('TareasxEmpleado_model');	
			    $this->load->model('Empleado_model');	
			    $this->load->model('Clientes_model');	

			               
        }

		public function index()
		{

		    
		    $data['listado']    =  $this->TareasxEmpleado_model->get_last_empleados();  			
			$this->load->view('tareasxempleado',$data);
		}


		public function add(){

				$id_empleado = $this->uri->segment(3);
				$data_empleado = $this->Empleado_model->get_empleado_by_id($id_empleado);

				$data['tareas_list']  		  =  $this->TareasxEmpleado_model->get_tareasxarea_by_id($data_empleado[0]['area_id']);
				$data['clientes_list']        =  $this->Clientes_model->get_last_clientes();
				$data['tareasxempleado_list'] =  $this->TareasxEmpleado_model->get_last_tareas($id_empleado);


				//datos enviados por post 
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

					$this->form_validation->set_rules('tarea', 'Tarea', 'trim|required|is_natural_no_zero');
					$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|is_natural_no_zero');


					if($this->form_validation->run() == FALSE)
					{

						$data['message_error'] = TRUE;

					}else{

							$data_to_campos = array(
													'empleado_id'    => $id_empleado,          
													'area_config_id' => $this->input->post('tarea'),
													'cliente_id'	 => $this->input->post('cliente'),
													'fecha'     	 =>  'now()' 

							);

		                //si inserta correctamente  retorna true
		                if($this->TareasxEmpleado_model->guardar_tareaxempleado($data_to_campos)){

								redirect('index.php/tareasxempleado/add/'.$id_empleado);

		                }else{
		                    $data['message_error'] = FALSE; 
		                }


					}// Else	

				}// IF		

		// 
						
			$this->load->view('tareasxempleado_nuevo.php',$data);  
		}	// End Funcion Add



	

		/**
	    * Delete tareasxempleado by his id
	    * @return void
	    */

	    public function delete()
	    {
	      
		        //tareasxempleado id 
	        $id = $this->uri->segment(3);
	        $this->TareasxEmpleado_model->delete_tareasxempleado($id);
	        redirect('index.php/tareasxempleado/add/'.$this->uri->segment(4));
	 
	    }//delete


	  




}
