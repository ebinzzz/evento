<?php
// MySQL database connection parameters
$servername = "localhost"; // Change this to your database server hostname
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "events"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of events from the events table



// Retrieve the ID parameter from the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Now you have the ID, you can use it for further processing
    echo "Participant ID: " . $id;
} else {
    echo "Participant ID not found.";
}


$sql2 = "SELECT p_id FROM participants WHERE ticket_id = $id";
$result2 = mysqli_query($conn, $sql2);

if ($result2 && mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
	$p_id= $row2['p_id'];

}
$sql = "SELECT * FROM participants WHERE p_id = $p_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['fullname'];
    $eid = $row['event_id'];
    $col = $row['college'];
    $email = $row['email'];
	$t = $row['ticket_id'];
    $profileImagePath1 = $row['qr_code'];
    $title = '';
}
    $sql1 = "SELECT * FROM events WHERE event_id = '$eid'";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row1 = mysqli_fetch_assoc($result1);
        $event_count = $row1["event_title"];
$date = $row1["date"];
$image= $row1["image"];
$time= $row1["time"];
$time1= $row1["time1"];
$venue= $row1["venue"];


    }



// Echo out the value of $date for debugging
echo "Date from database: $date<br>";

$dateTime = new DateTime($date);
$day1 = $dateTime->format('d'); // Numeric representation of the day (1 for Monday, 2 for Tuesday, etc.)
$day = $dateTime->format('l'); // Returns the full name of the day, e.g. Monday
$month = $dateTime->format('F'); // Returns the full name of the month, e.g. March
$year = $dateTime->format('Y');
echo "Day (Numeric): $day1, Day (Name): $day, Month: $month, Year: $year";


   

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Admit One Ticket (Aug 2021 #CodePenChallenge)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

</head>
<body>
<!-- partial:index.partial.html -->
<link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<div class="ticket">
	<div class="left">
		<div class="image">
			<p class="admit-one">
				<span>ADMIT ONE</span>
				<span>ADMIT ONE</span>
				<span>ADMIT ONE</span>
			</p>
			<div class="ticket-number">
				<p>
				<span><?php echo $t; ?></span>				</p>
			</div>
		</div>
		<div class="ticket-info">
			<p class="date">
				<span><?php echo $day; ?></span>
				<span class="june-29"><?php echo $month; ?>	<?php echo $day1; ?>TH</span>
				<span><?php echo $year; ?></span>
			</p>
			<div class="show-name">
				<h1><?php echo" $event_count"?></h1>
				<h2></h2>
			</div>
			<div class="time">
			<p><?php echo substr($time, 0, 5); ?> PM <span>TO</span> <?php echo substr($time1, 0, 5); ?> PM</p>

				<p>Venue <span>@</span>  <?php echo $venue; ?></p>
			</div>
			<p class="location"><span>East High School</span>
				<span class="separator"><i class="far fa-smile"></i></span><span>College of engineering cherthala</span>
			</p>
		</div>
	</div>
	<div class="right">
		<p class="admit-one">
			<span>ADMIT ONE</span>
			<span>ADMIT ONE</span>
			<span>ADMIT ONE</span>
		</p>
		<div class="right-info-container">
			<div class="show-name">
				<h1>SOUR Prom</h1>
			</div>
			<div class="time">
			<p><?php echo substr($time, 0, 5); ?> PM <span>TO</span> <?php echo substr($time1, 0, 5); ?> PM</p>
				<p>DOORS <span>@</span> <?php echo $venue; ?></p>
			</div>
			<div class="barcode">
			<img src="<?php echo $profileImagePath1; ?>" alt="QR code">
			</div>
			<p class="ticket-number">
			#<?php echo $id; ?>

			</p>
		</div>
	</div>
</div>
<!-- partial -->
  <script  src="script1.js"></script>

</body>
</html>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Staatliches&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap");

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

body,
html {
	height: 100vh;
	display: grid;
	font-family: "Staatliches", cursive;

	color: black;
	font-size: 14px;
	letter-spacing: 0.1em;
}

.ticket {
	margin: auto;
	display: flex;
	background: white;
	box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
}

.left {
	display: flex;
}

.image {
	height: 250px;
	width: 250px;
	background-image: url("./uploads/<?php echo $image; ?>");
	background-size: contain;
	opacity: 0.85;
}

.admit-one {
	position: absolute;
	color: darkgray;
	height: 250px;
	padding: 0 10px;
	letter-spacing: 0.15em;
	display: flex;
	text-align: center;
	justify-content: space-around;
	writing-mode: vertical-rl;
	transform: rotate(-180deg);
}

.admit-one span:nth-child(2) {
	color: white;
	font-weight: 700;
}

.left .ticket-number {
	height: 250px;
	width: 250px;
	display: flex;
	justify-content: flex-end;
	align-items: flex-end;
	padding: 5px;
}

.ticket-info {
	padding: 10px 30px;
	display: flex;
	flex-direction: column;
	text-align: center;
	justify-content: space-between;
	align-items: center;
}

.date {
	border-top: 1px solid gray;
	border-bottom: 1px solid gray;
	padding: 5px 0;
	font-weight: 700;
	display: flex;
	align-items: center;
	justify-content: space-around;
}

.date span {
	width: 100px;
}

.date span:first-child {
	text-align: left;
}

.date span:last-child {
	text-align: right;
}

.date .june-29 {
	color: #d83565;
	font-size: 20px;
}

.show-name {
	font-size: 32px;
	font-family: "Nanum Pen Script", cursive;
	color: #d83565;
}

.show-name h1 {
	font-size: 48px;
	font-weight: 700;
	letter-spacing: 0.1em;
	color: #4a437e;
}

.time {
	padding: 10px 0;
	color: #4a437e;
	text-align: center;
	display: flex;
	flex-direction: column;
	gap: 10px;
	font-weight: 700;
}

.time span {
	font-weight: 400;
	color: gray;
}

.left .time {
	font-size: 16px;
}


.location {
	display: flex;
	justify-content: space-around;
	align-items: center;
	width: 100%;
	padding-top: 8px;
	border-top: 1px solid gray;
}

.location .separator {
	font-size: 20px;
}

.right {
	width: 180px;
	border-left: 1px dashed #404040;
}

.right .admit-one {
	color: darkgray;
}

.right .admit-one span:nth-child(2) {
	color: gray;
}

.right .right-info-container {
	height: 250px;
	padding: 10px 10px 10px 35px;
	display: flex;
	flex-direction: column;
	justify-content: space-around;
	align-items: center;
}

.right .show-name h1 {
	font-size: 18px;
}

.barcode {
	height: 100px;
}

.barcode img {
	height: 100%;
}

.right .ticket-number {
	color: gray;
}
	</style>
