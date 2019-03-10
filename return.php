<?php
error_reporting(E_ERROR);
session_start();
include_once 'dbconnect.php';
$res="SELECT * FROM borrow where userid='".$_SESSION['user']."'";
$result=$conn->query($res);
if($result->num_rows < 1)
{
	echo "<script>";
	//echo "window.alert('Redirecting to home');";
	echo "window.location.href='home.php';";
	echo "</script>";
}
 $userRow=$result->fetch_assoc();
?>
<?php
$val = '0';
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val=$_POST['optradio'];
}
$val1='yes';
$val2=$_SESSION['user'];
$str="SELECT returned from borrow where bookid='$val' and userid='$val2'";
$result=$conn->query($str);
$row= $result->fetch_assoc();
$ret=$row["returned"];
if($ret != $val1)
{
	$str="UPDATE borrow SET returned='$val1' where bookid='$val' and userid='$val2'";
	$result=$conn->query($str);
	if($val != '0')
	{
	echo "<script>";
	echo "window.alert('Returned book $val by $val2');";
	echo "window.location.href='borrowedbooks.php';";
	echo "</script>";
	}
}
else
{
	echo "<script>";
	echo "window.alert('Book already returned');";
	echo "window.location.href='borrowedbooks.php';";
	echo "</script>";
}
?>
