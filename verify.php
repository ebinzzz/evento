<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the scanned QR code data
if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Explode the QR code data into an array of lines
    $lines = explode("\n", $code);

    // Assign data to five different variables
    if (count($lines) >= 5) {
        list($var1, $var2, $var3, $var4, $var5) = $lines;
        
        // Fetch participant ID from the QR code data
        $sql = "SELECT p_id, fullname, verify FROM participants WHERE ticket_id = ? AND verify != 'yes'"; // added verify condition
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $var5);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $participant_id = $row['p_id'];
            $name = $row['fullname'];

            // Update participant's attendance status to 'present'
            $update_sql = "UPDATE participants SET verify = 'yes' WHERE p_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $participant_id);
            $update_stmt->execute();

            echo "Ticket verification successful: " . $var5;
            echo ": " . $name;

            // Close the update statement if it exists
            if (isset($update_stmt)) {
                $update_stmt->close();
            }
        } else {
        
            echo " already verified:" . $var5;
        }

        // Close the select statement
        $stmt->close();
    } else {
        echo "Insufficient data provided.";
    }
}
?>
