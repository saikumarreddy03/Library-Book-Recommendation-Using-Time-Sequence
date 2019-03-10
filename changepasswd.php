<h1 align="center" style="color:red"><i>Change Password</i></h1>
<?php
session_start();
include_once 'dbconnect.php';
if(isset($_POST['btn-login']))
{
 $id = $_POST['id'];
 $opass = $_POST['oldpass'];
 $npass = $_POST['newpass'];
 $cpass = $_POST['confirmpass'];
 $res="SELECT * FROM users WHERE id='$id'";
 $result=$conn->query($res);
 $row=$result->fetch_assoc();
 if($row['password']==$opass && $npass==$cpass)
 {
	$passlen=strlen($npass);
	if($passlen > 7)
	{
  $str="UPDATE users SET password='".$_POST['newpass']."' WHERE id='".$_POST['id']."'";
	$result=$conn->query($str);
	?>
	<script>alert('Password Changed Successfully');</script>
	<?php
	header("Location: home.php");
	}
	else
	{
		?>
        <script>alert('Password must be atleast 8 characters');</script>
        <?php
	}
 }
 else
 {
  ?>
        <script>alert('wrong details');</script>
        <?php
 }
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Library Book Recommendation System</title>
<link rel="stylesheet" href="Style.css" type="text/css" />
</head>
<body bgcolor="#55AAFF">
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="id" placeholder="Your ID" required /></td>
</tr>
<tr>
<td><input type="password" name="oldpass" placeholder="Old Password" required /></td>
</tr>
<tr>
<td><input type="password" name="newpass" placeholder="New Password" required /></td>
</tr>
<tr>
<td><input type="password" name="confirmpass" placeholder="Confirm Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Save Password</button></td>
</tr>
</table>
</form>
</div>
&copy; <?php echo date("Y"); ?> Copyright- All Rights Reserved to Sai Inc.
</center>
</body>
</html>
