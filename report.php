<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reports</title>
    <style>
    body {
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 20px;
    }
    .event-report {
        margin-bottom: 40px;
    }
    .event-report h2 {
        margin: 0;
        font-size: 20px;
        font-weight: bold;
    }
    .event-report p {
        margin: 10px 0;
        text-indent: 30px;
    }
</style>


</head>
<body>
<?php
// Connect to database

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

// Fetch event data from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Generate report for each event as a big paragraph
while ($row = $result->fetch_assoc()) {
    echo "<div class='event-report'>";

    // Print event title in bold
    echo "<h2>{$row['event_title']}</h2>";

    // Print event description from the database
    echo "<p>{$row['pre']}</p>";

    // Add additional information about the event
    $event_details = "The event was organized on {$row['date']} at {$row['venue']}. ";
    $event_details .= "It brought together a diverse audience of attendees from various backgrounds. ";
    $event_details .= "The main focus of the event was to emphasize innovation and collaboration. ";
    $event_details .= "Throughout the day, participants engaged in interactive sessions, workshops, and discussions led by industry experts. ";
    $event_details .= "Key topics included emerging technologies, industry trends, and best practices.";

    // Print event details
    echo "<p>{$event_details}</p>";

    echo "</div>";
}


// Close database connection
$conn->close();
?>
</body>
</html>
