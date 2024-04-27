<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->LoginId) || empty($this->session->UserName) || empty($this->session->UserRole)) {
			$this->session->set_userdata('authentication_error', 'Authentication Failed Or Session Expired');
			redirect();
		}		
	}

	public function index() {
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - HR Portal'));
		$this->load->view('dashboard/hr/specific-header');
		$this->load->view('includes/footer');
	}
}
