<?php
error_reporting(E_ERROR);
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user']))
{
 header("Location: login.php");
}
$res="SELECT * FROM book";
$result=$conn->query($res);
 $userRow=$result->fetch_assoc();
?>
<form class="form-horizontal" action="rborrow.php" method="POST">
<fieldset>
	<link href="boot.css" rel="stylesheet" type="text/css" media="all">
	<legend align="left">Recommendations</legend>
<body>
<table align="center" border=1>
<tr>
	<th></th>
	<th align="center" width="150px">Title</th>
	<th align="center" width="150px">Author</th>
	<th align="center" width="150px">Publisher</th>
	<th align="center" width="150px">Edition</th>
	<th align="center" width="150px">Major</th>
	<th align="center" width="150px">ID</th>
</tr>
<tr>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main";
$val=$_SESSION['user'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$str="TRUNCATE table recommend";
$result=$conn->query($str); 
$str="SELECT bookid from  previousbook where userid='$val'";
$result=$conn->query($str);
$row = $result->fetch_assoc();
$pb=$row["bookid"];
$str1="SELECT major from users where id='$val'";
$result=$conn->query($str1);
$row = $result->fetch_assoc();
$maj=$row["major"];

//cold start variable
$cldst='0';

$str2="SELECT DISTINCT userid FROM borrow where ((bookid='$pb' and major='$maj') and userid!='$val') ";
$result=$conn->query($str2);
while($row = $result->fetch_assoc())
{
	 $users[] = $row['userid'];
	 $tuser = $row['userid'];
	 $str4="SELECT btime FROM borrow where (bookid='$pb' and userid='$tuser')";
	 $resultl=$conn->query($str4);
	 $rowl = $resultl->fetch_assoc();
	 $ttime=$rowl["btime"];
	 $str3="SELECT DISTINCT bookid FROM borrow where (bookid not IN (SELECT bookid from borrow where userid='$val' and returned='no')) and (userid = '$tuser' and btime > '$ttime');";
	 $resultm=$conn->query($str3);
	 if($resultm->num_rows > 0)
	{
		$cldst='1';
	}
	 while($rowm = $resultm->fetch_assoc())
	 {
		 //$tbook = $rowm['bookid'];
		 //echo "<h2>$tbook</h2>";
		 $books[] = $rowm['bookid'];
	 }
}
//var_dump($users);
//var_dump($books);
//print_r(array_count_values($books));
$number = array_count_values($books);
//var_dump($number);
//$a='b1';
//echo "<h2>$number[$a]</h2>";
$ubooks=array_unique($books);
//var_dump($ubooks);
foreach ($ubooks as $value)
{
	$time=0;
	$a=$value;
	$n=$number[$a];
	foreach ($users as $uvalue)
	{
		$str5="SELECT btime from borrow where userid='$uvalue' and bookid='$pb'";
		$result=$conn->query($str5);
		$row = $result->fetch_assoc();
		$x=$row["btime"];
		$str5="SELECT btime from borrow where userid='$uvalue' and bookid='$value'";
		$result=$conn->query($str5);
		$row = $result->fetch_assoc();
		$y=$row["btime"];
		//echo "<h2>$y</h2>";
		$str6="SELECT DATEDIFF('$y','$x') AS DDATE";
		$result=$conn->query($str6);
		$row = $result->fetch_assoc();
		$z=$row["DDATE"];
		//echo "<h2>$z</h2>";
		if($z > 0)
		{
			$time = $time + ($z);
		}
	}
	$time = $time/$n;
	//echo "<h2>$time</h2>";
	$str7="INSERT INTO recommend VALUES('$value',$time,0,$n,0,0)";
	$result=$conn->query($str7);
}
$str8="SELECT MAX(t) FROM recommend";
$result=$conn->query($str8);
$row = $result->fetch_assoc();
$tmax=$row["MAX(t)"];
$str9="SELECT MIN(t) FROM recommend";
$result=$conn->query($str9);
$row = $result->fetch_assoc();
$tmin=$row["MIN(t)"];
$str8="SELECT MAX(n) FROM recommend";
$result=$conn->query($str8);
$row = $result->fetch_assoc();
$nmax=$row["MAX(n)"];
$str9="SELECT MIN(n) FROM recommend";
$result=$conn->query($str9);
$row = $result->fetch_assoc();
$nmin=$row["MIN(n)"];
//echo "<h2>$tmin,$tmax</h2>";
foreach ($ubooks as $value)
{
	$str10="SELECT t from recommend where bookid='$value'";
	$result=$conn->query($str10);
	$row = $result->fetch_assoc();
	$ct=$row["t"];
	$st=100*($ct-$tmin)/($tmax-$tmin);
	$str11="SELECT n from recommend where bookid='$value'";
	$result=$conn->query($str11);
	$row = $result->fetch_assoc();
	$cn=$row["n"];
	$sn=100*($cn-$nmin)/($nmax-$nmin);
	$str12="UPDATE recommend SET st='$st',sn='$sn' where bookid='$value'";
	$result=$conn->query($str12);
}
foreach ($ubooks as $value)
{
	$str13="SELECT st,sn from recommend where bookid='$value'";
	$result=$conn->query($str13);
	$row = $result->fetch_assoc();
	$dt=$row["st"];
	$dn=$row["sn"];
	$str13="SELECT MAX(sn) FROM recommend";
	$result=$conn->query($str13);
	$row = $result->fetch_assoc();
	$dmn=$row["MAX(sn)"];
	$dif=$dmn-$dn;
	$dis=sqrt(pow($dt,2)+pow($dif,2));
	$str14="UPDATE recommend SET distance='$dis' where bookid='$value'";
	$result=$conn->query($str14);
}

$str15="SELECT bookid from recommend ORDER BY distance LIMIT 5";
$resultx=$conn->query($str15);
if ($resultx->num_rows > 0) {
    // output data of each row
    while($rowx = $resultx->fetch_assoc()) {
    $rbid=$rowx["bookid"];
  
 
$str="SELECT * from  book where id='$rbid'";
$result=$conn->query($str);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $bid=$row["id"];
    ?>
    <tr>
	<td>
        <div class="radio">
             <label><input type="radio" name="optradio" value='<?php echo "$bid";?>' required></label>
        </div>
    </td>
	<td>
    <?php
    echo $row["title"];
    ?>
    </td>
    <td>
    <?php
    echo $row["author"];
    ?>
    </td>
    <td>
    <?php
    echo $row["publisher"];
    ?>
    </td>
    <td>
    <?php
    echo $row["edition"];
    ?>
    </td>
    <td>
    <?php
    echo $row["major"];
    ?>
    </td>
    <td>
    <?php
    echo $row["id"];
    ?>
    </td>
    </tr>
    <?php
    }
}
}
}
?>

<?php
if($cldst=='0'&&$pb!='0')
{
	$str15="SELECT DISTINCT bookid from borrow where major='$maj' and bookid NOT IN (SELECT bookid FROM borrow WHERE userid='$val' and returned='no') LIMIT 5";
	$resultx=$conn->query($str15);
	if ($resultx->num_rows > 0) {
    // output data of each row
		while($rowx = $resultx->fetch_assoc()) {
		$rbid=$rowx["bookid"];
  
 
	$str="SELECT * from  book where id='$rbid'";
	$result=$conn->query($str);
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
		$bid=$row["id"];
		?>
		<tr>
		<td>
        <div class="radio">
             <label><input type="radio" name="optradio" value='<?php echo "$bid";?>' required></label>
        </div>
		</td>
		<td>
		<?php
		echo $row["title"];
		?>
		</td>
		<td>
		<?php
		echo $row["author"];
		?>
		</td>
		<td>
		<?php
		echo $row["publisher"];
		?>
		</td>
		<td>
		<?php
		echo $row["edition"];
		?>
		</td>
		<td>
		<?php
		echo $row["major"];
		?>
		</td>
		<td>
		<?php
		echo $row["id"];
		?>
		</td>
		</tr>
		<?php
	}
}
}
}
}
?>
<?php
if($pb=='0')
{
	$str15="SELECT DISTINCT bookid FROM coldstart WHERE userid!='$val'and major='$maj' and bookid!='0' ORDER BY DATEDIFF(coldstart.bordate,coldstart.regdate) LIMIT 5";
	$resultx=$conn->query($str15);
	if ($resultx->num_rows > 0) {
    // output data of each row
		while($rowx = $resultx->fetch_assoc()) {
		$rbid=$rowx["bookid"];
  
 
	$str="SELECT * from  book where id='$rbid'";
	$result=$conn->query($str);
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
		$bid=$row["id"];
		?>
		<tr>
		<td>
        <div class="radio">
             <label><input type="radio" name="optradio" value='<?php echo "$bid";?>' required></label>
        </div>
		</td>
		<td>
		<?php
		echo $row["title"];
		?>
		</td>
		<td>
		<?php
		echo $row["author"];
		?>
		</td>
		<td>
		<?php
		echo $row["publisher"];
		?>
		</td>
		<td>
		<?php
		echo $row["edition"];
		?>
		</td>
		<td>
		<?php
		echo $row["major"];
		?>
		</td>
		<td>
		<?php
		echo $row["id"];
		?>
		</td>
		</tr>
		<?php
	}
}
}
}
}
?>

</tr>
</table>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Borrow</button>
  </div>
</div>
</fieldset>
</form>
</body>	
