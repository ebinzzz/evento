<?php
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


// Fetch participants who attended the workshop
$sql = "SELECT p_id, name, email FROM participants WHERE attend = 'present' AND email_status = 'unsend'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $email = $row['email'];
        $p_id = $row['p_id'];

        // Create a new PHPMailer instance
        include_once("class.phpmailer.php");
include_once("class.smtp.php");
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ebinbenny777@gmail.com'; // Your Gmail email address
            $mail->Password = 'aazdvzxmzqaafgqu'; // Your Gmail password
            $mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
            $mail->Port = 587; // Port (587 for TLS, 465 for SSL)
        
            // Set the sender and recipient addresses
            $mail->setFrom('ebinbenny777@gmail.com', 'no-reply-miniproject@cec'); // Sender's email and name
            $mail->addAddress($email, $name);
            $mail->isHTML(true);

            // Email subject and body
            $mail->Subject = 'Feedback Request for Web Development Workshop';
            $feedback_form_link = 'http://localhost/tech/feedback_form.php?p_id=' . $p_id;
            $mail->Body = 'Dear ' . $name . ',<br><br>' . 
                'Thank you for attending the Web Development Workshop.<br>' .
                'We would appreciate it if you could take a moment to provide your feedback.<br><br>' .
                'Please click on the link below to access the feedback form:<br>' .
                '<a href="' . $feedback_form_link . '" target="_blank">' . $feedback_form_link . '</a><br><br>' .
                'Your participation and feedback are valuable to us.<br><br>' .
                'Best regards,<br>Your Organization';

            // Send email
            $mail->send();

            // Update email status in the database
            $updateSql = "UPDATE participants SET email_status = 'sent' WHERE p_id = " . $p_id;
            if ($conn->query($updateSql) === TRUE) {
                echo 'Feedback request email has been sent to ' . $name . ' - ' . $email . '<br>';
            } else {
                echo 'Error updating email status for ' . $name . ' - ' . $email . '<br>';
            }
        } catch (Exception $e) {
            echo 'Feedback request email could not be sent for ' . $name . ' - ' . $email . '<br>';
            echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
        }
    }
} else {
    echo "Absent Error";
}

// Close the database connection
$conn->close();
?>
