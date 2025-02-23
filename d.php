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

$id = 43; // Example participant ID, you should fetch it properly

$sql = "SELECT * FROM participants WHERE p_id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['fullname'];
    $eid = $row['event_id'];
    $t = $row['ticket_id'];
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
    $qrText = "$name\n$id\n$title\n$col\n$t\n$email/";
    $qrImagePath = "qrcodes/$id.png"; // Make sure the 'qrcodes' directory is writable
    QRcode::png($qrText, $qrImagePath, QR_ECLEVEL_L, 10);

    // Save the QR code path to the database
    $updateSql = "UPDATE participants SET qr_code = '$qrImagePath' WHERE p_id = $id";
    mysqli_query($conn, $updateSql);

    // Check if a profile image path is found and not empty
    
        


    // Your PHP code to generate and display QR code goes here
    $profileImagePath1 = "$qrImagePath"; // Example path to the QR code image
    if (!empty($profileImagePath1)) {
        echo '<div class="qr-container">';
        echo '<img src="' . $profileImagePath1 . '" alt="QR Code">';
        echo '</div>';
    } else {
        echo "No QR code available";
    }

} else {
    echo "No participant found with ID $id";
}

?>
<style>
            .qr-container {
                width: 200px; /* Adjust width as needed */
                height: 200px; /* Adjust height as needed */
                margin: 20px; /* Adjust margin as needed */
                border: 1px solid #ccc; /* Optional: Add border for visibility */
                padding: 10px; /* Optional: Add padding for spacing */
                display: inline-block; /* Display as inline block to avoid breaking line */
            }
    
            .qr-container img {
                max-width: 100%; /* Ensure QR code image doesn't exceed container width */
                height: auto; /* Maintain aspect ratio */
                display: block; /* Make sure the image doesn't have extra space below it */
                margin: auto; /* Center the image horizontally */
            }
        </style>