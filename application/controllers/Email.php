<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->LoginId) || empty($this->session->UserName) || empty($this->session->UserRole)) {
			$this->session->set_userdata('authentication_error', 'Authentication Failed Or Session Expired');
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}		
	}

	public function refresh_email() {

		$roles = $this->session->UserRole;
		
		if (!in_array("CreateTask", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}
		
		$this->load->library('fetchemailimap');
		$this->fetchemailimap->fetchEmail();
		redirect('dashboard/email-inbox');
	}

	public function email_inbox() {

		$roles = $this->session->UserRole;
		
		if (!in_array("CreateTask", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}	

		$this->load->model('CommonModel');
		$result = $this->CommonModel->fetchEmailReceived();

		date_default_timezone_set('Asia/Kolkata');

		$data['emailData'] = $result;

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard'));
		$this->load->view('dashboard/email_inbox/specific-header', $data);
		$this->load->view('includes/footer');     
	}	

	public function fetchEmail() {

		$filename = $this->input->post('filename', true);

		$roles = $this->session->UserRole;
		
		if (!in_array("CreateTask", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}

		$this->load->library('emailparser');
		$output = $this->emailparser->init($filename);

		echo json_encode(
			array(
				'code' => 1, 
				'data' => $output
			)
		);
	}	
}