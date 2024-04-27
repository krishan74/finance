<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

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

		$this->load->model('SignAuthority');
		$data['AllSignAuth'] = $this->SignAuthority->fetchAllSign();

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Create Client'));
		$this->load->view('dashboard/create-client/specific-header', $data);
		$this->load->view('includes/footer');
	}

	public function saveClient() {

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

		$partyName = $this->input->post('partyName', TRUE);
		$partyAlias = $this->input->post('partyAlias', TRUE);
		$partyEmail = $this->input->post('partyEmail', TRUE);
		$partyAlternateEmail = $this->input->post('partyAlternateEmail', TRUE);
		$partyPhone = $this->input->post('partyPhone', TRUE);
		$partyAlternatePhone = $this->input->post('partyAlternatePhone', TRUE);
		$partyAddressLine1 = $this->input->post('partyAddressLine1', TRUE);
		$partyAddressLine2 = $this->input->post('partyAddressLine2', TRUE);
		$partyCity = $this->input->post('partyCity', TRUE);
		$partyState = $this->input->post('partyState', TRUE);
		$partyCountry = $this->input->post('partyCountry', TRUE);
		$partyZip = $this->input->post('partyZip', TRUE);
		$partyOtherAddressLine1 = $this->input->post('partyOtherAddressLine1', TRUE);
		$partyOtherAddressLine2 = $this->input->post('partyOtherAddressLine2', TRUE);
		$partyOtherCity = $this->input->post('partyOtherCity', TRUE);
		$partyOtherState = $this->input->post('partyOtherState', TRUE);
		$partyOtherCountry = $this->input->post('partyOtherCountry', TRUE);
		$partyOtherZip = $this->input->post('partyOtherZip', TRUE);
		$defaultSigningAuthority = $this->input->post('defaultSigningAuthority', TRUE);
		$signAuthCheckbox = empty($this->input->post('signAuthCheckbox')) ? "" : $this->input->post('signAuthCheckbox');

		$NumberOfContact = $this->input->post('NumberOfContact', TRUE);
		$bankCounter = $this->input->post('bankCounter', TRUE);

		if(!empty($signAuthCheckbox)) { 
			$signAuthCheckboxJson = json_encode($signAuthCheckbox);
		} else {
			$signAuthCheckboxJson = "";
		}

		$contactPerson = array();

		$contactPersonName = $this->input->post('contactPersonName', TRUE);
		$contactPersonEmail = $this->input->post('contactPersonEmail', TRUE);
		$contactPersonPhone = $this->input->post('contactPersonPhone', TRUE); 
		$designation = $this->input->post('designation', TRUE);

		for($contactIndex = 0; $contactIndex < count($contactPersonName); $contactIndex++) {

			$contactPerson[] = array(
				'contactPersonName' => $contactPersonName[$contactIndex],
				'contactPersonEmail' => $contactPersonEmail[$contactIndex],
				'contactPersonPhone' => $contactPersonPhone[$contactIndex], 
				'designation' => $designation[$contactIndex]
			);
		}

		$contactPersonJson = json_encode($contactPerson);

		$beneficiaryName = $this->input->post('beneficiaryName', TRUE);
		$bankName = $this->input->post('bankName', TRUE);
		$bankAddress = $this->input->post('bankAddress', TRUE);
		$accountNo = $this->input->post('accountNo', TRUE);
		$rtgsNeftIfsCode = $this->input->post('rtgsNeftIfsCode', TRUE);
		$swiftCode = $this->input->post('swiftCode', TRUE);

		$bankDetail = array();
		for($i = 0; $i < count($beneficiaryName); $i++) {
			$bankDetail[] = array(
			'beneficiaryName' => $beneficiaryName[$i], 
			'bankName' => $bankName[$i], 
			'bankAddress' => $bankAddress[$i], 
			'accountNo' => $accountNo[$i], 
			'rtgsNeftIfsCode' => $rtgsNeftIfsCode[$i], 
			'swiftCode' => $swiftCode[$i]
			);
		}

		$bankDetailJson = json_encode($bankDetail);

		$userDetailsParam = array(
			'partyName' => $partyName,
			'partyAlias' => $partyAlias,
			'partyEmail' => $partyEmail,
			'partyAlternateEmail' => $partyAlternateEmail,
			'partyPhone' => $partyPhone,
			'partyAlternatePhone' => $partyAlternatePhone,
			'partyAddressLine1' => $partyAddressLine1,
			'partyAddressLine2' => $partyAddressLine2,
			'partyCity' => $partyCity,
			'partyState' => $partyState,
			'partyCountry' => $partyCountry,
			'partyZip' => $partyZip,
			'partyOtherAddressLine1' => $partyOtherAddressLine1,
			'partyOtherAddressLine2' => $partyOtherAddressLine2,
			'partyOtherCity' => $partyOtherCity,
			'partyOtherState' => $partyOtherState,
			'partyOtherCountry' => $partyOtherCountry,
			'partyOtherZip' => $partyOtherZip,
			'defaultSigningAuthority' => $defaultSigningAuthority,
			'contactPersonDetail' => $contactPersonJson,
			'signingAuthority' => $signAuthCheckboxJson,
			'bankDetail' => $bankDetailJson
		);

		$this->load->model('CommonModel');
		$returnId = $this->CommonModel->insert('client_detail', $userDetailsParam);

		if($returnId < 1 || empty($returnId)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Save Client Details.' 
			));
			die();
		} else {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'Client Added Successfully' 
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
		$data['AllSignAuth'] = $this->SignAuthority->fetchAllSign();

		$this->load->model('ClientDetail');
		$result = $this->ClientDetail->fetchAllClientDetails();	
		$data['AllClientDetails'] = $result;

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard'));
		$this->load->view('dashboard/view_client/specific-header', $data);
		$this->load->view('includes/footer');  		
	}	

	public function modifyClient() {
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
		$hiddenId = $this->input->post('hiddenId', TRUE);

		$partyName = $this->input->post('partyName', TRUE);
		$partyAlias = $this->input->post('partyAlias', TRUE);
		$partyEmail = $this->input->post('partyEmail', TRUE);
		$partyAlternateEmail = $this->input->post('partyAlternateEmail', TRUE);
		$partyPhone = $this->input->post('partyPhone', TRUE);
		$partyAlternatePhone = $this->input->post('partyAlternatePhone', TRUE);
		$partyAddressLine1 = $this->input->post('partyAddressLine1', TRUE);
		$partyAddressLine2 = $this->input->post('partyAddressLine2', TRUE);
		$partyCity = $this->input->post('partyCity', TRUE);
		$partyState = $this->input->post('partyState', TRUE);
		$partyCountry = $this->input->post('partyCountry', TRUE);
		$partyZip = $this->input->post('partyZip', TRUE);
		$partyOtherAddressLine1 = $this->input->post('partyOtherAddressLine1', TRUE);
		$partyOtherAddressLine2 = $this->input->post('partyOtherAddressLine2', TRUE);
		$partyOtherCity = $this->input->post('partyOtherCity', TRUE);
		$partyOtherState = $this->input->post('partyOtherState', TRUE);
		$partyOtherCountry = $this->input->post('partyOtherCountry', TRUE);
		$partyOtherZip = $this->input->post('partyOtherZip', TRUE);
		$defaultSigningAuthority = $this->input->post('defaultSigningAuthority', TRUE);
		$signAuthCheckbox = empty($this->input->post('signAuthCheckbox')) ? "" : $this->input->post('signAuthCheckbox');

		$NumberOfContact = $this->input->post('NumberOfContact', TRUE);
		$bankCounter = $this->input->post('bankCounter', TRUE);

		if(!empty($signAuthCheckbox)) { 
			$signAuthCheckboxJson = json_encode($signAuthCheckbox);
		} else {
			$signAuthCheckboxJson = "";
		}

		$contactPerson = array();

		$contactPersonName = $this->input->post('contactPersonName', TRUE);
		$contactPersonEmail = $this->input->post('contactPersonEmail', TRUE);
		$contactPersonPhone = $this->input->post('contactPersonPhone', TRUE); 
		$designation = $this->input->post('designation', TRUE);

		for($contactIndex = 0; $contactIndex < count($contactPersonName); $contactIndex++) {

			$contactPerson[] = array(
				'contactPersonName' => $contactPersonName[$contactIndex],
				'contactPersonEmail' => $contactPersonEmail[$contactIndex],
				'contactPersonPhone' => $contactPersonPhone[$contactIndex], 
				'designation' => $designation[$contactIndex]
			);
		}

		$contactPersonJson = json_encode($contactPerson);

		$beneficiaryName = $this->input->post('beneficiaryName', TRUE);
		$bankName = $this->input->post('bankName', TRUE);
		$bankAddress = $this->input->post('bankAddress', TRUE);
		$accountNo = $this->input->post('accountNo', TRUE);
		$rtgsNeftIfsCode = $this->input->post('rtgsNeftIfsCode', TRUE);
		$swiftCode = $this->input->post('swiftCode', TRUE);

		$bankDetail = array();
		for($i = 0; $i < count($beneficiaryName); $i++) {
			$bankDetail[] = array(
			'beneficiaryName' => $beneficiaryName[$i], 
			'bankName' => $bankName[$i], 
			'bankAddress' => $bankAddress[$i], 
			'accountNo' => $accountNo[$i], 
			'rtgsNeftIfsCode' => $rtgsNeftIfsCode[$i], 
			'swiftCode' => $swiftCode[$i]
			);
		}

		$bankDetailJson = json_encode($bankDetail);

		$userDetailsParam = array(
			'partyName' => $partyName,
			'partyAlias' => $partyAlias,
			'partyEmail' => $partyEmail,
			'partyAlternateEmail' => $partyAlternateEmail,
			'partyPhone' => $partyPhone,
			'partyAlternatePhone' => $partyAlternatePhone,
			'partyAddressLine1' => $partyAddressLine1,
			'partyAddressLine2' => $partyAddressLine2,
			'partyCity' => $partyCity,
			'partyState' => $partyState,
			'partyCountry' => $partyCountry,
			'partyZip' => $partyZip,
			'partyOtherAddressLine1' => $partyOtherAddressLine1,
			'partyOtherAddressLine2' => $partyOtherAddressLine2,
			'partyOtherCity' => $partyOtherCity,
			'partyOtherState' => $partyOtherState,
			'partyOtherCountry' => $partyOtherCountry,
			'partyOtherZip' => $partyOtherZip,
			'defaultSigningAuthority' => $defaultSigningAuthority,
			'contactPersonDetail' => $contactPersonJson,
			'signingAuthority' => $signAuthCheckboxJson,
			'bankDetail' => $bankDetailJson
		);

		$this->load->model('ClientDetail');
		$return = $this->ClientDetail->modify($userDetailsParam, $hiddenId);

		if($return != TRUE) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Modify Client Details.' 
			));
			die();
		} else {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'Client Details Modified Successfully!' 
			));
			die();			
		}
	}

	public function resetPassword() {

		$admin_detail_id = $this->input->post('id', true);
		$this->load->model('UserDetail');
		$result = $this->UserDetail->fetchUserById($admin_detail_id);

		if(empty($result)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'User Not Found.'
			));
			die();			
		}
		
		$plainPassword = rand(1000000, 9999999);
		$password = md5($plainPassword);

		$userLoginParam = array(
			'password' => $password
		);

		$this->load->model('CommonModel');
		$resultUpdate = $this->CommonModel->updateUserLoginById($userLoginParam, $admin_detail_id);	

		$to = $result[0]['email'];
		$username = $result[0]['username'];
		$firstName = $result[0]['firstName'];

		if($this->sendUserCredentialEmail($to, $username, $plainPassword, $firstName)) {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'Password Reset done successfully.'
			));
			die();				
		} else {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to reset password.'
			));
			die();			
		}	

	}

	private function sendUserCredentialEmail($to, $username, $password, $firstName) {

		$toArray = array($to);
		$subject = "Credentials for Admin Finanace Portal";
		$message = '<html> 
						<body>  
						<div style="width: 100%">  
							<h2 style="background-color: gainsboro; padding: 20px; text-align: center">Credentials for Admin Finanace Portal</h2>
							<div style="width: 100%; padding: 20px;">
								<h3>Hello ' . $firstName . '</h3>
								<h3>To access Admin Finanace Portal, Please Visit URL - <a href="' . base_url() . '">' . base_url() . '</a></h3>
								<h3>Username: ' . $username . '</h3>
								<h3>Password: ' . $password . '</h3>
								<h3>Regards!</h3>
								<h3>Admin Finance</h3>
							</div>  
						</div> 
						</body> 
					</html>';


		$this->load->library('SendEmail');
		return $this->sendemail->send($toArray, $subject, $message);
	}

	public function fetchClientById() {

		$id = $this->input->post('id', true);

		$this->load->model('ClientDetail');
		$clientResult = $this->ClientDetail->fetchClientById($id);

		$signId = $clientResult[0]['defaultSigningAuthority'];
		$bankDetail = $clientResult[0]['bankDetail'];
		$bankDetailArray = json_decode($bankDetail, TRUE);

		$this->load->model('SignAuthority');
		$signResult = $this->SignAuthority->fetchSigningById($signId);

		if(!empty($clientResult[0]['signingAuthority'])) {
			$otherSigningJson = $clientResult[0]['signingAuthority'];
			$otherSigningArr = json_decode($otherSigningJson, TRUE);
			
			$otherSignResult = $this->SignAuthority->fetchSignByJson($otherSigningArr);
		}
		$allsigning = array();

		if(!empty($signResult)) {
			$allsigning[] = $signResult[0];	
		}
		
		if(!empty($otherSignResult)) {
			foreach($otherSignResult as $key => $value) {
			 	if($signResult[0]['id'] == $value['id']) {
			 		continue;
			 	}
			 	$allsigning[] = $value;
			}
		}	

		if(empty($clientResult) || empty($signResult)) {
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
					'output' => $clientResult,
					'sign' => $signResult,
					'allSigning' => $allsigning,
					'bankDetail' => $bankDetailArray
				)
			);
			die();			
		}	
	}


	public function fetchClientByName() {

		$companyName = $this->input->post('companyName', true);

		$this->load->model('ClientDetail');
		$result = $this->ClientDetail->fetchClientByName($companyName);

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

	public function deleteClientById() {
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

		$this->load->model('ClientDetail');
		$result = $this->ClientDetail->deleteClientById($id);

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

	public function changePassword() {

		$id = $this->session->LoginId;
		$password = $this->input->post('newPassword', TRUE);
		$oldPassword = $this->input->post('oldPassword', TRUE);
		$encryptedPassword = md5($password);

		$this->load->model('UserDetail');
		$result = $this->UserDetail->changePasswordById($id, $encryptedPassword, $oldPassword);

		if($result) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Password Changed Successfully!'
				)
			);
			die();				
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Old Password doesn\'t match!'
				)
			);
			die();			
		}
	}		
}
