<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Changeprofilepicture {

	private $CI;

	public function __construct() {

		$this->CI = & get_instance();

	}

	public function switchImage() {

		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$actual_link = rtrim($actual_link, "/");
		$baseURL = rtrim(base_url(), "/");
		if($actual_link == $baseURL || $actual_link == $baseURL . "login/index") {
			return false;
		}

		if ($this->CI->session->has_userdata('LoginId')) {
			
			$id = $this->CI->session->LoginId;
			$this->CI->load->model('UserDetail');
			$profilePicArray = $this->CI->UserDetail->fetchProfilePic($id);
			if(!empty($profilePicArray[0]['profilePicture'])) {
				
				if(!empty($this->CI->session->profilePic) && ($this->CI->session->profilePic != $profilePicArray[0]['profilePicture'])) {
					
					$this->CI->session->set_userdata('profilePic', $profilePicArray[0]['profilePicture']);	
					session_write_close();				
					redirect('dashboard');

				} else {
					$this->CI->session->set_userdata('profilePic', $profilePicArray[0]['profilePicture']);					
				}

			}

		}

	}
}