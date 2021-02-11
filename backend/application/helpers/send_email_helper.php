<?php
	function sendEmail($to_email_id,$cc_email_id="",$bcc_email_id="",$subject,$body){
		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the server
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server 25 OR 465 OR 587
		$mail->Username   = "itegovphp@gmail.com";  // GMAIL username 
		$mail->Password   = "egov@2019";   // GMAIL password  
		$mail->SetFrom("itegovphp@gmail.com");//info.davcsp@gmail.com
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);
		
		$emailAddHolder = explode(",",$to_email_id);
		
		if($cc_email_id != "" || $cc_email_id !=null ){
			$ccEmailAddHolder = explode(",",$cc_email_id);
		}else{
			$ccEmailAddHolder = array();
		}
		
		if($bcc_email_id != "" || $bcc_email_id !=null ){
			$bccEmailAddHolder = explode(",",$bcc_email_id);
		}else{
			$bccEmailAddHolder = array();
		}
		//$bccEmailAddHolder = explode(",",$bcc_email_id);
		//echo count($emailAddHolder)."#".count($ccEmailAddHolder)."#".count($bccEmailAddHolder)."#".$subject."#".$body;
		for($index = 0 ; $index < count($emailAddHolder); $index++ ){
			$mail->AddAddress($emailAddHolder[$index]);
		}
		for($index = 0 ; $index < count($ccEmailAddHolder); $index++ ){
			$mail->AddCC($ccEmailAddHolder[$index]);
		}
		for($index = 0 ; $index < count($bccEmailAddHolder); $index++ ){
			$mail->AddBCC($bccEmailAddHolder[$index]);
		}
		if(!$mail->send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
			//return false;
		}else{
			return "Message has been sent successfully";
			//return true;
		}
	}
?>