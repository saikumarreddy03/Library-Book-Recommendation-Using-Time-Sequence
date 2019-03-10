<?php
session_start();
include('dbconnect.php');
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val1=$_POST['title'];
$val2=$_POST['author'];
$val3=$_POST['publisher'];
$val4=$_POST['edition'];
$val5=$_POST['major'];
$val6=$_POST['id'];
$t=time();
$str="SELECT * FROM book where id='$val6'";
$result=$conn->query($str);
if($result->num_rows > 0)
{
	echo "<script>";
	echo "window.alert('A book already exists with same ID');";
	echo "window.location.href='enterdetails.php';";
	echo "</script>";
}
$str="insert into book values('".$val1."','".$val2."','".$val3."','".$val4."','".$val5."','".$val6."')";
if ($conn->query($str) == TRUE) {
	echo "<script>";
	echo "window.alert('Sucessfully Entered New Record');";
	echo "window.location.href='enterdetails.php';";
	echo "</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>

