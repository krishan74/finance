<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function authenticateLogin($username, $password) {
		
		try {
			$this->db->select('admin_login.*, admin_user.email, admin_user.firstName, admin_user.lastName');
			$this->db->from('admin_login');
			$this->db->join('admin_user', 'admin_user.id = admin_login.admin_detail_id');
			$this->db->where('admin_login.username', $username);
			$this->db->where('admin_login.password', $password);	
			$this->db->where('admin_login.status', 1);		
			$query = $this->db->get();
			return $query->result_array();
		} catch (Exception $e) {
			return array();
		}	
	}
}