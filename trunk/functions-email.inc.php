<?php
// code adapted from php.net, "mail" help page, author: tstrum@salter.com
function emailaddressok($email) {
	if (eregi("^[_\.0-9a-z-]+@([0-9a-z][-0-9a-z\.]+)\.([a-z]{2,3}$)", $email, $check)) {
/*	
	if (getmxrr($check[1].".".$check[2],$temp)) { // doesn't work on Windows
			return 1; // "Valid - ".$check[1].".".$check[2]
		}
		return 0; // No MX for $check[1].".".$check[2]
*/
		return 1;
	}
	else {
		return 0; // Badly formed address
	}
} // end: function emailaddressok

// sends an email
function sendemail($toName, $toAddress, $fromName, $fromAddress, $subject, $body) {
	if (emailaddressok($toAddress)) {
		if (EMAIL_USEPEAR) {		
			// Headers for the actual e-mail
			$headers['From'] = $fromName . ' <'.$fromAddress.'>';
			$headers['To'] = $toName . ' <'.$toAddress.'>';
			$headers['Subject'] = $subject;
			
			// SMTP settings
			$settings['host'] = EMAIL_SMTP_HOST;
			$settings['port'] = EMAIL_SMTP_PORT;
			$settings['auth'] = EMAIL_SMTP_AUTH;
			if (EMAIL_SMTP_AUTH) {
				$settings['username'] = EMAIL_SMTP_USERNAME;
				$settings['password'] = EMAIL_SMTP_PASSWORD;
			}
			$settings['localhost'] = EMAIL_SMTP_HELO;
			$settings['timeout'] = EMAIL_SMTP_TIMEOUT;
			
			// Create the mailer instance.
			$mailer =& Mail::factory('smtp', $settings);
			
			// Send the e-mail
			$result = $mailer->send($toAddress, $headers, $body);
			
			// Return an error string if an error occurred.
			if (Pear::isError($result)) {
				return $result->getMessage();
			}
			
			// Otherwise return successful.
			else {
				return true;
			}
		}
		else {
			return mail($toName." <".$toAddress.">", 
				trim($subject), 
				trim($body), 
				"From: ".$fromName." <".$fromAddress.">\nContent-type: text/plain; charset=us-ascii");
		}
	}
	else {
		return false;
	}
} // end: Function sendemail
?>