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
        
        // You can use these variables as needed
      //  echo "Variable 1: " . $var1 . "<br>";
      //  echo "Variable 2: " . $var2 . "<br>";
       // echo "Variable 3: " . $var3 . "<br>";
       // echo "Variable 4: " . $var4 . "<br>";
        //echo "Variable 5: " . $var5 . "<br>";
    } else {
        echo "Insufficient data provided.";
    }

    // Fetch participant ID from the QR code data
    $sql = "SELECT p_id FROM participants WHERE p_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $var2);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $participant_id = $row['p_id'];

        // Update participant's attendance status to 'present'
        $update_sql = "UPDATE participants SET attend= 'present' WHERE p_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $participant_id);
        $update_stmt->execute();

        echo "Attendance marked for participant ID: " . $participant_id;

        // Close the update statement if it exists
        if (isset($update_stmt)) {
            $update_stmt->close();
        }
    } else {
        echo "Participant not found";
    }

    // Close the select statement
    $stmt->close();
}
?>
