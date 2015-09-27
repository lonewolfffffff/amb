<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Suratjalan extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			
		}
		
		public function add() {
			
		}
		
		public function edit() {
			
		}
		
		public function delete() {
			
		}
		
	}
