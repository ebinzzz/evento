<?php

include_once("class.phpmailer.php");
include_once("class.smtp.php");


// MySQL database connection parameters
$servername = "localhost"; // Change this to your database server hostname
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "events"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch participants with email status as 'unsend'
$sql = "SELECT * FROM participants WHERE email_status = 'unsend'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $name = $row['fullname'];
        $eid = $row['event_id'];
        $col = $row['college'];
        $amount = $row['amount'];
        $email = $row['email'];  
        $ticket = $row['ticket_id']; // Assuming you have a column named 'ticket_id' in your participants table
        $sql1 = "SELECT * FROM events WHERE event_id = '$eid'";
        $result1 = mysqli_query($conn, $sql1);
    
        if ($result1 && mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $event_count = $row1["event_title"];
    $date = $row1["date"];
    $image= $row1["image"];
    $time= $row1["time"];
    $time1= $row1["time1"];
    $venue= $row1["venue"];
    
    
        }
    

        // Send email to the participant with the ticket image attached
        $mail = new PHPMailer;

        // Set the basic parameters
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ebin.cec@gmail.com'; // Your Gmail email address
        $mail->Password = 'rgoclgzigtyjfofx'; // Your Gmail password
        $mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
        $mail->Port = 587; // Port (587 for TLS, 465 for SSL)
    
        // Set the sender and recipient addresses
        $mail->setFrom('ebin.cec@gmail.com', 'no-reply-miniproject@cec'); // Sender's email and name
        $mail->addAddress($email, $name);
        $mail->addAttachment($ticket, 'Ticket.png'); // Attach the generated ticket image
        $mail->isHTML(true);

        $mail->Subject = 'Your Event Ticket';
        // Define the URL to ticket.php with the ID parameter
        $ticketURL = 'http://localhost/tech/ticket.php?id=' . $ticket;

        // Concatenate the HTML content of the ticket and the button with the link
        $mail->Body = 'Dear ' . $name . ',<br><br>' . 
        'You are successfully registered for the event: ' . $event_count . '.<br>' .
        'Your payment of Rs' . $amount . ' is successful.<br><br>' .
        'Please find your event ticket attached below:<br><br>' .
        '<a href="' . $ticketURL . '" target="_blank">' .
        '<button style="background-color: #4CAF50; color: white; padding: 15px 32px; ' .
        'text-align: center; text-decoration: none; display: inline-block; font-size: 16px; ' .
        'margin: 4px 2px; cursor: pointer; border-radius: 10px;">View Ticket</button></a>';
    
        $mail->AltBody = 'Please find your event ticket attached below.';

        if(!$mail->send()) {
            echo 'Message could not be sent for ' . $name . ' - ' . $email . '<br>';
            echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
        } else {
            // Update email status to 'sent' in the database
            $updateSql = "UPDATE participants SET email_status = 'sent' WHERE p_id = " . $row['p_id'];
            if ($conn->query($updateSql) === TRUE) {
                echo 'Message has been sent to ' . $name . ' - ' . $email . '<br>';
            } else {
                echo 'Error updating email status for ' . $name . ' - ' . $email . '<br>';
            }
        }
    }
} else {
    echo "No participants with email status 'unsend' found.";
}

// Close the database connection
$conn->close();
?>
