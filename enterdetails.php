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
	<style>
body {font-family: "Lato", sans-serif;}

ul.tab {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Float the list items side by side */
ul.tab li {float: left;}

/* Style the links inside the list items */
ul.tab li a {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of links on hover */
ul.tab li a:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
ul.tab li a:focus, .active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
<script>
function validateForm() {
    var x = document.forms["book"]["major"].value;
    if (x == "0")
    {
		alert("Option must be selected for major");
        return false;
    }
	var a = document.forms["book"]["title"].value;
	if(!(/^[A-Za-z\s]+$/.test(a)))
	{
		alert("Book title can have only letters and whitespace");
		return false;
	}
	var b = document.forms["book"]["author"].value;
	if(!(/^[A-Za-z\s]+$/.test(b)))
	{
		alert("Author name can have only letters and whitespace");
		return false;
	}
	var c = document.forms["book"]["publisher"].value;
	if(!(/^[A-Za-z0-9\s]+$/.test(c)))
	{
		alert("Publisher name can have only letters, whitespace and numbers");
		return false;
	}
	var d = document.forms["book"]["edition"].value;
	if(!(/^[0-9]{1,3}\.[0-9]{1,2}$/.test(d)))
	{
		alert("Edition must be like e.g. 1.0");
		return false;
	}
	var e = document.forms["book"]["id"].value;
	if(!(/^[A-Za-z0-9]+$/.test(e)))
	{
		alert("Bookid can have only letters and numbers");
		return false;
	}
	
 }
 function validateForma() {
    var y = document.forms["user"]["major"].value;
    if (y == "0")
    {
		alert("Option must be selected for major");
        return false;
    }
	var b = document.forms["user"]["studentname"].value;
	if(!(/^[A-Za-z\s]+$/.test(b)))
	{
		alert("Student name can have only letters and whitespace");
		return false;
	}
	var e = document.forms["user"]["id"].value;
	if(!(/^[A-Za-z0-9]+$/.test(e)))
	{
		alert("Userid can have only letters and numbers");
		return false;
	}
     var x = document.forms["user"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
 }
</script>
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
                
                <h3>Enter details of books/users:</h3>

<ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Book')">Book</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'User')">User</a></li>
</ul>

<div id="Book" class="tabcontent">
  <form class="form-horizontal" method="POST" action="storebook.php" name="book" onsubmit="return validateForm()">
<fieldset>

<!-- Form Name -->
<legend>Enter book details</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="title">Book Title</label>  
  <div class="col-md-4">
  <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="author">Author Name</label>  
  <div class="col-md-4">
  <input id="author" name="author" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="publisher">Publisher Name</label>  
  <div class="col-md-4">
  <input id="publisher" name="publisher" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="edition">Edition</label>  
  <div class="col-md-4">
  <input id="edition" name="edition" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="major">Major</label>
  <div class="col-md-4">
    <select id="major" name="major" class="form-control">
      <option value="0">Select an option</option>
      <option value="IT">IT</option>
      <option value="CSE">CSE</option>
      <option value="CSSE">CSSE</option>
      <option value="EEE">EEE</option>
      <option value="ECE">ECE</option>
      <option value="EIE">EIE</option>
      <option value="CE">CE</option>
      <option value="ME">ME</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="id">Book ID</label>  
  <div class="col-md-4">
  <input id="id" name="id" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>

</div>

<div id="User" class="tabcontent">
<form class="form-horizontal" method="POST" action="storeuser.php" name="user" onsubmit="return validateForma()">
<fieldset>

<!-- Form Name -->
<legend>Enter user details</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="studentname">Student Name</label>  
  <div class="col-md-4">
  <input id="studentname" name="studentname" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="id">ID</label>  
  <div class="col-md-4">
  <input id="id" name="id" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="major">Major</label>
  <div class="col-md-4">
    <select id="major" name="major" class="form-control">
      <option value="0">Select an option</option>
      <option value="IT">IT</option>
      <option value="CSE">CSE</option>
      <option value="CSSE">CSSE</option>
      <option value="EEE">EEE</option>
      <option value="ECE">ECE</option>
      <option value="EIE">EIE</option>
      <option value="CE">CE</option>
      <option value="ME">ME</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email ID</label>  
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>


<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
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
