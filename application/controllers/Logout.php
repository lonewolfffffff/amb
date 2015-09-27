<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function index() {
		if($this->session->userdata('user')) {
			$this->session->unset_userdata('user');
		}
		redirect('login','refresh');
	}
	
}