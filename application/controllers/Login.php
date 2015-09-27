<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index() {
		$data['page'] = 'login';
		$data['body_class'] = 'login-page';
		
		if($this->input->post('username')) { 
			//validate
			$this->load->helper(array('form','security'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_validate_password');
			
			if($this->form_validation->run()==FALSE) {
				$this->load->view('template/auth/main',$data);
			}
			else {
				redirect('dashboard','refresh');
			}
		}
		else {
			$this->load->view('template/auth/main',$data);
		}
	}
	
	public function validate_password($password) {
		$username = $this->input->post('username');
		$this->load->model('user_model');
		$login_success = $this->user_model->login($username, $password);
		if($login_success) {
			$this->session->set_userdata('user', array('id'=>$login_success[0]->id,'username'=>$login_success[0]->username));
			return TRUE;
		}
		else {
			$this->form_validation->set_message('validate_password', 'Invalid username or password');
			return FALSE;
		}
	}
}