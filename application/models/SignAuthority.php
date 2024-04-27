<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SignAuthority extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function fetchAllSign() {
		
		$this->db->select('*');

		$this->db->from('signing_authority');
		$this->db->order_by('authorityName', 'ASC');

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function fetchSigningById($id) {
		
		$this->db->select('*');

		$this->db->from('signing_authority');
		$this->db->where('id', $id);

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function deleteSigningById($id) {
		
		$this->db->where('id', $id);
		$this->db->delete('signing_authority');
		return TRUE;
		
	}

	public function modify($param, $id) {
		$this->db->where('id', $id);
		$this->db->update('signing_authority', $param);		
		return true;
	}

	public function fetchSignByJson($json) {
		$inStatement = "";
		foreach ($json as $key => $value) {
			$inStatement .= $value . ", ";
		}
		$inStatement = rtrim($inStatement, ", ");

		$where = "id IN (" . $inStatement . ")";
		$this->db->select('*');
		$this->db->from('signing_authority');
		$this->db->where($where);
		$this->db->order_by('authorityName', 'ASC');
		$query = $this->db->get(); 
		return $query->result_array();
	}	
}