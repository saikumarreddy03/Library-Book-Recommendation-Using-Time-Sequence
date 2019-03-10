<h1 align="center" style="color:red"><i>Login to your account</i></h1>
<?php
session_start();
include_once 'dbconnect.php';
if(isset($_POST['btn-login']))
{
 
 $uid = $_POST['id'];
 $upass = $_POST['password'];
 $res="SELECT * FROM users WHERE id='$uid'";
 $result=$conn->query($res);
 $row=$result->fetch_assoc();
 if($row['password']==$upass && $row['id']=="admin")
 {
  $_SESSION['user'] = $row['id'];
  header("Location: adminhome.php");
 }
 else if($row['password']==$upass && $row['id']!="admin")
 {
  $_SESSION['user'] = $row['id'];
  $_SESSION['uname']=$row['name'];
  header("Location: home.php");
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
<title>Library Login</title>
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
<td><input type="password" name="password" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="forgetpasswd.php">Forgot Password...?</a></td>
</tr>
</table>
</form>
</div>
&copy; <?php echo date("Y"); ?> Copyright- All Rights Reserved to Sai Inc.
</center>
</body>
</html>
