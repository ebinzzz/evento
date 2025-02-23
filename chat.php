<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
</head>
<body>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch events data
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<h2>Upcoming Events</h2>";
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row["event_title"] . "</h3>";
        echo "<p><strong>Date:</strong> " . date("F j, Y", strtotime($row["date"])) . "</p>";
        echo "<p><strong>Amount:</strong> $" . $row["event_price"] . "</p>";
        echo "<p><strong>Venue:</strong> " . $row["venue"] . "</p>";
        echo "</div>";
        // You can display more information about the event here based on your database structure
        echo "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

</body>
</html>
