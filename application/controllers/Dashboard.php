<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Dashboard extends CI_Controller {
		public function index() {
			if($this->session->userdata('user')) {
				$user = $this->session->userdata('user');

				$data['sidebar'] = 'dashboard';
				$data['page'] = 'dashboard';
				$this->load->view('template/admin/main',$data);

			}
			else {
				redirect('login', 'refresh');
			}
		}
	}