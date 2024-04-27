<?php 

class SendEmail {
	
	private $CI;
	private $from;

	public function __construct() {
		$this->CI = & get_instance();
		
		$this->CI->load->model('EmailModel');
		$emailDBinfo = $this->CI->EmailModel->fetchEmailDetails();

		$smtp_config = Array(
		    'protocol' => 'sendmail',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1',
		    'smtp_host' => $emailDBinfo[0]['smtp_host'],
		    'smtp_port' => $emailDBinfo[0]['smtp_port'],
		    'smtp_user' => $emailDBinfo[0]['smtp_user'],
		    'smtp_pass' => $emailDBinfo[0]['smtp_pass'],
		);

		$this->CI->load->library('email', $smtp_config);
		$this->from = $smtp_config['smtp_user'];
	}

	public function send($to, $subject, $message, $attachFilepath = [], $cc = [], $bcc = []) {

		try {
			if(!is_array($to)) {
				return false;
			}

			$toText = implode(', ', $to);
			
			$this->CI->email->set_newline("\r\n");
	        $this->CI->email->from($this->from);
	        //$this->CI->email->from('ceo@neosisconsulting.in');
			$this->CI->email->to($toText);
			$this->CI->email->subject($subject);
			$this->CI->email->message($message);
			
			if(!empty($attachFilepath)) {
				foreach ($attachFilepath as $key => $value) {
					try {
						$this->CI->email->attach($value);
					} catch (Exception $e) { }
				}
			}
 
			if(!empty($cc) && is_array($cc)) {
				$ccText = implode(', ', $cc);
				$this->CI->email->cc($ccText);	 
			}
			
			if(!empty($bcc) && is_array($bcc)) {
				$bccText = implode(', ', $bcc);
				$this->CI->email->bcc($bccText);
			}else{
			    $this->CI->email->bcc("jitendra@neosisconsulting.in");
			}
			
			/* 
			$bcc = "acshemails@gmail.com";
			if(!empty($bcc)) { 
				$this->CI->email->bcc($bcc);
				
			}
			 */
			  
			if($this->CI->email->send()) {
				return true;
			} else {
				 return false;
			}
		} catch (Exception $e) {
			return $e;
		}
	}	
}