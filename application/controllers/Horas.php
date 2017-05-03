<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horas extends CI_Controller {

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
			    $this->load->model('Horas_model');
			               
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
						$data['fecha_final'] = substr($this->input->post('fechas'),12,16);
				}

			

		    $data['tareas_empleados']       =  $this->TareasxEmpleado_model->get_tareasxarea_by_id($this->session->userdata('area'));  	
		    $data['tareacliente_empleados'] =  $this->TareasxEmpleado_model->get_last_tareas($this->session->userdata('idEmpleado'));
		    $data['horas']                  = array_horas();
			$this->load->view('horas',$data);

		}
// 

		public function add(){

				
				//datos enviados por post - ajax
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

				
					
				$cantidadHoras = 	$this->Horas_model->consultar_horas($this->input->post('tarea'),$this->input->post('usuario'),$this->input->post('fecha'));
							
							

					if(isset($cantidadHoras[0]['hora'])){				
						// actualiza la hora	
						
						$data_to_campos = array( 'hora'	=> $this->input->post('hora'));

						$this->Horas_model->actualizar_horas($cantidadHoras[0]['id'], $data_to_campos);
								

					}else{
						// inserta las horas
						$data_to_campos = array(  'tarea_id'     => $this->input->post('tarea'),          
												  'fecha'		 =>  $this->input->post('fecha'),
												  'hora'	     => $this->input->post('hora'),
												  'usuario_id'     => $this->input->post('usuario'));

						$this->Horas_model->guardar_horas($data_to_campos);

					}

						
					// Suma Vertical
					$data1 = $this->Horas_model->sumaVertical($this->input->post('fecha'),$this->input->post('usuario'));
					

					$data2 = $this->Horas_model->sumaHorizontal($this->input->post('fecha1'),$this->input->post('fecha2'),$this->input->post('tarea'),$this->input->post('usuario'));
					

					$data3 = $this->Horas_model->sumaTotal($this->input->post('fecha1'),$this->input->post('fecha2'),$this->input->post('usuario'));

					//$sumaTotalVH =  ($data3[0]['SumaTotal']);
					$sumaTotalVH =  ($data3[0]['SumaTotal']*2);

					echo toHours($data1[0]['SumaVertical'],1).'*'.toHours($data2[0]['SumaHorizontal'],1).'*'.toHours($sumaTotalVH,1);

				}// IF		
		
		// 
					
		}	// End Funcion Add



	  public function editHourforRow(){

			  	//datos enviados por post - ajax
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{

						$this->Horas_model->LimpiarFilas($this->input->post('fecha1'),$this->input->post('fecha2'),$this->input->post('tarea'),$this->input->post('usuario'));

						// Suma Vertical
					$data1 = $this->Horas_model->sumaVertical($this->input->post('fecha'),$this->input->post('usuario'));
					

					$data2 = $this->Horas_model->sumaHorizontal($this->input->post('fecha1'),$this->input->post('fecha2'),$this->input->post('tarea'),$this->input->post('usuario'));
					

					$data3 = $this->Horas_model->sumaTotal($this->input->post('fecha1'),$this->input->post('fecha2'),$this->input->post('usuario'));

					//$sumaTotalVH =  ($data3[0]['SumaTotal']);
					$sumaTotalVH =  ($data3[0]['SumaTotal']*2);

					echo toHours($data1[0]['SumaVertical'],1).'*'.toHours($data2[0]['SumaHorizontal'],1).'*'.toHours($sumaTotalVH,1);

				}	


	  }// End funcion 



}
