<?php 

class EmailParser {

	public function init($filename) {
		
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