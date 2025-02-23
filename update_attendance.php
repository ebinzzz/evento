<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST and the required parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['participant_id']) && isset($_POST['status'])) {
    $participantId = $_POST['participant_id'];
    $newStatus = $_POST['status'];

    // Update the attendance status in the database
    $updateSql = "UPDATE participants SET attend=? WHERE id=?";
    $stmt = $conn->prepare($updateSql);

    // Bind parameters
    $stmt->bind_param("si", $newStatus, $participantId);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Attendance updated successfully";
    } else {
        echo "Error updating attendance: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the case where parameters are not set
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
