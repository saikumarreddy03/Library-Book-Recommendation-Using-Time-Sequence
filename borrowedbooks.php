<?php
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user']))
{
 header("Location: login.php");
}
$res="SELECT * FROM users WHERE id='".$_SESSION['user']."'";
$result=$conn->query($res);
 $userRow=$result->fetch_assoc();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LBRS</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
  <!--  <link href="assets/css/font-awesome.css" rel="stylesheet" /> -->
        <!-- CUSTOM STYLES-->
   <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    
          
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top"  style="background:#cc0066">
            <div class="adjust-nav">
                <div class="navbar-header">
                   <h1><font color='#ffffff'>Library Book Recommendation System</font></h1>
                </div>
                <div id="content" align="right">
         <font color='#ffffff'>Welcome  <?php echo $userRow['name']; ?>&nbsp;<br><b><a href="logout.php?logout" style="color:#000000">Sign Out</a></b><br>
		 <b><a href="changepasswd.php" style="color:#000000">Change Password</a></font></b>
	 </div>
              </div>
        </div>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					 <li>
                        <a href="home.php">Home</a>
                    </li>
                 	<li class="active-link">
                        <a href="frame.php">Borrow Books</a>
                    </li>
                   <li>
                        <a href="borrowedbooks.php">View/Return Borrowed Books</a>
                    </li>
                     <li>
                        <a href="contactus.php">Contact Us</a>
                    </li>
                         
                     </ul>
                           
                            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" style="min-height:478px">
            <div id="page-inner" style="min-height:478px;">
                <div class="row">
                    <div class="col-md-12">
                     
                    </div>
                </div>
                <form class="form-horizontal" action="return.php" method="POST">
<fieldset>
                <link href="boot.css" rel="stylesheet" type="text/css" media="all">
	<legend align="left">Books You Borrowed</legend>
<body>
<table align="center" border=1>
<tr>
	<th></th>
	<th align="center" width="150px" style="color:red">Book ID</th>
	<th align="center" width="150px" style="color:red">Book Name</th>
	<th align="center" width="150px" style="color:red">Time of borrowing</th>
	<th align="center" width="150px" style="color:red">Returned</th>
</tr>
<tr>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$str="SELECT returned,btime,bookid from borrow where userid='".$_SESSION['user']."'";
$result=$conn->query($str);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$tem=$row["bookid"];
		$strl="SELECT title from book where id='$tem'";
		$resultl=$conn->query($strl);
		$rowl= $resultl->fetch_assoc();
		$bbid=$row["bookid"];
    ?>
    <tr>
	<td>
        <div class="radio">
             <label><input type="radio" name="optradio" value='<?php echo "$bbid";?>' required></label>
        </div>
    </td>
		<td>
    <?php
    echo $row["bookid"];
    ?>
    </td>
    <td>
    <?php
    echo $rowl["title"];
    ?>
    </td>
    <td>
    <?php
    echo $row["btime"];
    ?>
    </td>
    <td>
    <?php
    echo $row["returned"];
    ?>
    </td>
    </tr>
    <?php
    }
} else {
    echo "0 results";
}
?>
</tr>
</table>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4"  align="center">
	<br><button id="submit" name="submit" class="btn btn-primary">Return</button>
  </div>
</div>
</fieldset>
</form>
                
                 <!-- /. ROW  -->           
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
    <div class="footer">
      
    
             <div class="row">
                <div class="col-lg-12" >
                    &copy;  2017 Sai Inc. All Rights Reserved.
                </div>
        </div>
        </div>
          

     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
