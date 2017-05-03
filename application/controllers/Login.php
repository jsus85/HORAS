<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function index()
	{
		$this->load->view('login');
	}


	public function panel(){
		$this->load->view('panel');		
		
	}


	public function validar(){

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');


		if($this->form_validation->run() == FALSE)
		{

			$data['message_error'] = TRUE;
			$this->load->view('login',$data);

		}else{

			$this->load->model('Login_model');

			$user_name = $this->input->post('email');
			$password  = $this->input->post('password');

			$is_valid = $this->Login_model->validate($user_name, $password);

			if( $is_valid[0]->estado ==1 )
			{
			
				$data = array(
					'user_name'    => $user_name,
					'tipo'         => $is_valid[0]->tipo,
					'nombres'      => $is_valid[0]->nombres,
					'area'		   => $is_valid[0]->area_id,
					'idEmpleado'   => $is_valid[0]->id,
					'is_logged_in' => true
				);


				$this->session->set_userdata($data);

				if($is_valid[0]->tipo==1){
				
					//$this->load->view('panel', $data);					
					redirect(base_url('index.php/empleados'));					
									
				
				}else if($is_valid[0]->tipo==2){

					redirect(base_url('index.php/horas'));					
				}
			
			}else // incorrect username or password
			{
				$data['message_error'] = TRUE;
				$this->load->view('login', $data);	
			}


		}// ELSE


	}//End funcion



    public function logout() {

        $this->session->unset_userdata('tipo');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('nombres');
        $this->session->unset_userdata('is_logged_in');
      
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect(base_url());
    }

}
