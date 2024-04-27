<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->LoginId) || empty($this->session->UserName) || empty($this->session->UserRole)) {
			$this->session->set_userdata('authentication_error', 'Authentication Failed Or Session Expired');
			redirect();
		}		
	}

	public function manage() {

		$roles = $this->session->UserRole;
		
		if (!in_array("UserAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->model('UserDetail');
		$result = $this->UserDetail->fetchAllUserDetails();	
		$data['AllUserDetails'] = $result;

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard'));
		$this->load->view('dashboard/view_user/specific-header', $data);
		$this->load->view('includes/footer');  		

	}

	public function create() {

		$roles = $this->session->UserRole;
		
		if (!in_array("UserAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			redirect('access_denied');
		}

		$this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Create Internal User'));
		$this->load->view('dashboard/create-user/specific-header');
		$this->load->view('includes/footer');
	}

	public function saveUser() {

		$roles = $this->session->UserRole;
		
		if (!in_array("UserAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}

		$firstName = $this->input->post('firstName', TRUE);
		$lastName = $this->input->post('lastName', TRUE);
		$phoneNo = $this->input->post('phoneNo', TRUE);
		$mobileNo = $this->input->post('mobileNo', TRUE);
		$email = $this->input->post('email', TRUE);
		$officePhoneNo = $this->input->post('officePhoneNo', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$dateOfBirth = $this->input->post('dateOfBirth', TRUE);
		$address = $this->input->post('address', TRUE);
		$username = $this->input->post('username', TRUE);
		$plainPassword = $this->input->post('password');
		$password = md5($this->input->post('password'));
		$roles = $this->input->post('roles', TRUE);
		$rolesJson = json_encode(array('role' => $roles));
		$sendEmailWithCredentials = $this->input->post('sendEmailWithCredentials', TRUE);

		$userDetailsParam = array(
			'firstName' => $firstName,
			'lastName' => $lastName,
			'phoneNo' => $phoneNo,
			'email' => $email,
			'officePhoneNo' => $officePhoneNo,
			'mobileNo' => $mobileNo,
			'gender' => $gender,
			'dateOfBirth' => $dateOfBirth,
			'address' => $address

		);

		$this->load->model('CommonModel');
		$returnId = $this->CommonModel->insert('admin_user', $userDetailsParam);

		if($returnId < 0 || empty($returnId)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Save User Details.' 
			));
			die();
		}

		$userLoginParam = array(
			'admin_detail_id' => $returnId,
			'username' => $username,
			'password' => $password,
			'role' => $rolesJson,
			'status' => '1'
		);

		$returnLoginId = $this->CommonModel->insert('admin_login', $userLoginParam);

		if($returnLoginId < 0 || empty($returnLoginId)) {

			$this->CommonModel->delete('admin_user', $returnId);

			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Save User Login Credentials.'
			));
			die();
		} else {
			
			if($sendEmailWithCredentials == 1) {
				$this->sendUserCredentialEmail($email, $username, $plainPassword, $firstName);
			}

			echo json_encode(array(
				'code' => 1,
				'msg' => 'User Created Successfully.' 
			));
			die();
		}				
	}

	public function modifyUser() {

		$roles = $this->session->UserRole;
		
		if (!in_array("UserAccess", $roles) && !in_array("SuperAdmin", $roles)) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Access Denied.' 
			));
			die();
		}

		$hiddenId = $this->input->post('hiddenId', TRUE);
		$firstName = $this->input->post('firstName', TRUE);
		$lastName = $this->input->post('lastName', TRUE);
		$phoneNo = $this->input->post('phoneNo', TRUE);
		$mobileNo = $this->input->post('mobileNo', TRUE);
		$email = $this->input->post('email', TRUE);
		$hiddenEmail = $this->input->post('hiddenEmail', TRUE);
		$officePhoneNo = $this->input->post('officePhoneNo', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$dateOfBirth = $this->input->post('dateOfBirth', TRUE);
		$address = $this->input->post('address', TRUE);
		$username = $this->input->post('username', TRUE);
		$roles = $this->input->post('roles', TRUE);
		$status = $this->input->post('status', TRUE);
		$rolesJson = json_encode(array('role' => $roles));

		$userDetailsParam = array(
			'firstName' => $firstName,
			'lastName' => $lastName,
			'phoneNo' => $phoneNo,
			'email' => $email,
			'officePhoneNo' => $officePhoneNo,
			'mobileNo' => $mobileNo,
			'gender' => $gender,
			'dateOfBirth' => $dateOfBirth,
			'address' => $address

		);

		$admin_detail_id = $hiddenId;

		$this->load->model('CommonModel');
		$return = $this->CommonModel->updateUserDetailsById($userDetailsParam,$admin_detail_id);

		if(!$return) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Save User Details.' 
			));
			die();
		}

		$userLoginParam = array(
			'username' => $username,
			'role' => $rolesJson,
			'status' => $status
		);

		$resultUpdate = $this->CommonModel->updateUserLoginById($userLoginParam, $admin_detail_id);

		if(!$resultUpdate) {
			echo json_encode(array(
				'code' => 0,
				'msg' => 'Failed to Save User Login Credentials.'
			));
			die();
		} else {
			echo json_encode(array(
				'code' => 1,
				'msg' => 'User Modified Successfully.' 
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

	public function fetchUserById() {

		$id = $this->input->post('id', true);

		$this->load->model('UserDetail');
		$result = $this->UserDetail->fetchUserById($id);

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

	public function deleteUserById() {

		$roles = $this->session->UserRole;
		
		if (!in_array("UserAccess", $roles) && !in_array("SuperAdmin", $roles)) {
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

		$this->load->model('UserDetail');
		$result = $this->UserDetail->deleteUserById($id);

		if($result) {
			echo json_encode(
				array(
					'code' => 1,
					'msg' => 'Deleted User Successfully!'
				)
			);
			die();				
		} else {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Failed to Delete User!'
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

	public function fetchvetter() {

		$id = $this->input->post('id', TRUE);
		$this->load->model('TemplateModel');
		$taskNotesResult = $this->TemplateModel->fetchTemplateById($id);		

		$this->load->model('UserDetail');
		$result = $this->UserDetail->fetchVetter();
		if(empty($result)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'No Records Found'
				)
			);
			die();
		}


		$creator = $this->UserDetail->fetchCreator();
		$creatorArray = array(); 

		foreach($creator as $key => $value) {
			$roles = $value['role'];
			if(!empty($roles)) {
				$rolesArray = json_decode($roles, TRUE);
				if(in_array("ContractAccess", $rolesArray['role'])) {
					$creatorArray[] = array(
						'id' => $value['id'],
						'name' => $value['firstName'] . " " . $value['lastName'],
						'email' => $value['email']
					);
				}
			}
		}

		$AllTaskAccessArray = array(); 

		$ToEmailArray = array(); 
		foreach($creator as $key => $value) {
			$roles = $value['role'];
			if(!empty($roles)) {
				$rolesArray = json_decode($roles, TRUE);
				if(in_array("VetterAccess", $rolesArray['role'])) {
					$ToEmailArray[] = array(
						'id' => $value['id'],
						'name' => $value['firstName'] . " " . $value['lastName'],
						'email' => $value['email']
					);
				}
			}
		}

		$signatoryArray = array(); 
		foreach($creator as $key => $value) {
			$roles = $value['role'];
			if(!empty($roles)) {
				$rolesArray = json_decode($roles, TRUE);
				if(in_array("SigningQueueAccess", $rolesArray['role'])) {
					$signatoryArray[] = array(
						'id' => $value['id'],
						'name' => $value['firstName'] . " " . $value['lastName'],
						'email' => $value['email']
					);
				}
			}
		}

		$ProgramLeadArray = array(); 
		foreach($creator as $key => $value) {
			$roles = $value['role'];
			if(!empty($roles)) {
				$rolesArray = json_decode($roles, TRUE);
				if(in_array("ProgramLeadAccess", $rolesArray['role'])) {
					$ProgramLeadArray[] = array(
						'id' => $value['id'],
						'name' => $value['firstName'] . " " . $value['lastName'],
						'email' => $value['email']
					);
				}
			}
		}				

		$notes = empty($taskNotesResult[0]['taskNotes']) ? "" : $taskNotesResult[0]['taskNotes'];

		try {
			$companyId = empty($taskNotesResult[0]['companyId']) ? "" : $taskNotesResult[0]['companyId'];
			$companyId = json_decode($companyId, TRUE);
			$party2companyId = $companyId[1];
			
			$this->load->model('ClientDetail');
			$companyResult = $this->ClientDetail->fetchClientById($party2companyId);
			$companyEmail = !empty($companyResult[0]['partyEmail']) ? $companyResult[0]['partyEmail'] : "";

		} catch(Exception $e) {
			$companyEmail = "";
		}

		echo json_encode(
			array(
				'code' => 1,
				'toEmail' => $ToEmailArray,
				'creator' => $creatorArray,
				'signatory' => $signatoryArray,
				'allTask' => $AllTaskAccessArray,
				'note' => $notes,
				'companyEmail' => $companyEmail,
				'programLead' => $ProgramLeadArray,
				'createdBy' => $taskNotesResult[0]['userId'],
				'templateCode' => $taskNotesResult[0]['templateCode']
			)
		);
		die();
	}

	public function changeProfilePicture() {

		$userId = $this->session->LoginId;

		if($_FILES['profilePicture']['size'] < 1) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload a File.'
				)
			);
			die();			
		}

		$filename = $_FILES['profilePicture']['name'];
		$filenameArr = explode('.', $filename);
		$ext = end($filenameArr);

		if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Please Upload Docx or Pdf File.'
				)
			);
			die();			
		}

		$filePath = FCPATH . 'assets/profile-picture/';
		$filename = $userId . "-" . date('YmdHis') . "." . $ext;
		if(!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath . $filename)) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'Unable to upload file!'
				)
			);
			die();
		}


		$userDetailsParam = array('profilePicture' => $filename);

		$this->load->model('UserDetail');
		$this->UserDetail->updateProfilePicture($userDetailsParam, $userId);

		echo json_encode(
			array(
				'code' => 1,
				'msg' => "Image Changed Successfully"
			)
		);
		die();		
	}

	public function checkUniqueEmail() {
		$email = $this->input->post('email', TRUE);
		$where = "email = '" . $email . "'";
		$this->load->model('CommonModel');
		if(empty($this->CommonModel->checkUnique($where, 'admin_user'))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function checkUniqueUsername() {
		$username = $this->input->post('username', TRUE);
		$where = "username = '" . $username . "'";
		$this->load->model('CommonModel');
		if(empty($this->CommonModel->checkUnique($where, 'admin_login'))) {
			echo 1;
		} else {
			echo 0;
		}
	}	
}
