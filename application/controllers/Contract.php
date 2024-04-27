<?php
class Contract extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ContractModel');
    }

    public function summary() {
        $data['datewise_contracts'] = $this->ContractModel->getDateWiseContracts();
        $this->load->view('includes/header-dashboard', array('title' => 'Dashboard - Contract Summary'));
		$this->load->view('dashboard/contract-summary/contract_summary', $data);
		$this->load->view('includes/footer');
       
    }
}
?>
