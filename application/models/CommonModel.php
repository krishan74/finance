<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CommonModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function insert($tableName, $param) {

		try {
			if(empty($tableName) || empty($param)) {
				return 0;
			}

			$this->db->insert($tableName, $param);

			if($this->db->affected_rows() > 0) {
				return $this->db->insert_id();	
			} else {
				return 0;	
			}
		} catch (Exception $e) {
			return 0;
		}		
	}

	public function delete($tableName, $id) {
		$this->db->where('id', $id);
		$this->db->delete('$tableName');
		if($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function fetchEmailReceived() {
		try {
			$this->db->select('*');
			$this->db->where('status', 'New');
			$this->db->from('email_received');
			$query = $this->db->get();
			return $query->result_array();
		} catch (Exception $e) {
			return [];
		}
	}

	public function updateUserDetailsById($param, $id) {

		$this->db->where('id', $id);
		$this->db->update('admin_user', $param);		
		return true;
	}

	public function updateUserLoginById($param, $id) {

		$this->db->where('admin_detail_id', $id);
		$this->db->update('admin_login', $param);		
		return true;
	}

	/**
	*@param array of table fields.
	*@return boolean, True if Unique, False if field already exists.
	*
	*/
	public function checkUnique($where, $table) {
		$this->db->select('*');
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();		
		return $query->result_array();
	}		
}