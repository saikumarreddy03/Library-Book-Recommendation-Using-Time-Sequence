<h1 align="center" style="color:red"><i>Forgot Password...?</i></h1>
<?php
session_start();
include_once 'dbconnect.php';
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
<form method="POST" id="forpass" action="mailpass.php">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="text" name="uid" placeholder="User ID" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Confirm Details</button></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>
