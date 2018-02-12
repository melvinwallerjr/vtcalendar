<?php
function emailaddressok($email)
{ // check for valid e-mail address structure
	$validEmailRegex = '/^[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])*' .
	 '@[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])+$/';
	return (!empty($email) && preg_match($validEmailRegex, $email) > 0);
}

if (!function_exists('sendemail')) {
	/**
	 * Sends an e-mail.
	 * @param string toName the display name for the recipient.
	 * @param string toAddress the e-mail address for the recipient.
	 * @param string fromName the display name for the sender.
	 * @param string fromAddress the e-mail address for the sender.
	 * @param string subject the e-mail's subject.
	 * @param string body the e-mail's body.
	 * @return bool|string true if the e-mail was sent/queued successfully,
	 *         false or a string (the error message) if unsuccessful.
	 */
	function sendemail($toName, $toAddress, $fromName, $fromAddress, $subject, $body)
	{
		if (strpos($toAddress, '://') === false && emailaddressok($toAddress)) {
			if (EMAIL_USEPEAR) {
				// Headers for the actual e-mail
				$headers['From'] = $fromName . ' <' . $fromAddress . '>';
				$headers['To'] = $toName . ' <' . $toAddress . '>';
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
				if (Pear::isError($result)) { return $result->getMessage(); }
				// Otherwise return successful.
				return true;
			}
			else {
				$result = @(mail(
					$toName . ' <' . $toAddress . '>',
					trim($subject),
					trim($body),
					'From: ' . $fromName . ' <' . $fromAddress . '>' . "\n" .
					'Content-type: text/plain; charset=utf-8'
				));
				return $result;
			}
		}
		return false;
	}
}
?>