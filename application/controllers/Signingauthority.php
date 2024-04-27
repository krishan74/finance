<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signingauthority extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->LoginId) || empty($this->session->UserName) || empty($this->session->UserRole)) {
			$this->session->set_userdata('authentication_error', 'Authentication Failed Or Session Expired');
			redirect();
		}		
	}

	public function create() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Create Client'));
		$this->load->view('dashboard/create-signing/specific-header');
		$this->load->view('includes/footer');
	}

	public function saveAuthority() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}

		$authorityName = $this->input->post('authorityName', TRUE);
		$authorityDesignation = $this->input->post('authorityDesignation', TRUE);
		$authorityPhone = $this->input->post('authorityPhone', TRUE);
		$authorityEmail = $this->input->post('authorityEmail', TRUE);
		$authorityAddress = $this->input->post('authorityAddress', TRUE);

		$userDetailsParam = array(
			'authorityName' => $authorityName,
			'authorityDesignation' => $authorityDesignation,
			'authorityPhone' => $authorityPhone,
			'authorityEmail' => $authorityEmail,
			'authorityAddress' => $authorityAddress
		);

		$this->load->model('CommonModel');
		$returnId = $this->CommonModel->insert('signing_authority', $userDetailsParam);

		if($returnId < 1 || empty($returnId)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Add Signing Authority.' 
			));
			die();
		} else {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'Signing Authority Added Successfully!' 
			));
			die();			
		}				
	}

	public function manage() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->model('SignAuthority');
		$result = $this->SignAuthority->fetchAllSign();	
		$data['AllSignAuthority'] = $result;

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard'));
		$this->load->view('dashboard/view_sign/specific-header', $data);
		$this->load->view('includes/footer');  		
	}	

	public function modifySigning() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}

		$hiddenId = $this->input->post('hiddenId', TRUE);

		$authorityName = $this->input->post('authorityName', TRUE);
		$authorityDesignation = $this->input->post('authorityDesignation', TRUE);
		$authorityPhone = $this->input->post('authorityPhone', TRUE);
		$authorityEmail = $this->input->post('authorityEmail', TRUE);
		$authorityAddress = $this->input->post('authorityAddress', TRUE);

		$userDetailsParam = array(
			'authorityName' => $authorityName,
			'authorityDesignation' => $authorityDesignation,
			'authorityPhone' => $authorityPhone,
			'authorityEmail' => $authorityEmail,
			'authorityAddress' => $authorityAddress
		);

		$this->load->model('SignAuthority');
		$return = $this->SignAuthority->modify($userDetailsParam, $hiddenId);

		if($return != TRUE) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Modify Signing Authority Details.' 
			));
			die();
		} else {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'Signing Authority Modified Successfully!' 
			));
			die();			
		}
	}


	public function fetchSigningById() {

		$id = $this->input->post('id', true);

		$this->load->model('SignAuthority');
		$result = $this->SignAuthority->fetchSigningById($id);

		if(empty($result)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'No Details Found'
				)
			);
			die();
		} else {
			echo json_encode(
				array(
					'code' => 1,
					'output' => $result
				)
			);
			die();			
		}	
	}

	public function deleteSigningById() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Authentication Failed'
				)
			);
			die();
		}

		$id = $this->input->post('id', true);

		if(empty($id)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'ID not found!'
				)
			);
			die();			
		}

		$this->load->model('SignAuthority');
		$result = $this->SignAuthority->deleteSigningById($id);

		if($result) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Deleted Client Successfully!'
				)
			);
			die();				
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Delete Client!'
				)
			);
			die();			
		}		

	}

	public function fetchSigningByJson() {

		$json = $this->input->post('json');
		$jsonArr = json_decode($json, true);
		$this->load->model('SignAuthority');
		$output = $this->SignAuthority->fetchSignByJson($jsonArr);
		
		if(!empty($output)) {
			echo json_encode(
				array(
					'code' => 1,
					'output' => $output
				)
			);
			die();				
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to fetchSigning!'
				)
			);
			die();			
		}		

	}			
}
