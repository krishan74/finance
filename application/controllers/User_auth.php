<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_auth extends CI_Controller {

	public function index($param = '') {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
			$this->load->view('includes/header', array('title' => 'Email Settings'));
			$this->load->view('login/email_setting', ['pValue' => $param]);
			$this->load->view('includes/footer');
        } else {
        	if($this->session->pValue !== 1) { 
				redirect($_SERVER['HTTP_REFERER']);
			}

        	$username = md5($this->input->post('username'));
        	$password = md5($this->input->post('password'));
            $this->load->model('EmailModel');
            $result = $this->EmailModel->authenticateLogin($username, $password);    
          //  echo $username.' - '.$password; 
			// echo "<br>";
		    // print_r($result);die();
			
            if(!empty($result)) {
				$this->session->set_userdata('userManager', 1);

				session_write_close();

				redirect('user_auth/dashboard');
            } else {
            	redirect();
            }
        }
	}

	public function dashboard() {

		if($this->session->userManager !== 1 || $this->session->pValue !== 1) {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		$this->load->model('EmailModel');
        $result = $this->EmailModel->fetchEmailDetails();

        $data['emailDetails'] = $result[0];

		$this->load->helper('form');

		$this->load->view('includes/header-dashboard', array('title' => 'Email Settings'));
		
		$this->load->view('dashboard/hr/specific-header1', $data);

		$this->load->view('includes/footer');		
	}

	public function emailSignout() {
		@$this->session->unset_userdata('userManager');
		@$this->session->unset_userdata('pValue');
		
		session_write_close();
		redirect();
	}

	public function save() {

		if($this->session->userManager !== 1) {
			redirect();
		}

		$smtp_host = $this->input->post('smtp_host', TRUE);
		$smtp_user = $this->input->post('smtp_user', TRUE);
		$smtp_pass = $this->input->post('smtp_password', TRUE);
		$smtp_port = $this->input->post('smtp_port', TRUE);

		$param = array(
			'smtp_host' => $smtp_host,
			'smtp_user' => $smtp_user,
			'smtp_pass' => $smtp_pass,
			'smtp_port' => $smtp_port
		);

		$this->load->model('EmailModel');
        $result = $this->EmailModel->updateEmailCredential($param); 

        if($result == TRUE) {
        	$this->session->set_userdata('saveEmailMessage', 'Email Settings Saved.');
			session_write_close();
			redirect($_SERVER['HTTP_REFERER']);
        } else {
			$this->session->set_userdata('saveEmailMessage', 'Fail to Save Email Settings.');
			session_write_close();
			redirect($_SERVER['HTTP_REFERER']);
        }  
	}	
}
