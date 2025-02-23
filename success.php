<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>

</head>
<body>
    <div style="text-align: center; margin-top: 100px;">
        <h1>Payment Successful!</h1>
        <p>Redirecting to homepage...</p>
    </div>
</body>
</html>
<?php
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "events"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'qrlib.php'; // Include the QRcode library

$sql = "SELECT * FROM participants";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['p_id'];
         $t = $row['ticket_id'];
        $name = $row['fullname'];
        $eid = $row['event_id'];
        $col = $row['college'];
        $email = $row['email'];
        $profileImagePath1 = $row['qr_code'];
        $title = '';

        $sql1 = "SELECT * FROM events WHERE event_id = '$eid'";
        $result1 = mysqli_query($conn, $sql1);

        if ($result1 && mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $title = $row1['event_title'];
        }

        // Generate QR code
        $qrText = "$name\n$id\n$title\n$col\n$t\n$email\n/";
        $qrImagePath = "qrcodes/$id.png"; // Make sure the 'qrcodes' directory is writable
        QRcode::png($qrText, $qrImagePath, QR_ECLEVEL_L, 10);

        // Save the QR code path to the database
        $updateSql = "UPDATE participants SET qr_code = '$qrImagePath' WHERE p_id = $id";
        $updateResult = mysqli_query($conn, $updateSql);
        if (!$updateResult) {
            echo "Update Error: " . mysqli_error($conn);
        }
    }
}
include_once("tick.php");

// Check if a profile image path is found and not empty
?>
