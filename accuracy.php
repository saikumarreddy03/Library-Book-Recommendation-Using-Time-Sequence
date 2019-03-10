<?php
session_start();
include_once 'dbconnect.php';
//echo $_SESSION['user'];
$sai='admin';
if($_SESSION['user'] != $sai)
{
	header("Location: legal.php");
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
                        <a href="adminhome.php">Home</a>
                    </li>
                 	<li class="active-link">
                        <a href="enterdetails.php">Enter Book/User Details</a>
                    </li>
                   <li>
                        <a href="aborrowedbooks.php">View Borrowed Books</a>
                    </li>
                     <li>
                        <a href="accuracy.php">Accuracy</a>
                    </li>
                         
                     </ul>
                           
                            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" style="min-height:468px">
            <div id="page-inner" style="min-height:468px;">
                <div class="row">
                    <div class="col-md-12">
                     
                    </div>
                </div>
                <h1 align="center" style="color:red;"><i>Accuracy of recommendation system</i></h1>
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
$pre='0';
$rec='0';
$n='0'; 
$str="SELECT * from accuracy";
$result=$conn->query($str);
if ($result->num_rows > 0) 
{
	while($row = $result->fetch_assoc()) 
	{
		$b=$row["borrowed"];
		$ar=$row["actrec"];
		$sr=$row["sucrec"];
		$pre=$pre+($sr/$ar);
		$rec=$rec+($sr/$b);
		$n=$n+1;
	}
}
$pre=$pre/$n;
$rec=$rec/$n;
$precision=round($pre,2);
$recall=round($rec,2);
?>
<table align="center" border=1>
	<tr>
		<th align="center" width="150px" style="color:blue;">Precision</th>
		<th align="center" width="150px" style="color:blue;">Recall</th>
	</tr>
	<tr>
        <td>
			<?php
			echo $precision;
			?>
		</td>
		<td>
			<?php
			echo $recall;
			?>
		</td>
	</tr>
</table>
<h2 style="color:blue;">
</h2>
<p align="center">
<?php
echo "NOTE: Precision and Recall are calculated for Top 5 recommendations.";
?>
</p>
                
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
