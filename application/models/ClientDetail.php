<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ClientDetail extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function fetchAllClientDetails() {
		
		$this->db->select('*');

		$this->db->from('client_detail');

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function fetchClientById($id) {
		
		$this->db->select('*');
		$this->db->from('client_detail');
		$this->db->where('id', $id);
		$query = $this->db->get(); 
		return $query->result_array();		

	}

	public function fetchClientByName($name) {
		
		$this->db->select('*');
		$this->db->from('client_detail');
		$this->db->where('partyName', $name);
		$query = $this->db->get(); 
		return $query->result_array();		

	}

	public function deleteClientById($id) {
		
		$this->db->where('id', $id);
		$this->db->delete('client_detail');
		return TRUE;
		
	}

	public function modify($param, $id) {
		$this->db->where('id', $id);
		$this->db->update('client_detail', $param);		
		return true;
	}

	public function fetchClientNameId() {
		$this->db->select(['partyAlias', 'partyName', 'id']);
		$this->db->from('client_detail');
		$this->db->order_by('partyName', 'ASC');
		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function fetchClientByArr($arr) {

		$this->db->select('*');
		$this->db->from('client_detail');
		$this->db->where_in('id', $arr);
		$query = $this->db->get(); 
		return $query->result_array();		
	}	
}