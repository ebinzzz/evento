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
if(isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch event title
    $event_title_query = "SELECT event_title FROM events WHERE event_id = $event_id";
    $event_title_result = $conn->query($event_title_query);
    if ($event_title_result->num_rows > 0) {
        $row = $event_title_result->fetch_assoc();
        $event_title = $row['event_title'];
    }

    // Fetch participants who attended the specified event
    $sql = "SELECT p_id, fullname, email FROM participants WHERE attend = 'present' AND event_id = $event_id AND feed='nodone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $name = $row['fullname'];
            $email = $row['email'];
            $p_id = $row['p_id'];
            // Create a new PHPMailer instance
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
                $mail->addAddress($email, $name);
                $mail->isHTML(true);

                // Email subject and body
                $mail->Subject = 'Feedback Request for ' . $event_title;
                $feedback_form_link = 'http://localhost/tech/feedback_form.php?p_id=' . $p_id . '&event_id=' . $event_id;
                $mail->Body = 'Dear ' . $name . ',<br><br>' . 
                    'Thank you for attending the ' . $event_title . '.<br>' .
                    'We would appreciate it if you could take a moment to provide your feedback.<br><br>' .
                    'Please click on the link below to access the feedback form:<br>' .
                    '<a href="' . $feedback_form_link . '" target="_blank">' . $feedback_form_link . '</a><br><br>' .
                    'Your participation and feedback are valuable to us.<br><br>' .
                    'Best regards,<br>Your Organization';

                // Send email
                $mail->send();

                // Update email status in the database
                // You need to implement this part

                header("Location: startemail.php");
                exit();

            } catch (Exception $e) {
                echo 'Feedback request email could not be sent for ' . $name . ' - ' . $email . '<br>';
                echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
            }
        }
    } else {
        echo "No participants found for the specified event.$event_id";
    }
}

// Close the database connection
$conn->close();
?>
