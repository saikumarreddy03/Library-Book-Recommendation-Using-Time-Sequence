<?php
error_reporting(E_ERROR);
session_start();
include_once 'dbconnect.php';
$res="SELECT * FROM book";
$result=$conn->query($res);
 $userRow=$result->fetch_assoc();
?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val=$_POST['optradio'];
}
$myDate = date('Y-m-d');
$buser=$_SESSION['user'];
//$val2=1;
if($val!=NULL)
{
$str="SELECT COUNT(bookid) FROM coldstart where bookid='0' and userid='$buser'";
$result=$conn->query($str);
$row = $result->fetch_assoc();
$z=$row["COUNT(bookid)"];
if($z > 0)	
{
	$strl="UPDATE `coldstart` SET `bookid` = '$val',`bordate` = '$myDate' WHERE `coldstart`.`userid` = '$buser'";
	$conn->query($strl);
}		
	
$str5="SELECT COUNT(bookid) FROM borrow where returned='no' and userid='$buser'";
$result=$conn->query($str5);
$row = $result->fetch_assoc();
$c=$row["COUNT(bookid)"];
if($c <= 1)	
{	
$strl="UPDATE `previousbook` SET `bookid` = '$val',`btime` = '$myDate' WHERE `previousbook`.`userid` = '$buser'";
$conn->query($strl);
$str2="SELECT major from users where id='$buser'";
$result=$conn->query($str2);
$row = $result->fetch_assoc();
$maj=$row["major"];
$str="insert into borrow values('".$buser."','".$myDate."','".$val."','".$maj."','no')";
if ($conn->query($str) == TRUE) {
	$str19="SELECT * FROM accuracy where userid='$buser'";
    $result=$conn->query($str19);
    $result->fetch_assoc();
    if($result->num_rows < 1)
    {
		$str21="INSERT INTO accuracy values('0','0','0','$buser')";
		$conn->query($str21);
	}
	$str20="UPDATE accuracy SET borrowed=borrowed+1,actrec=actrec+5,sucrec=sucrec+1 where userid='$buser'";
    $conn->query($str20);
echo "<script>";
echo "window.alert('Borrowed book $val on $myDate by $buser');";
echo "window.top.location.href='home.php';";
echo "</script>";
}
else
{
	$str6="SELECT returned from borrow where bookid='$val' and userid='$buser'";
	$result=$conn->query($str6);
	$row = $result->fetch_assoc();
	$retsts=$row["returned"];
	if($retsts == 'yes')
	{
	$str3="UPDATE `borrow` SET `btime` = '$myDate',`returned` = 'no' WHERE (`borrow`.`userid` = '$buser'and`borrow`.`bookid` = '$val')";
    $conn->query($str3);
    $str19="SELECT * FROM accuracy where userid='$buser'";
    $result=$conn->query($str19);
    $result->fetch_assoc();
    if($result->num_rows < 1)
    {
		$str21="INSERT INTO accuracy values('0','0','0','$buser')";
		$conn->query($str21);
	}
    $str20="UPDATE accuracy SET borrowed=borrowed+1,actrec=actrec+5,sucrec=sucrec+1 where userid='$buser'";
    $conn->query($str20);
    echo "<script>";
	echo "window.alert('Borrowed book $val on $myDate by $buser');";
	echo "window.top.location.href='home.php';";
	echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "window.alert('Book first be returned and then reacquired');";
		echo "window.top.location.href='home.php';";
		echo "</script>";
	}
}
}
else
{
	echo "<script>";
	echo "window.alert('Maximum of only 2 books are allowed');";
	echo "window.top.location.href='home.php';";
	echo "</script>";
}
}
