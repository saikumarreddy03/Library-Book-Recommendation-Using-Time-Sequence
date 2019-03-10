<?php
session_start();
include('dbconnect.php');
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val2=$_POST['uid'];
$val5=$_POST['email'];
$t=time();
$str="select name,password from users where id='$val2' and email='$val5'";
if ($conn->query($str) == TRUE)
 {
	$result=$conn->query($str);
	if ($result->num_rows > 0)
	{
	 $row=$result->fetch_assoc();
	 $val1=$row["name"];
	 $val3=$row["password"];
	echo "<script>";
	echo "window.alert('Login credentials sent to mail');";
/*PHP mailer*/
include 'mailer.php';
				$mail->addAddress($val5);   // Add a recipient
				/*$mail->addCC('cc@example.com');
				$mail->addBCC('bcc@example.com');
				*/
				$mail->isHTML(true);  // Set email format to HTML

				$bodyContent = '<h1>Hello '.$val1.'</h1>';
				$bodyContent .="We received your request to send your forgotten login credentials. Here it is....<br>
								<table><tr><td> ID </td><td>:</td><td>".$val2."</td></tr>
									<tr><td> Password </td><td>:</td><td>".$val3."</td></tr>
								</table><br>
								<b style='color:red'>Note:</b>Please Change your password once you logged in and more inportantly destroy this message for security reasons.<br>
								Thank You <br>
								noreply@saikumar.com";

				$mail->Subject = "Forgot Password";
				$mail->Body    = $bodyContent;

				if(!$mail->send()) 
				{
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
				
	echo "window.location.href='login.php';";
	echo "</script>";
}
else 
{
    echo "<script>";
    echo "window.alert('Invalid credentials');";
    echo "window.location.href='forgetpasswd.php';";
    echo "</script>";
}
} 
}
?>
