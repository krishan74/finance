<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {

		$this->load->helper(array('form'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'User Name', 'required|max_length[20]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
			$this->load->view('includes/header', array('title' => 'Admin Login'));
			$this->load->view('login/specific-header');
			$this->load->view('includes/footer');
        } else {
        	$username = $this->input->post('username');
        	$password = md5($this->input->post('password'));
            $this->load->model('LoginModel');
            $result = $this->LoginModel->authenticateLogin($username, $password);    

            if(empty($result)) {
				$this->session->set_userdata('authentication_error', 'Authentication Failed');
				redirect();
            } else {
				$this->session->set_userdata('LoginId', $result[0]['id']);
				$this->session->set_userdata('UserName', $result[0]['username']);
				$this->session->set_userdata('email', $result[0]['email']);
				$this->session->set_userdata('name', $result[0]['firstName'] . ' ' . $result[0]['lastName']);
				$role = json_decode($result[0]['role']);
				$this->session->set_userdata('UserRole', $role->role);
				
				//Setting Up Profile Picture...
				$this->load->model('UserDetail');
				$profilePicArray = $this->UserDetail->fetchProfilePic($result[0]['id']);
				if(!empty($profilePicArray[0]['profilePicture'])) {
					$this->session->set_userdata('profilePic', $profilePicArray[0]['profilePicture']);
				}

				session_write_close();

				redirect('dashboard');
            }
        }
	}

	public function signout() {
		@$this->session->unset_userdata('LoginId');
		@$this->session->unset_userdata('UserName');
		@$this->session->unset_userdata('UserRole');
		@$this->session->unset_userdata('profilePic');
		session_write_close();
		redirect();
	}	
}
