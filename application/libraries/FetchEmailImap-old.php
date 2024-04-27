<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FetchEmailImap {

	private $CI;
	private $imap_server;
	private $imap_username;
	private $imap_password;
	private $imap_attachment_dir;
	private $imap_port;
	private $imap_string_url;

	public function __construct() {
		$this->CI = & get_instance();
		
		$this->CI->config->load('config-imap', TRUE); 
		$imap_config = $this->CI->config->item('config-imap');

		$this->imap_server = $imap_config['imap_server'];
		$this->imap_username = $imap_config['imap_username'];
		$this->imap_password = $imap_config['imap_password'];
		$this->imap_attachment_dir = $imap_config['imap_attachment_dir'];
		$this->imap_port = $imap_config['imap_port'];
		$this->imap_string_url = $imap_config['imap_string_url'];

	}

	public function fetchEmail() {
		$this->CI->load->model('CommonModel');
		date_default_timezone_set('Asia/Kolkata');
		$mbox = imap_open("{" . $this->imap_server . ":" . $this->imap_port . $this->imap_string_url . "}INBOX", $this->imap_username, $this->imap_password) or die("can't connect to email server: " . imap_last_error());
		try {
			$emails = imap_search($mbox,'ALL');
		} catch(Exception $e) {
			$emails = array();
		}

		if(empty($emails)) {
			die();
		}

		foreach ($emails as $key => $val) {

			$filename = date("YmdHis") . rand();
		    
		    $headerInfo = imap_headerinfo($mbox, $val);

		    //Fetching Email Details.
			$subject = $headerInfo->Subject;
			$fromEmail = $headerInfo->from[0]->mailbox . "@" . $headerInfo->from[0]->host;
			$toEmail = $headerInfo->toaddress;
			$unixTimeStamp = $headerInfo->udate;
			$status = 'New';		    
			
			//Fetching Email Header Section		    
		    $headers = imap_fetchheader($mbox, $val, FT_PREFETCHTEXT);

		    //Fetching Email Body and Attachment.
		    $body = imap_body($mbox, $val);

		    try {
			    if(!file_put_contents( $this->imap_attachment_dir . "/" . $filename . '.eml', $headers . "\n" . $body )) {
			    	$attachmentStatus = 0;
			    } else {
			    	$attachmentStatus = 1;
			    }
			} catch (Exception $e) {
				$attachmentStatus = 0;
			}


			$text = "";
			//Fetching Message Body.
			$structure = imap_fetchstructure($mbox, $val);
			if($structure->subtype == 'MIXED') {
				$text = strip_tags(quoted_printable_decode(imap_fetchbody($mbox, $val, 1.1)));   
			} else {
				$text = strip_tags(quoted_printable_decode(imap_fetchbody($mbox, $val, 2))); 
			}

		    //Inserting Data
		    $emailReceivedParam = array(
				'fromEmail' => $fromEmail,
				'toEmail' => $toEmail,
				'subject' => $subject,
				'messageBody' => $text,
				'unixTimeStamp' => $unixTimeStamp,
				'attachment' => $filename . '.eml',
				'attachmentStatus'  => $attachmentStatus,
				'status' => $status								
			);

			$this->CI->CommonModel->insert('email_received', $emailReceivedParam);
		}

		imap_close($mbox);

	}	

}