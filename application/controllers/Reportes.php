<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

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
                $this->load->helper('mysql_to_excel_helper');
			    $this->load->model('TareasxEmpleado_model');
			    $this->load->model('Reportes_model');
			    $this->load->model('Clientes_model');	
				$this->load->model('Empleado_model');	  				    
			               
        }

		public function index()
		{



			if (!$this->session->userdata('idEmpleado'))
				{
					redirect(base_url(), 'refresh');
				}

				

				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

						$data['fecha_inicial'] = substr($this->input->post('fechas'),0,10);
						$data['fecha_final']   = substr($this->input->post('fechas'),12,16);
						$data['cmbCliente']    = $this->input->post('cliente');	
						$data['cmbEmpleados']  = $this->input->post('empleados');						
				}

			$employer = $this->Empleado_model->get_empleado_by_id($this->input->post('empleados'));



			$data['emplados_list']          =  $this->Empleado_model->get_last_empleados();  	
		    $data['tareas_empleados']       =  $this->TareasxEmpleado_model->get_tareasxarea_by_id($employer[0]['area_id']);  	
		    $data['tareacliente_empleados'] =  $this->Reportes_model->get_last_tareas($employer[0]['id'],$this->input->post('cliente'));
		    $data['horas']                  = array_horas();
		    $data['clientes_list']          =  $this->Clientes_model->get_last_clientes();
			
			$this->load->view('reportes',$data);

		}



		// no funcion
		public function export(){

		
				

			$data['fecha_inicial'] = $this->uri->segment(3);
			$data['fecha_final']   = $this->uri->segment(4);
			$data['cmbCliente']    = $this->uri->segment(5);						
	
		    $employer = $this->Empleado_model->get_empleado_by_id($this->uri->segment(6));
		    $data['idEmpleado'] = $employer[0]['id'];
			

		    
			$data['emplados_list']          =  $this->Empleado_model->get_last_empleados();  	
		    $data['tareas_empleados']       =  $this->TareasxEmpleado_model->get_tareasxarea_by_id($employer[0]['area_id']);  	
		    $data['tareacliente_empleados'] =  $this->Reportes_model->get_last_tareas($employer[0]['id'],$this->input->post('cliente'));
		    $data['horas']                  = array_horas();
		    $data['clientes_list']          =  $this->Clientes_model->get_last_clientes();
			
		

			$this->load->view('reportes-xls',$data);


		}

		

}
