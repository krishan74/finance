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
		$insertId = '';
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
			    	$fetchEmailDetailsResult = $this->fetchEmailDetails($filename . '.eml');
			    }
			} catch (Exception $e) {
				$attachmentStatus = 0;
			}

				$fromEmail = (!empty($fetchEmailDetailsResult['from'])) ? $fetchEmailDetailsResult['from'] : '';
				$toEmail = (!empty($fetchEmailDetailsResult['to'])) ? $fetchEmailDetailsResult['to'] : '';
				$name = (!empty($fetchEmailDetailsResult['name'])) ? $fetchEmailDetailsResult['name'] : '';
				$subject = (!empty($fetchEmailDetailsResult['subject'])) ? $fetchEmailDetailsResult['subject'] : '';
				$messageBody = (!empty($fetchEmailDetailsResult['mailBody'])) ? $fetchEmailDetailsResult['mailBody'] : '';
				$indivisualAttachments = (!empty($fetchEmailDetailsResult['attachments'])) ? $fetchEmailDetailsResult['attachments'] : array();

				$finalAttachmentArray[$val] = array();
				if(!empty($indivisualAttachments)) {
					foreach ($indivisualAttachments as $attachKey => $attachValue) {
						$tempArr = array();		
						$tempArr = explode("\\", $attachValue);
						$finalAttachmentArray[$val][] = !empty(end($tempArr)) ? end($tempArr) : '';
					}
				}

		    //Inserting Data
		    $emailReceivedParam = array(
		    	'fromEmail' => $fromEmail,
				'toEmail' => $toEmail,
				'name' => $name,
				'subject' => $subject,
				'messageBody' => $messageBody,
				'unixTimeStamp' => $unixTimeStamp,
				'attachment' => $filename . '.eml',
				'attachmentStatus'  => $attachmentStatus,
				'indivisualAttachment' => json_encode($finalAttachmentArray[$val]),
				'status' => $status								
			);

			$this->CI->CommonModel->insert('email_received', $emailReceivedParam);
		}

		imap_close($mbox);

	}	

	private function fetchEmailDetails($filename) {
		
		require_once( FCPATH . 'vendor/autoload.php' );
		
		$path = FCPATH . 'assets/email-attachments/'. $filename;
		$attachmentPath = FCPATH . 'assets/final-attachment';
		$parser = new PhpMimeMailParser\Parser();
		$parser->setPath($path);

		$arrayHeaderTo = $parser->getAddresses('to');
		$toEmail = $arrayHeaderTo[0]['address']; // Fetched To Email.

		$fromData = $parser->getHeader('from');		
		$nameIndex = strpos($fromData, "<" );

		$name = trim(substr($fromData, 0, $nameIndex)); //Fetched Name

		$fromEmail = trim(substr($fromData, $nameIndex + 1));
		$fromEmail = trim(str_replace(">", "", $fromEmail)); //Fetched From Email

		$mailBody = $parser->getMessageBody('html'); // Fetched Message Body

		$attachments = $parser->saveAttachments($attachmentPath, false, PhpMimeMailParser\Parser::ATTACHMENT_DUPLICATE_SUFFIX);

		$subject = $parser->getHeader('subject');

		return [
			'from' => $fromEmail, 
			'to' => $toEmail, 
			'name' => $name,
			'subject' => $subject,
			'mailBody' => $mailBody,
			'attachments' => $attachments
		];
	}
}