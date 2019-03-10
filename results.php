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
<form class="form-horizontal" action="borrow.php" method="POST">
<fieldset>
	<link href="boot.css" rel="stylesheet" type="text/css" media="all">
	<legend align="left">Search Results</legend>
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
$val="";
if($_SERVER['REQUEST_METHOD']=='POST')
{
$val=$_POST['typeahead'];
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$str="SELECT * from  book where title='$val'";
$result=$conn->query($str);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        /*echo $row["FacultyName"].$row["subject"].$row["academicyear"].$row["semister"].$row["branch"].$row["section"].$row["feedbackpercentage"]."<br>";*/
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
?>
</tr>
</table>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <br><button id="submit" name="submit" class="btn btn-primary">Borrow</button>
  </div>
</div>

</fieldset>
</form>
</body>	
