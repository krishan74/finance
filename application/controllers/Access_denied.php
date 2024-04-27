<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access_denied extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->LoginId) || empty($this->session->UserName) || empty($this->session->UserRole)) {
			$this->session->set_userdata('authentication_error', 'Authentication Failed Or Session Expired');
			redirect();
		}		
	}

	public function index() {

		$roles = $this->session->UserRole;
		
		$this->load->view('includes/header-dashboard', array('title' => 'Access Denied'));
		$this->load->view('error-views/access-denied');
		$this->load->view('includes/footer');
	}
	
}
