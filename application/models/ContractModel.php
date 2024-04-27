<?php
class ContractModel extends CI_Model {

    public function __construct() {
        parent::__construct();
     	$this->load->database();
    }

    // Fetch contracts organized by date
    public function getDateWiseContracts() {
        $this->db->select('currentDate, templateCode, fileName, templateName,');
        $this->db->from('template');
        $this->db->order_by('currentDate', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
?>
