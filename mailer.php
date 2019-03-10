<?php
	require 'PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;

				$mail->isSMTP();                            // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                     // Enable SMTP authentication
				$mail->Username = 'mskrproject@gmail.com';          // SMTP username
				$mail->Password = 'MSDhoni@CSK'; // SMTP password
				$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                          // TCP port to connect to

				$mail->setFrom('noreply@saikumarreddy.com', 'ADMIN');
				$mail->addReplyTo('noreply@saikumarreddy.com', 'ADMIN');
				 

?>
