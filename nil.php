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
    $p_id = $row2['p_id'];
}

$sql = "SELECT * FROM participants WHERE p_id = $p_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['fullname'];
    $eid = $row['event_id'];
    $col = $row['college'];
    $email = $row['email'];
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

// HTML content for the ticket
$html_content = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admit One Ticket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>';

// Ticket layout
$html_content .= '
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
            #20030220
        </p>
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
        <h2>Olivia Rodrigo</h2>
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
        #20030220
    </p>
</div>
</div>
</div>';

$html_content .= '</body>
</html>';

// Convert HTML to image using Imagick
$imagick = new Imagick();
$imagick->readHTML($html_content);

// Set image format and quality
$imagick->setImageFormat('png');
$imagick->setImageCompressionQuality(100);

// Set the filename for download
$filename = 'ticket.png';

// Output the image
header('Content-Type: image/png');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . $filename . "\"");

echo $imagick->getImageBlob(); // Output the image blob

// Clear Imagick resources
$imagick->clear();
$imagick->destroy();

// Close MySQL connection
$conn->close();
?>
