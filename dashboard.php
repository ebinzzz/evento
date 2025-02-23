<?php
// Start a session
session_start();

// Check if the admin name is set in the session
if (isset($_SESSION["username"])) {
    $admin_name = $_SESSION["username"];
    // Display the admin's name
   
} else {
    // If the admin name is not set, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}
?>
<?php
// MySQL database connection parameters
$servername = "localhost"; // Change this to your database server hostname
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password`
$database = "events"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of events from the events table
$sql = "SELECT COUNT(*) AS event_count FROM events";

$result = $conn->query($sql);

if ($result === FALSE) {
    // Query failed
    echo "Error: " . $conn->error;
} else {
    // Check if there are rows returned
    if ($result->num_rows > 0) {
        // Fetch the result row
        $row = $result->fetch_assoc();
        $event_count = $row["event_count"];

        // Display the count of events
        echo "Total events: " . $event_count;
    } else {
        // No rows returned
        echo "No events found.";
    }
}
$sql1 = "SELECT COUNT(*) AS event1_count FROM participants";

$result1 = $conn->query($sql1);

if ($result1 === FALSE) {
    // Query failed
    echo "Error: " . $conn->error;
} else {
    // Check if there are rows returned
    if ($result1->num_rows > 0) {
        // Fetch the result row
        $row1 = $result1->fetch_assoc();
        $event1_count = $row1["event1_count"];

        // Display the count of events
        echo "Total events: " . $event1_count;
    } else {
        // No rows returned
        echo "No events found.";
    }
}
$sql2 = "SELECT COUNT(*) AS event2_count FROM reso";

$result2 = $conn->query($sql2);

if ($result2 === FALSE) {
    // Query failed
    echo "Error: " . $conn->error;
} else {
    // Check if there are rows returned
    if ($result2->num_rows > 0) {
        // Fetch the result row
        $row2 = $result2->fetch_assoc();
        $event2_count = $row2["event2_count"];

        // Display the count of events
        echo "Total events: " . $event2_count;
    } else {
        // No rows returned
        echo "No events found.";
    }
}
$sql3 = "SELECT COUNT(*) AS event3_count FROM spons";

$result3 = $conn->query($sql3);

if ($result3 === FALSE) {
    // Query failed
    echo "Error: " . $conn->error;
} else {
    // Check if there are rows returned
    if ($result3->num_rows > 0) {
        // Fetch the result row
        $row3 = $result3->fetch_assoc();
        $event3_count = $row3["event3_count"];

        // Display the count of events
        echo "Total events: " . $event3_count;
    } else {
        // No rows returned
        echo "No events found.";
    }
}

// Close connection

?>

<!Doctype HTML>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-kr1Z5aShyPTjjgPv6LBkpcItnhNbAVo5TwRhETlBWXFth5vFIuItnOIrGbpPSaS6iy7Ulw0W/qNpFZ97moRZ3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	</head>


	<body>
		
		<div id="mySidenav" class="sidenav">
		<p class="logo"><span>EVENTO</span>-2K24</p>
	  <a href="#" class="icon-a"><i class="fa fa-dashboard icons"></i>   Dashboard</a>
	  <a href="./verify.html"class="icon-a"><i class="fa fa-users icons"></i>   Verify Ticket</a>
	  <a href="addpar.php"class="icon-a"><i class="fa fa-list icons"></i>  Add Participants</a>
	  <a href="ebin.html"class="icon-a"><i class="fa fa-shopping-bag icons"></i> Add Event</a>
	  <a href="shedule.php"class="icon-a"><i class="fa fa-tasks icons"></i>   Event Schedule</a>
	  <a href="addvenue.php"class="icon-a"><i class="fa fa-tasks icons"></i>   Manage Venue</a>
	  <a href="attend.php"class="icon-a"><i class="fa fa-user icons"></i>   Attendance</a>
	  <a href="coord.html"class="icon-a"><i class="fa fa-user icons"></i>   Add Coordinator</a>
	  <a href="addreso.php"class="icon-a"><i class="fa fa-list-alt icons"></i>   Add Resource person</a>
	  <a href="../main.php"class="icon-a"><i class="fa fa-tasks icons"></i>   Reports</a>
		<a href="../startemail.php"class="icon-a"><i class="fa fa-list-alt icons"></i>   feedback Manager</a>
	  <a href="logout.php"class="icon-a"><i class="fas fa-list-alt"></i>   Logout</a>


	</div>
	<div id="main">

		<div class="head">
			<div class="col-div-6">
	<span style="font-size:30px;cursor:pointer; color: white;" class="nav"  >☰ Dashboard</span>
	<span style="font-size:30px;cursor:pointer; color: white;" class="nav2"  >☰ Dashboard</span>
	</div>
		
		<div class="col-div-6">
		<div class="profile">

			<img src="images/user.png" class="pro-img" />
			<p><?php  echo "$admin_name!";?><span>UI / UX DESIGNER</span></p>
		</div>
	</div>
		<div class="clearfix"></div>
	</div>

		<div class="clearfix"></div>
		<br/>
		
		<div class="col-div-3">
			<div class="box1">
				<p><?php  echo "$event_count ";?><br/><span>Events</span></p>
				<p>

				<i class="fa fa-address-card-o" style="font-size:36px" width="400%" ></i>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box1">
				<p><?php  echo "$event1_count ";?><br/><span>Participants</span></p>
				<a href="particpants.php"> <i class="fa fa-users" style="font-size:36px"></i></a>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box1">
				<p><?php  echo "$event2_count ";?><br/><span>Resource Person</span></p>
				<a href="showreso.php">	<i class="fa fa-street-view" style="font-size:45px"></i></a>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box1">
				<p><?php  echo "$event3_count ";?><br/><span>Sponsers</span></p>
				<i class="fa fa-bank" style="font-size:36px"></i>
			</div>
		</div>
		<div class="clearfix"></div>
		<br/><br/>
		<div class="col-div-8">
			<div class="box-8">
			<div class="content-box">
				<p>Upcoming Events <span>Sell All</span></p>
				<br/>
				<table>
				<tr>
    <th>Event Title</th>
    <th>Date</th>
    <th>Venue</th>
  </tr>

  <?php
    // Establish a connection to your database
   
    // Construct the SQL query
	$sql3 = "SELECT event_title, date, venue FROM events WHERE date >= CURRENT_DATE ORDER BY date LIMIT 5";

    // Execute the query
    $result3 = $conn->query($sql3);

    // Check if any rows were returned
    if ($result3->num_rows> 0) {
        // Output data of each row
        while($row3 = $result3->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row3['event_title'] . "</td>";
            echo "<td>" . $row3['date'] . "</td>";
            echo "<td>" . $row3['venue'] . "</td>";
            echo "</tr>";
        }
    }
	$conn->close();
  ?>
	  
	  
	</table>
			</div>
		</div>
		</div>

		<div class="col-div-4">
			<div class="box-4">
			<div class="content-box">
				<p>Total Sale <span>Sell All</span></p>

				<div class="circle-wrap">
	    <div class="circle">
	      <div class="mask full">
	        <div class="fill"></div>
	      </div>
	      <div class="mask half">
	        <div class="fill"></div>
	      </div>
	      <div class="inside-circle"><?php  echo "$event1_count ";?>% </div>
	    </div>
	  </div>
			</div>
		</div>
		</div>
			
		<div class="clearfix"></div>
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>

	  $(".nav").click(function(){
	    $("#mySidenav").css('width','70px');
	    $("#main").css('margin-left','70px');
	    $(".logo").css('visibility', 'hidden');
	    $(".logo span").css('visibility', 'visible');
	     $(".logo span").css('margin-left', '-10px');
	     $(".icon-a").css('visibility', 'hidden');
	     $(".icons").css('visibility', 'visible');
	     $(".icons").css('margin-left', '-8px');
	      $(".nav").css('display','none');
	      $(".nav2").css('display','block');
	  });

	$(".nav2").click(function(){
	    $("#mySidenav").css('width','300px');
	    $("#main").css('margin-left','300px');
	    $(".logo").css('visibility', 'visible');
	     $(".icon-a").css('visibility', 'visible');
	     $(".icons").css('visibility', 'visible');
	     $(".nav").css('display','block');
	      $(".nav2").css('display','none');
	 });

	</script>

	</body>


	</html>
    <style>
    body{
	margin:0px;
	padding: 0px;
	background-color:#1b203d;
	overflow: hidden;
	font-family: system-ui;
}
.clearfix{
	clear: both;
}
.logo{
	margin: 0px;
	margin-left: 28px;
    font-weight: bold;
    color: white;
    margin-bottom: 30px;
}
.logo span{
	color: #f7403b;
}
.sidenav {
  height: 100%;
  width: 300px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #272c4a;
  overflow: hidden;
  transition: 0.5s;
  padding-top: 30px;
}
.sidenav a {
  padding: 15px 8px 15px 32px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  transition: 0.3s;
}
.sidenav a:hover {
  color: #f1f1f1;
  background-color:#1b203d;
}
.sidenav{
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
}
#main {
  transition: margin-left .5s;
  padding: 16px;
  margin-left: 300px;
}
.head{
	padding:20px;
}
.col-div-6{
	width: 50%;
	float: left;
}
.profile{
	display: inline-block;
	float: right;
	width: 160px;
}
.pro-img{
	float: left;
	width: 40px;
	margin-top: 5px;
}
.profile p{
	color: white;
	font-weight: 500;
	margin-left: 55px;
	margin-top: 10px;
	font-size: 20px;
}
.profile p span{
	font-weight: 400;
    font-size: 12px;
    display: block;
    color: #8e8b8b;
}
.col-div-3{
	width: 25%;
	float: left;
}
.box{
	width: 85%;
	height: 100px;
	background-color: #272c4a;
	margin-left: 10px;
	padding:10px;
}
.box p{
	 font-size: 35px;
    color: white;
    font-weight: bold;
    line-height: 30px;
    padding-left: 10px;
    margin-top: 20px;
    display: inline-block;
}
.box p span{
	font-size: 20px;
	font-weight: 400;
	color: #818181;
}
.box-icon{
	font-size: 40px!important;
    float: right;
    margin-top: 35px!important;
    color: #818181;
    padding-right: 10px;
}
.col-div-8{
	width: 70%;
	float: left;
}
.col-div-4{
	width: 30%;
	float: left;
}
.content-box{
	padding: 20px;
}
.content-box p{
	margin: 0px;
    font-size: 20px;
    color: #f7403b;
}
.content-box p span{
	float: right;
    background-color: #ddd;
    padding: 3px 10px;
    font-size: 15px;
}
.box-8, .box-4{
	width: 95%;
	background-color: #272c4a;
	height: 330px;
	
}
.nav2{
	display: none;
}

.box-8{
	margin-left: 10px;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  
}
td, th {
  text-align: left;
  padding:15px;
  color: #ddd;
  border-bottom: 1px solid #81818140;
}
.circle-wrap {
  margin: 50px auto;
  width: 150px;
  height: 150px;
  background: #e6e2e7;
  border-radius: 50%;
}
.circle-wrap .circle .mask,
.circle-wrap .circle .fill {
  width: 150px;
  height: 150px;
  position: absolute;
  border-radius: 50%;
}
.circle-wrap .circle .mask {
  clip: rect(0px, 150px, 150px, 75px);
}

.circle-wrap .circle .mask .fill {
  clip: rect(0px, 75px, 150px, 0px);
  background-color: #f7403b;
}
.circle-wrap .circle .mask.full,
.circle-wrap .circle .fill {
  animation: fill ease-in-out 3s;
  transform: rotate(126deg);
}

@keyframes fill {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(126deg);
  }
}
.circle-wrap .inside-circle {
  width: 130px;
  height: 130px;
  border-radius: 50%;
  background: #fff;
  line-height: 130px;
  text-align: center;
  margin-top: 10px;
  margin-left: 10px;
  position: absolute;
  z-index: 100;
  font-weight: 700;
  font-size: 2em;
}
.box1 {
    position: relative; /* Ensure the container is positioned relative */
}

.box1 .fa {
    position: absolute;	
    right: 10%; /* Adjust this value as needed */
	top: 50px; 
	
}
.box1{
	width: 85%;
	height: 100px;
	background-color: #272c4a;
	margin-left: 10px;
	padding:10px;
}
.box1 p{
	 font-size: 35px;
    color: white;
    font-weight: bold;
    line-height: 30px;
    padding-left: 10px;
    margin-top: 20px;
    display: inline-block;
}
.box1 p span{
	font-size: 20px;
	font-weight: 400;
	color: #818181;
}
.box1-icon{
	font-size: 40px!important;
    float: right;
    margin-top: 35px!important;
    color: #818181;
    padding-right: 10px;
}

</style>