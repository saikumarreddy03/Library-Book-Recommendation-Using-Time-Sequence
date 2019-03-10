<?php
session_start();
include('dbconnect.php');
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val1=$_POST['studentname'];
$val2=$_POST['id'];
$val3=uniqid();
$val4=$_POST['major'];
$val5=$_POST['email'];
$val6='0';
$val7='1995-08-03';
$t=time();
$str="SELECT * FROM users where id='$val2'";
$result=$conn->query($str);
if($result->num_rows > 0)
{
	echo "<script>";
	echo "window.alert('User ID already exists');";
	echo "window.location.href='enterdetails.php';";
	echo "</script>";
}
$str="SELECT * FROM users where email='$val5'";
$result=$conn->query($str);
if($result->num_rows > 0)
{
	echo "<script>";
	echo "window.alert('Email ID already exists');";
	echo "window.location.href='enterdetails.php';";
	echo "</script>";
}
$str="insert into users values('".$val1."','".$val2."','".$val3."','".$val4."','".$val5."')";
if ($conn->query($str) == TRUE) {
	echo "<script>";
	echo "window.alert('Sucessfully Entered New Record');";
/*PHP mailer*/
include 'mailer.php';
				$mail->addAddress($val5);   // Add a recipient
				/*$mail->addCC('cc@example.com');
				$mail->addBCC('bcc@example.com');
				*/
				$mail->isHTML(true);  // Set email format to HTML

				$bodyContent = '<h1>Hello '.$val1.'</h1>';
				$bodyContent .="We received your request to remember your login credentials. Here it is....<br>
								<table><tr><td> ID </td><td>:</td><td>".$val2."</td></tr>
									<tr><td> Password </td><td>:</td><td>".$val3."</td></tr>
								</table><br>
								<b style='color:red'>Note:</b>Please Change your password once you logged in and more inportantly destroy this message for security reasons.<br>
								Thank You <br>
								noreply@saikumar.com";

				$mail->Subject = "Remembering your credentials";
				$mail->Body    = $bodyContent;

				if(!$mail->send()) 
				{
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
				else
				{
					$myDate = date('Y-m-d');
					$str2="insert into coldstart values('".$val2."','".$val6."','".$myDate."','".$val7."','".$val4."')";
					$conn->query($str2);
					$strl="insert into previousbook values('".$val2."','".$val6."','".$val7."')";
					$conn->query($strl);
				}
	echo "window.location.href='enterdetails.php';";
	echo "</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>
