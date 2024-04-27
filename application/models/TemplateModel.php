<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function saveTemplateDraft($param) {
		
		$this->db->insert("template", $param);
		$insertId = $this->db->insert_id();
		
		if($insertId > 0) {
			return $insertId;
		} else {
			return 0;
		}
	}

	public function updateTemplateDraft($param, $oldFileName) {

		$this->db->where('fileName', $oldFileName);
		$this->db->update('template', $param);
		return TRUE;
	}

	public function deleteTemplate($oldFileName) {
		
		$userId = $this->session->LoginId;
		$this->db->where('fileName', $oldFileName);
		$this->db->delete('template');

		return TRUE;		
	}

	public function changeStatus($id) {
		
		$data = array(
		   'status' => 'Agreement Generated',
		); 

		$this->db->where('id', $id);
		$this->db->update('template', $data);

		return TRUE;
	}	


	public function changeStatusToVetter($id) {
		
		$data = array(
		   'status' => 'Sent to Vetter',
		); 

		$this->db->where('id', $id);
		$this->db->update('template', $data);

		return TRUE;
	}	


	public function creatorQueue() {

		$userId = $this->session->LoginId;
		$email = $this->session->email;

		$where = "template.assignedTo = '" . $email . "' and template.queueName ='CreateQueue'";
		
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);

		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function completedQueue() {

		$userId = $this->session->LoginId;
		$email = $this->session->email;

		$where = "template.status = 'Completed' and template.queueName = 'Completed'";
		
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);
        //echo $where;
		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function myDraft() {

		$userId = $this->session->LoginId;
		$email = $this->session->email;

		$where = "template.userId = '" . $userId . "' and template.status = 'Draft'";
		
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);
//echo $where;
		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}



	public function allTask() {
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);

		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function myVetter() {

		$userId = $this->session->LoginId;
		$email = $this->session->email;
		
		$where = "template.queueName = 'VetterQueue' and template.assignedTo = '" . $email . "'";
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);

		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}	

	public function myProgramLead() {
		$userId = $this->session->LoginId;
		$email = $this->session->email;
		$where = "template.assignedTo = '" . $email . "' and template.queueName ='ProgramLeadQueue'";
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);

		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function mySigning() {
		$userId = $this->session->LoginId;
		$email = $this->session->email;
		$where = "template.assignedTo = '" . $email . "' and template.queueName ='SigningQueue'";
		$this->db->select(['template.*', 'au1.firstName as cfirstName', 'au1.lastName as clastName', 'au1.email as cemail', 'au2.firstName as afirstName', 'au2.lastName as alastName', 'au2.email as aemail']);

		$this->db->where($where);
		$this->db->from('template');
		$this->db->join('admin_login', 'admin_login.id = template.userId', 'inner');
		$this->db->join('admin_user as au1', 'admin_login.admin_detail_id = au1.id', 'inner');

		$this->db->join('admin_user as au2', 'template.assignedTo = au2.email', 'left');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function fetchSigningQueue() {
		$userId = $this->session->LoginId;

		$this->db->select('*');
		$this->db->where('status', 'Agreement Generated');
		$this->db->from('template');
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function fetchTemplateById($id) {
		
		$this->db->select('*');
		$this->db->from('template');
		$this->db->where('id', $id);

		$query = $this->db->get(); 

		return $query->result_array();		
	}

	public function fetchNotesById($id) {
		
		$this->db->select('taskNotes');
		$this->db->from('template');
		$this->db->where('id', $id);
		$query = $this->db->get(); 
		return $query->result_array();		
	}

	public function updateTemplateById($data, $id) {

		$this->db->where('id', $id);
		$this->db->update('template', $data);

		return TRUE;
	}

}