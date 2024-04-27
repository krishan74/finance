<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserDetail extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function fetchAllUserDetails() {
		
		$this->db->select('admin_user.*, admin_login.username, admin_login.role, admin_login.status');

		$this->db->from('admin_user');

		$this->db->join('admin_login', 'admin_user.id = admin_login.admin_detail_id');

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function fetchUserById($id) {
		
		$this->db->select('admin_user.*, admin_login.username, admin_login.role, admin_login.status');

		$this->db->from('admin_user');
		$this->db->where('admin_user.id', $id);

		$this->db->join('admin_login', 'admin_user.id = admin_login.admin_detail_id');

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function deleteUserById($id) {
		$counter = 0;
		$this->db->where('id', $id);
		$this->db->delete('admin_user');

		if($this->db->affected_rows()) {
			$counter++;
		}
		$this->db->flush_cache();

		$this->db->where('admin_detail_id', $id);
		$this->db->delete('admin_login');
		if($this->db->affected_rows()) {
			$counter++;
		}

		if($counter >= 2) {
			return TRUE;	
		} else {
			return FALSE;
		}
		
	}

	public function changePasswordById($id, $password, $oldPassword) {

		$this->db->where('id', $id);
		$this->db->where('password', md5($oldPassword));
		$this->db->select('*');
		$this->db->from('admin_login');
		$query = $this->db->get(); 
		$output = $query->result_array();

		if(empty($output)) {
			return FALSE;
		}

		$this->db->where('id', $id);
		$this->db->where('password', md5($oldPassword));
		$this->db->update('admin_login', array('password' => $password));
		return TRUE;
	}

	public function fetchVetter() {
		
		$this->db->select('admin_user.email, admin_login.id, admin_login.role');

		$this->db->from('admin_user');

		$this->db->join('admin_login', 'admin_user.id = admin_login.admin_detail_id');

		$query = $this->db->get(); 

		return $query->result_array();
				
	}	
	
	public function fetchCreator() {

		$this->db->select('admin_login.id, admin_login.role, admin_user.email, admin_user.firstName, admin_user.lastName');

		$this->db->from('admin_user');

		$this->db->join('admin_login', 'admin_user.id = admin_login.admin_detail_id');

		$query = $this->db->get(); 

		return $query->result_array();

	}

	public function updateProfilePicture($param, $id) {

		$this->db->select('admin_detail_id');
		$this->db->from('admin_login');
		$this->db->where('id', $id);
		$query = $this->db->get(); 
		$resultArr = $query->result_array();		
		$admin_user_id = $resultArr[0]['admin_detail_id'];
		
		$this->db->where('id', $admin_user_id);
		$this->db->update('admin_user', $param);		
		return true;
	}

	public function fetchProfilePic($id) {

		$this->db->select('admin_detail_id');
		$this->db->from('admin_login');
		$this->db->where('id', $id);
		$query = $this->db->get(); 
		$resultArr = $query->result_array();		
		$admin_user_id = $resultArr[0]['admin_detail_id'];
		
		$this->db->select('profilePicture');
		$this->db->where('id', $admin_user_id);
		$this->db->from('admin_user');	
		$query = $this->db->get(); 
		$result = $query->result_array();	
		return $result;

	}
}