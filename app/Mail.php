<?php 

namespace App;
use App\Library\PHPMailer\PHPMailer;
use App\Library\PHPMailer\Exception;
use App\Config;
	
/**
 * Send mail
 */
class Mail {

	/**
	 * Set it to true if it's production server
	 */
	private static $production = Config::PRODUCTION;

	/**
	 * Send an email
	 */
	public static function send($subject, $to, $html_body, $no_html_body = "") {
		if (!self::$production) {
			$mail = new PHPMailer(true);
		 	//Server settings
		    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = Config::SMTP;  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = Config::SMTP_USERNAME;                 // SMTP username
		    $mail->Password = Config::SMTP_PASSWORD;                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = Config::SMTP_PORT;                                    // TCP port to connect to
		    $mail->addAddress($to);

		    //Recipients
		    $mail->setFrom(Config::SET_FROM);
		    $mail->addAddress(Config::SET_FROM);

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $html_body;
		    $mail->AltBody = $no_html_body;

		    $mail->send();
		} else {
			$mail = new PHPMailer();
			$mail->setFrom(Config::SET_FROM);
			$mail->addAddress(Config::SET_FROM);
			$mail->addAddress($to);
			$mail->isHTML(true);

			$mail->Subject = $subject;
			$mail->Body = $html_body;
			$mail->AltBody = $no_html_body;

			$mail->send();
		}
	}

}