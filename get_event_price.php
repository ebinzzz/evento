<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event price based on event ID
$eventId = $_POST['event_id'];
$sql = "SELECT event_price FROM events WHERE event_id = $eventId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['event_price'];
} else {
    echo "0"; // Default value if event price is not found
}

$conn->close();
?>
