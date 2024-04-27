<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

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

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - HR Portal'));
		$this->load->view('dashboard/template/specific-header');
		$this->load->view('includes/footer');

	}

	public function loadTemplate($templateName) {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->model('ClientDetail');
		$data['clientNameArr'] = $this->ClientDetail->fetchClientNameId();
		$data['templateName'] = $templateName;

		$this->load->helper(array('form'));

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - HR Portal'));
		$this->load->view('dashboard/template/template', $data);
		$this->load->view('includes/footer');

	}	

	public function editTemplate($taskId) {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->model('TemplateModel');
		$data['taskDetail'] = $this->TemplateModel->fetchTemplateById($taskId);
		$data['userId'] = $this->session->LoginId;

		$scheduleAFilename = empty($data['taskDetail'][0]['scheduleAFilename']) ? "" : $data['taskDetail'][0]['scheduleAFilename'];

		if(!empty($scheduleAFilename) && file_exists(FCPATH . 'assets/scheduleA/' . $scheduleAFilename)) {

			copy(FCPATH . 'assets/scheduleA/' . $scheduleAFilename, FCPATH . 'assets/temp-schedule-a/' . $scheduleAFilename);
			
		}

		$templateName = empty($data['taskDetail'][0]['templateName']) ? "" : $data['taskDetail'][0]['templateName'];

		if(empty($templateName)) {
			redirect('error/invalidrequest');
		}

		$data['allDataArr'] = json_decode($data['taskDetail'][0]['allDataJson'], TRUE);

		$partiesJson = $data['taskDetail'][0]['companyId'];
		$partyIdArr = json_decode($partiesJson, TRUE);
		
		$this->load->model('ClientDetail');
		$this->load->model('SignAuthority');
		
		$allClientConsolidatedData = array();
		
		foreach ($partyIdArr as $key => $value) {	
			try {
				$resultData = $this->ClientDetail->fetchClientById($value);
				if(!empty($resultData)) {	
					$allClientConsolidatedData[$value]['data'] = $resultData[0];
					$defaultSignatory = array($resultData[0]['defaultSigningAuthority']);
					$signingAuthorityArr = empty($resultData[0]['signingAuthority']) ? array() : json_decode($resultData[0]['signingAuthority'], TRUE);
					
					$signingAuthorityArr = array_merge($defaultSignatory, $signingAuthorityArr);

					$allClientConsolidatedData[$value]['signing'] = $this->SignAuthority->fetchSignByJson($signingAuthorityArr);

					$allClientConsolidatedData[$value]['bankDetail'] = json_decode($resultData[0]['bankDetail'], TRUE);
				}
			} catch (EXCEPTION $e) { }
		}

		$data['allClient'] = $allClientConsolidatedData; 
		$data['clientNameArr'] = $this->ClientDetail->fetchClientNameId();

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - HR Portal'));
		
		$this->load->view('dashboard/template/edit/template', $data);
		$this->load->view('includes/footer');
	}

	public function saveContact($templateName) {

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

		$CompanyId = $this->input->post('CompanyId');
		$CompanyIdJson = json_encode($CompanyId);

		$CompanyName = $this->input->post('CompanyName');
		$CompanyNameJson = json_encode($CompanyName);

		if(count($CompanyId) < 2) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Error Occured! There should be atleast two parties.'
				)
			);
			die();
		}

		$allData = $_POST;
		
		$replaceArray = array();
		for($i = 0; $i < count($CompanyId); $i++) {
			$replaceArray['CompanyId' . ($i + 1)] = $CompanyId[$i];
			$replaceArray['CompanyName' . ($i + 1)] = $allData['CompanyName'][$i];
			$replaceArray['CompanyAlias' . ($i + 1)] = $allData['CompanyAlias'][$i];
			$replaceArray['CompanyAliasUC' . ($i + 1)] = ucwords($allData['CompanyAlias'][$i]);

			$replaceArray['SigningAuthorityId' . ($i + 1)] = $allData['SigningAuthorityId'][$i];
			$replaceArray['SigningAuthorityName' . ($i + 1)] = $allData['SigningAuthorityName'][$i];
			$replaceArray['SigningAuthorityEmail' . ($i + 1)] = $allData['SigningAuthorityEmail'][$i];
			$replaceArray['SigningAuthorityPhone' . ($i + 1)] = $allData['SigningAuthorityPhone'][$i];
			$replaceArray['SigningAuthorityDesignation' . ($i + 1)] = $allData['SigningAuthorityDesignation'][$i];
			$replaceArray['AddressType' . ($i + 1)] = $allData['party' . ($i + 1) . 'AddressType'];
			$replaceArray['AddressLine1' . ($i + 1)] = $allData['AddressLine1'][$i];
			$replaceArray['AddressLine2' . ($i + 1)] = $allData['AddressLine2'][$i];
			$replaceArray['City' . ($i + 1)] = $allData['City'][$i];

			$replaceArray['State' . ($i + 1)] = $allData['State'][$i];
			$replaceArray['Country' . ($i + 1)] = $allData['Country'][$i];
			$replaceArray['Zip' . ($i + 1)] = $allData['Zip'][$i];
			$replaceArray['AddressLine2' . ($i + 1)] = $allData['AddressLine2'][$i];
			$replaceArray['FullAddress' . ($i + 1)] = $allData['FullAddress'][$i];

			$replaceArray['Benficiary' . ($i + 1)] = $allData['Benficiary'][$i];
			$replaceArray['BankName' . ($i + 1)] = $allData['BankName'][$i];
			$replaceArray['BankAddress' . ($i + 1)] = $allData['BankAddress'][$i];
			$replaceArray['AccoountNo' . ($i + 1)] = $allData['AccoountNo'][$i];
			$replaceArray['RtgsNeftIfsCode' . ($i + 1)] = $allData['RtgsNeftIfsCode'][$i];

			$replaceArray['SwiftCode' . ($i + 1)] = $allData['SwiftCode'][$i];
		}

		$custom = $this->input->post('custom');

		if(!empty($custom)) {
			foreach ($custom as $key => $value) {
				if($key == 0) {
					$date = strtotime($value);
					$date = date('F d, Y', $date);
					$replaceArray['custom' . ($key + 1)] = $date;
				} elseif($key == 1 || $key == 5) {
					$replaceArray['custom' . ($key + 1)] = $value;
					$date = strtotime($value);
					$date = date('F d, Y', $date);
					$replaceArray['customdatewords' . ($key + 1)] = $date;
				}else {
					$replaceArray['custom' . ($key + 1)] = $value;
				}
			}
		}

		$htmlData = array();

		if(!empty($allData['customTextArea'])) {
			foreach ($allData['customTextArea'] as $key => $value) {
				$htmlData['customTextArea' . ($key + 1)] = $value;				
	 		}
		}

		if(isset($_POST['oldFileName'])) {
			$oldFileName = $this->input->post('oldFileName', TRUE);	
			$path = FCPATH . "assets/created-templates/";

			if(!empty($oldFileName) && file_exists($path . $oldFileName)) {
				unlink($path . $oldFileName);
			}
		} else {
			$oldFileName = "";	
		}

		$allDataJson = json_encode($_POST);

		$templateName = $templateName . ".docx";	

		$this->load->library('TemplateLibrary');

		$scheduleAoption = $this->input->post('scheduleAoption', true);

		if($scheduleAoption == 2) { 
			$uploadedFilename = "";
		} else {
			$uploadedFilename = $this->input->post('uploadedFilename', true);
		}	

		$returnValue = $this->templatelibrary->saveTemplate($templateName, $replaceArray, $htmlData, $allDataJson, $CompanyIdJson, $CompanyNameJson, $uploadedFilename, $oldFileName);

		if($returnValue == FALSE) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed To Create Template'
				)
			);
			die();
		} else {
			echo json_encode(
				array(
					'code' => 1,
					'fileName' => $returnValue 
				)
			);
			die();
		}
	}

	public function changeStatusTemplate() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Access Denied'
				)
			);
			die();
		}

		$id = $this->input->post('id', TRUE);
		$this->load->model('TemplateModel');
		if($this->TemplateModel->changeStatus($id)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Sent Agreement to Signing queue'
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Send Agreement'
				)
			);
			die();			
		}
	}


	public function deleteTemplate() {

		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Access Denied'
				)
			);
			die();
		}

		$path = FCPATH . "assets/created-templates/";
		$oldFileName = $this->input->post('oldFileName', true);

		if(file_exists($path . $oldFileName)) {
			unlink($path . $oldFileName);
		}
		
		$this->load->model('TemplateModel');
		if($this->TemplateModel->deleteTemplate($oldFileName)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Agreement Deleted Successfully'
				)
			);
			die();
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Delete Template Draft'
				)
			);
			die();
		}
	}

	public function creatorqueue() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->creatorQueue();
		$data['sentQueueName'] = "Create Queue";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Create Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 
	}

	public function draft() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ProgramLeadAccess", $roles) && !in_array("SigningQueueAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->myDraft();
		$data['sentQueueName'] = "My Draft";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - My Template Draft'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 
	}

	public function completeQueue() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->completedQueue();
		$data['sentQueueName'] = "Final Contracts";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Completed Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 
	}

	public function alltaskqueue() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("ContractAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}
		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->allTask();
		$data['sentQueueName'] = "All Task Queue";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - All Task Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 

	}

	public function vetterQueue() {
		
		$roles = $this->session->UserRole;
		
		if (!in_array("VetterAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->myVetter();
		$data['sentQueueName'] = "Vetter Queue";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Vetter Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 
	}	

	public function signingQueue() {

		$roles = $this->session->UserRole;
		
		if (!in_array("SigningQueueAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->mySigning();
		$data['sentQueueName'] = "Signing Queue";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Signing Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 

	}	


	public function programLeadQueue() {

		$roles = $this->session->UserRole;
		
		if (!in_array("ProgramLeadAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
			die();
		}

		$this->load->model('TemplateModel');
		$data['allMyTemplates'] = $this->TemplateModel->myProgramLead();
		$data['sentQueueName'] = "Program Lead Queue";
		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Program Lead Queue'));
		$this->load->view('dashboard/view_template/specific-header', $data);
		$this->load->view('includes/footer'); 

	}	



	public function savefinalcontract() {
				
		$statusName = $this->input->post('statusName', TRUE);
		$emailNotes = $this->input->post('finalNotes', TRUE);
		$id = $this->input->post('hiddenTaskId', TRUE);
		$templateCode = $this->input->post('templateCode', TRUE);

		if($_FILES['finalFile']['size'] < 1) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload a File.'
				)
			);
			die();			
		}

		$filename = $_FILES['finalFile']['name'];
		$filenameArr = explode('.', $filename);
		$ext = end($filenameArr);

		if($ext != 'docx' && $ext != 'pdf') {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload Docx or Pdf File.'
				)
			);
			die();			
		}

		$filePath = FCPATH . 'assets/final-contract/';
		$filename = 'ContractId-' . $id . "-" . date('YmdHis') . "." . $ext;
		if(!move_uploaded_file($_FILES['finalFile']['tmp_name'], $filePath . $filename)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to upload file!'
				)
			);
			die();
		}

		$this->load->model('TemplateModel');
		$resultNotes = $this->TemplateModel->fetchNotesById($id);
		$previousNotes = empty($resultNotes[0]['taskNotes']) ? "" : $resultNotes[0]['taskNotes'];

		date_default_timezone_set("America/New_York");
		
		$note = date('Y-m-d H:i:s') . "\n";
		$note .= "Task Id: " . $templateCode . "\n";
		$note .= "Name: " . $this->session->name . "\n";
		$note .= "Email: " . $this->session->email . "\n";
		$note .= "Status: " . $statusName . "\n"; 
		$note .= "Notes: " . $emailNotes . "\n";
		$note .= "\n\n" . $previousNotes;

		$updateTaskArray = array(
			'status' => $statusName,
			'taskNotes' => $note,
			'finalSignedContract' => $filename
		);

		if($this->TemplateModel->updateTemplateById($updateTaskArray, $id)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Contract Sent'
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Send Contract'
				)
			);
			die();			
		}
	}


	public function saveCompletedSignedContract() {
				
		$statusName = 'Completed';
		$queueName = 'Completed';
		$toEmail = $this->input->post('completedTo', TRUE);
		$ccEmail = $this->input->post('completedCC', TRUE);
		$bccEmail = $this->input->post('completedBCC', TRUE);
		$subject = $this->input->post('completedSubject', TRUE);
 		$emailNotes = $this->input->post('completedEmailNotes', TRUE);		


		$id = $this->input->post('hiddenTaskId', TRUE);
		$templateCode = $this->input->post('templateCode', TRUE);
		
		if($_FILES['completedFinalFile']['size'] < 1) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload a File.'
				)
			);
			die();			
		}

		$filename = $_FILES['completedFinalFile']['name'];
		$filenameArr = explode('.', $filename);
		$ext = end($filenameArr);

		if($ext != 'pdf' && $ext != 'docx') {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload PDF File.'
				)
			);
			die();			
		}

		$filePath = FCPATH . 'assets/final-contract/';
		$filename = 'ContractId-' . $id . "-" . date('YmdHis') . "." . $ext;

		if(!move_uploaded_file($_FILES['completedFinalFile']['tmp_name'], $filePath . $filename)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to upload file!'
				)
			);
			die();
		}

		$this->load->model('TemplateModel');
		$resultNotes = $this->TemplateModel->fetchNotesById($id);
		$previousNotes = empty($resultNotes[0]['taskNotes']) ? "" : $resultNotes[0]['taskNotes'];

		date_default_timezone_set("America/New_York");
		
		$note = date('Y-m-d H:i:s') . "\n";
		$note .= "Task Id: " . $templateCode . "\n";
		$note .= "Name: " . $this->session->name . "\n";
		$note .= "Email: " . $this->session->email . "\n";
		$note .= "Status: " . $statusName . "\n"; 
		$note .= "Notes: " . $emailNotes . "\n";
		$note .= "To: " . $toEmail . "\n";
		$note .= "CC: " . $ccEmail . "\n";
		$note .= "BCC: " . $bccEmail . "\n";
		$note .= "Subject: " . $subject . "\n";
		$note .= "\n\n" . $previousNotes;

		$updateTaskArray = array(
			'status' => $statusName,
			'queueName' => $queueName,
			'assignedTo' => "",
			'taskNotes' => $note,
			'finalSignedContract' => $filename
		);

		if(!$this->TemplateModel->updateTemplateById($updateTaskArray, $id)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Save Contract'
				)
			);
			die();			
		}


 		if(!empty($toEmail)) {
 			$toEmail = str_replace(" ", "", $toEmail);
			$toEmailArray = explode(',', $toEmail);

			$ccEmailArray = array();
			if(!empty($ccEmail)) {
				$ccEmail = str_replace(" ", "", $ccEmail);
				$ccEmailArray = explode(',', $ccEmail);
			}

			$bccEmailArray = array();
			if(!empty($bccEmail)) {
				$bccEmail = str_replace(" ", "", $bccEmail);
				$bccEmailArray = explode(',', $bccEmail);
			}		

			$subject = "Contract Id: " . $templateCode . ". " . $subject;
			$message = html_entity_decode($emailNotes);

			$filepath = FCPATH . "assets/final-contract/";
			$this->load->model('TemplateModel');
			$resultNotes = $this->TemplateModel->fetchTemplateById($id);
			$filename = $resultNotes[0]['finalSignedContract'];
			
			if(empty($filename)) {
				array(
					'code' => 0,
					'msg' => 'Upload Final Contract first.'
				);
				die();			
			}
			$CompleteFileName = $filepath . $filename;
			$CompleteFileNameArray = array($CompleteFileName);

			$this->load->library('SendEmail');
			if(!$this->sendemail->send($toEmailArray, $subject, $message, $CompleteFileNameArray, $ccEmailArray, $bccEmailArray)) {

				echo json_encode(
					array(
						'code' => 0,
						'msg' => 'Unable to Send Email'
					)
				);
				die();			
			}
 		}

		echo json_encode(
			array(
				'code' => 1,
				'msg' => 'Contract Sent'
			)
		);
		die();		
	}


	public function sendemailtoclient() {
		
		$statusName = "Email Sent";
		
		$toEmail = $this->input->post('clientETo', TRUE);
		$ccEmail = $this->input->post('clientECC', TRUE);
		$bccEmail = $this->input->post('clientEBCC', TRUE);
		$subject = $this->input->post('clientSubject', TRUE);
 		$emailNotes = $this->input->post('clientENotes', TRUE);
		$id = $this->input->post('hiddenClientTaskId', TRUE);
		$templateCode = $this->input->post('sendEmailTemplateCode', TRUE);

		$toEmail = str_replace(" ", "", $toEmail);
		$toEmailArray = explode(',', $toEmail);

		$ccEmailArray = array();

		if(!empty($ccEmail)) {

			$ccEmail = str_replace(" ", "", $ccEmail);
			$ccEmailArray = explode(',', $ccEmail);

		}

		$bccEmailArray = array();
		if(!empty($bccEmail)) {

			$bccEmail = str_replace(" ", "", $bccEmail);
			$bccEmailArray = explode(',', $bccEmail);

		}		

		$subject = "Contract Id: " . $templateCode . ". " . $subject;
		$message = html_entity_decode($emailNotes);

		$filepath = FCPATH . "assets/final-contract/";
		$this->load->model('TemplateModel');
		$resultNotes = $this->TemplateModel->fetchTemplateById($id);
		$filename = $resultNotes[0]['finalSignedContract'];
		
		if(empty($filename)) {
			array(
				'code' => 0,
				'msg' => 'Upload Final Contract first.'
			);
			die();			
		}
		$CompleteFileName = $filepath . $filename;
		$CompleteFileNameArray = array($CompleteFileName);

		$this->load->library('SendEmail');
		
		//print_r($toEmailArray);die;
		
		if(!$this->sendemail->send($toEmailArray, $subject, $message, $CompleteFileNameArray, $ccEmailArray, $bccEmailArray)) {

			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to Send Email'
				)
			);
			die();			
		}

		$previousNotes = empty($resultNotes[0]['taskNotes']) ? "" : $resultNotes[0]['taskNotes'];

		date_default_timezone_set("America/New_York");
		
		$note = date('Y-m-d H:i:s') . "\n";
		$note .= "Task Id: " . $templateCode . "\n";
		$note .= "Name: " . $this->session->name . "\n";
		$note .= "Email: " . $this->session->email . "\n";
		$note .= "To: " . $toEmail . "\n";
		$note .= "CC: " . $ccEmail . "\n";
		$note .= "BCC: " . $bccEmail . "\n";
		$note .= "Status: " . $statusName . "\n"; 
		$note .= "Notes: " . $emailNotes . "\n";
		$note .= "Attached File: " . $filename . "\n";
		$note .= "\n\n" . $previousNotes;

		$updateTaskArray = array(
			'status' => $statusName,
			'taskNotes' => $note,
		);

		//if($this->TemplateModel->changeStatusToVetter($id)) {
		if($this->TemplateModel->updateTemplateById($updateTaskArray, $id)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'File Uploaded'
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Send Agreement'
				)
			);
			die();			
		}
	}



	public function completed() {
		
		$queueName = $this->input->post('queueName', TRUE);		
		$statusName = $this->input->post('statusName', TRUE);
		
		$toEmail = $this->input->post('to', TRUE);
		$ccEmail = $this->input->post('cc', TRUE);
		$emailNotes = $this->input->post('note', TRUE);
		$id = $this->input->post('taskId', TRUE);
		$templateCode = $this->input->post('templateCode', TRUE);

		$toEmailArray = array();

		if(!empty($toEmail)) {
			$toEmail = str_replace(" ", "", $toEmail);
			$toEmailArray = explode(',', $toEmail);
		}

		$ccEmailArray = array();
		
		if(!empty($ccEmail)) {

			$ccEmail = str_replace(" ", "", $ccEmail);
			$ccEmailArray = explode(',', $ccEmail);

		}

		$subject = "Task Id: " . $templateCode . " is completed.";
		$message = "Hi,<br>Task Id: " . $templateCode . " has been  by completed by " . $this->session->name . "(" . $this->session->email . "), details are mentioned below.<br>";
		$message .= html_entity_decode($emailNotes) . "<br>";

		if(!empty($toEmailArray)) {
			$this->load->library('SendEmail');
			if(!$this->sendemail->send($toEmailArray, $subject, $message, [], $ccEmailArray)) {
				echo json_encode(
					array(
						'code' => 0,
						'msg' => 'Unable to Send Email'
					)
				);

				die();			
			}
		}

		$this->load->model('TemplateModel');
		$resultNotes = $this->TemplateModel->fetchNotesById($id);
		$previousNotes = empty($resultNotes[0]['taskNotes']) ? "" : $resultNotes[0]['taskNotes'];

		date_default_timezone_set("America/New_York");
		
		$note = date('Y-m-d H:i:s') . "\n";
		$note .= "Task Id: " . $id . "\n";
		$note .= "Name: " . $this->session->name . "\n";
		$note .= "Email: " . $this->session->email . "\n";
		$note .= "Assigned To: " . $toEmail . "\n";
		$note .= "Queue To: " . $queueName . "\n";
		$note .= "Status: " . $statusName . "\n"; 
		$note .= "Notes: " . $emailNotes . "\n";
		$note .= "\n\n" . $previousNotes;

		$updateTaskArray = array(
			'queueName' => $queueName,
			'status' => $statusName,
			'taskNotes' => $note,
			'assignedTo' => ''
		);

		//if($this->TemplateModel->changeStatusToVetter($id)) {
		if($this->TemplateModel->updateTemplateById($updateTaskArray, $id)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Contract is Completed.'
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Send Contract'
				)
			);
			die();			
		}
	}		


	public function sendtovetter() {
		
		$queueName = $this->input->post('queueName', TRUE);		
		$statusName = $this->input->post('statusName', TRUE);
		
		$toEmail = $this->input->post('to', TRUE);
		$ccEmail = $this->input->post('cc', TRUE);
		$emailNotes = $this->input->post('note', TRUE);
		$id = $this->input->post('taskId', TRUE);
		$templateCode = $this->input->post('templateCode', TRUE);

		$toEmail = str_replace(" ", "", $toEmail);
		$toEmailArray = explode(',', $toEmail);
		$ccEmailArray = array();
		if(!empty($ccEmail)) {
			$ccEmail = str_replace(" ", "", $ccEmail);
			$ccEmailArray = explode(',', $ccEmail);
		}

		$subject = "Task Id: " . $templateCode . " is assigned to you.";
		$message = "Hi,<br>Task Id: " . $templateCode . " is assigned to you by " . $this->session->name . "(" . $this->session->email . "), details are mentioned below.<br>";
		$message .= html_entity_decode($emailNotes) . "<br>";
		$message .= '<p><a href="' . base_url() . '"><button style="background: rgb(66, 184, 221); color: white; border-radius: 4px;">Go To Website</button></a></p>';
 
		$this->load->library('SendEmail');
		if(!$this->sendemail->send($toEmailArray, $subject, $message, [], $ccEmailArray)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to Send Email'
				)
			);			
		}

		$this->load->model('TemplateModel');
		$resultNotes = $this->TemplateModel->fetchNotesById($id);
		$previousNotes = empty($resultNotes[0]['taskNotes']) ? "" : $resultNotes[0]['taskNotes'];

		date_default_timezone_set("America/New_York");
		
		$note = date('Y-m-d H:i:s') . "\n";
		$note .= "Task Id: " . $templateCode . "\n";
		$note .= "Name: " . $this->session->name . "\n";
		$note .= "Email: " . $this->session->email . "\n";
		$note .= "Assigned To: " . $toEmail . "\n";
		$note .= "Queue To: " . $queueName . "\n";
		$note .= "Status: " . $statusName . "\n"; 
		$note .= "Notes: " . $emailNotes . "\n";
		$note .= "\n\n" . $previousNotes;

		$updateTaskArray = array(
			'queueName' => $queueName,
			'status' => $statusName,
			'taskNotes' => $note,
			'assignedTo' => $toEmail
		);

	 
		if($this->TemplateModel->updateTemplateById($updateTaskArray, $id)) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Sent Agreement to Signing queue'
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Send Agreement'
				)
			);
			die();			
		}
	}
	
	
	public function test111() {
		
		$queueName = "CreateQueue";		
		$statusName = "Send to Creator";
		
		$toEmail = "jiten472k6@gmail.com"; 
		//$ccEmail = "jagdishchandra141@gmail.com";
		//$ccEmail = "rahish.niitdbg@yahoo.com";
		$ccEmail = "jiten472k6@yahoo.com";
		
		$emailNotes = "Test Final End after";
		$id = 133;
		$templateCode = "AHIL/210405/003";

		$toEmail = str_replace(" ", "", $toEmail);
		$toEmailArray = explode(',', $toEmail);
		$ccEmailArray = array();
		if(!empty($ccEmail)) {
			$ccEmail = str_replace(" ", "", $ccEmail);
			$ccEmailArray = explode(',', $ccEmail);
		}

		$subject = "Task Id: " . $templateCode . " is assigned to you.";
		$message = "Hi,<br>Task Id: " . $templateCode . " is assigned to you by " . $this->session->name . "(" . $this->session->email . "), details are mentioned below.<br>";
		$message .= html_entity_decode($emailNotes) . "<br>";
		$message .= '<p><a href="' . base_url() . '"><button style="background: rgb(66, 184, 221); color: white; border-radius: 4px;">Go To Website</button></a></p>';

		$this->load->library('SendEmail'); 
		 
		$CompleteFileName = FCPATH . 'assets/41-20210326101222697265537-AH_Charity_Grant_Agreement.docx';
		$CompleteFileNameArray = array($CompleteFileName); 
		
		if(!$this->sendemail->send($toEmailArray, $subject, $message, $CompleteFileNameArray, $ccEmailArray)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to Send Email'
				)
			);
			die();			
		}else{
		   echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Sent Email'
				)
			);
			die();		
		}
	}
	

	public function getfilename() {
		
		$username = $this->session->LoginId;
		header('Content-Type: text/plain');
		$output = '[';
		for($i = 1; $i < 20; $i++) {
			
			$output .= '{"url": "assets/contract_images/' . $username . '/upload.png"},';
			
		}
		$output = rtrim($output, ',');
		$output .= ']'; 
		echo $output;
	}

	public function saveScheduleAfile()	{

		if($_FILES['scheduleA']['size'] < 1) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => "File is empty or invalid!"
				)
			);
			die();
		}

		$path = FCPATH . "assets/temp-schedule-a/";
		$filename = date('YmdHis') . rand() . ".docx";

		if(move_uploaded_file($_FILES['scheduleA']['tmp_name'], $path . $filename)) {
			echo json_encode(
				array(
					'code' => 1,
					'filename' => $filename
				)
			);
			die();			
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => "Unable to Upload File!"
				)
			);
			die();			
		}
	}	
}
