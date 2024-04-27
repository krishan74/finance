<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function authenticateLogin($username, $password) {
		
		try {
			$this->db->select('*');
			$this->db->from('smtp_credential');
			$this->db->where('private_key', $username);
			$this->db->where('public_key', $password);	
			$query = $this->db->get();
			return $query->result_array();
		} catch (Exception $e) {
			return array();
		}	
	}

	public function updateEmailCredential($param) {
		try {
			$this->db->where('id', 1);
			$this->db->update('smtp_credential', $param);		
			return true;		
		} catch(Exception $e) {
			return false;		
		}
	}

	public function fetchEmailDetails() {
		
		$this->db->select('*');

		$this->db->from('smtp_credential');

		$this->db->where('id', 1);

		$query = $this->db->get(); 

		return $query->result_array();		
	}	
}