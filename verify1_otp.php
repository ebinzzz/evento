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

// Get email and OTP from POST data
$email = $_POST['email'];
$entered_otp = $_POST['otp'];

// Prepare SQL statement to prevent SQL injection
$sql_check_otp = "SELECT * FROM participants WHERE email=? AND otp_code=?";
$stmt = $conn->prepare($sql_check_otp);

// Bind parameters
$stmt->bind_param("ss", $email, $entered_otp);

// Execute query
$stmt->execute();

// Get result
$result_check_otp = $stmt->get_result();

if ($result_check_otp && $result_check_otp->num_rows > 0) {
    // OTP is valid
    echo "<script>alert('OTP verification Successfull.');</script>";
    $encodedEmail = urlencode(base64_encode($email));
echo "<script>window.location.href='getevent.php?email=" . $encodedEmail . "';</script>";

} else {
    // OTP is invalid

    echo "<script>alert('Invalid OTP.');</script>";
    echo "<script>window.location.href='otp.php';</script>";
    exit(); // Stop further execution of the script
    

    // Debugging: Print entered OTP and OTP from database
   
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
