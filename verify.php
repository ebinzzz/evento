<?php
// Include PHPMailer library
include_once("class.phpmailer.php");
include_once("class.smtp.php");

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

// Check if email exists in the database
$email = $_POST['email'];
$sql_check_email = "SELECT * FROM participants WHERE email='$email'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email && $result_check_email->num_rows > 0) {
    // Generate OTP
    $otp = rand(100000, 999999);

    // Email details
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ebin.cec@gmail.com'; // Your Gmail email address
        $mail->Password = 'rgoclgzigtyjfofx'; // Your Gmail password
        $mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
        $mail->Port = 587; // Port (587 for TLS, 465 for SSL)
    
        // Set the sender and recipient addresses
        $mail->setFrom('ebinbenny777@gmail.com', 'no-reply-miniproject@cec'); // Sender's email and name
        $mail->addAddress($email); // Receiver's email
        $mail->isHTML(true);

        // Email subject and body
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Dear User,<br><br>' . 
            'Your OTP for checking our registered events in evento is:<br>' .
            '<strong>' . $otp . '</strong><br><br>' .
            'Do not share this OTP with anyone.<br>' .
            'This is a computer-generated email. Please do not reply.<br><br>' .
            'Best regards,<br>Your Organization';

        // Send email
        if ($mail->send()) {
            // Update OTP in the database
            $sql_update_otp = "UPDATE participants SET otp_code='$otp' WHERE email='$email'";
            if ($conn->query($sql_update_otp) === TRUE) {
                // Redirect to verify_otp.html with email parameter
                echo "<script>alert('Otp has been sent successfully to email.');</script>";
                echo "<script>window.location.href='verify_otp.php?email=" . $email . "';</script>";
                exit(); // Stop further execution of the script
                
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Email not registered. Error: " . $e->getMessage();
    }
} else {
    echo "<script>alert('Email not found.');</script>";
echo "<script>window.location.href='otp.php';</script>";
exit(); // Stop further execution of the script
}

$conn->close();
?>
