<?php
// Include your database connection file
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

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve the ID from the URL
    $id = $_GET['id'];
    echo "ID: " . $id;
} else {
    echo "ID not provided in the URL.";
}


// Include the PHPMailer library
include_once("class.phpmailer.php");
include_once("class.smtp.php");

// Define your function to send emails
function sendRegistrationEmail($recipientEmail, $name, $eventName, $eventTime, $venue) {
    // Create a PHPMailer instance
    $mail = new PHPMailer;

    // Set the basic parameters
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'ebinbenny777@gmail.com'; // Your Gmail email address
    $mail->Password = 'aazdvzxmzqaafgqu'; // Your Gmail password
    $mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
    $mail->Port = 587; // Port (587 for TLS, 465 for SSL)

    // Set the sender and recipient addresses
    $mail->setFrom('ebinbenny777@gmail.com', 'no-reply-miniproject@cec'); // Sender's email and name
    $mail->addAddress($recipientEmail, $name); // Recipient's email and name

    // Email subject and content
    $mail->Subject = 'Resource Person Invitation'; // Subject of the email
    $mail->isHTML(true); // Set email format to HTML
    $mail->Body = '<p>Hello '.$name.',</p>'.
                  '<p>You have been invited as a resource person for the following event:</p>'.
                  '<p><strong>Event Name:</strong> ' . $eventName . '</p>'.
                  '<p><strong>Event Time:</strong> ' . $eventTime . '</p>'.
                  '<p><strong>Venue:</strong> ' . $venue . '</p>'.
                  '<p>Please let us know if you have any questions or if there are any preparations you need to make. We appreciate your support and look forward to your contributions to the event!</p>'.
                  '<p>This is a computer-generated email; no need to reply.</p>';

    // Send the email
    if ($mail->send()) {
        $msg = "Email sent successfully.";
    } else {
        $msg = "Email sending failed: " . $mail->ErrorInfo;
    }

    return $msg;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resource Persons</title>
  <style>
    /* Your CSS styles */
  </style>
</head>
<body>
  <div class="container">
    <h2>Resource Persons</h2>
  
    <?php
      // Fetch resource persons from the database
      $sql = "SELECT * FROM reso where id='$id'";
      $result = mysqli_query($conn, $sql);

      // Check if there are any results
      if (mysqli_num_rows($result) > 0) {
          // Display table headers and loop through the results
          while ($row = mysqli_fetch_assoc($result)) {
              // Fetch event details for each resource person
              $eventName = $row['eventName'];
              $eventSql = "SELECT * FROM events WHERE event_id = '$eventName'";
              $eventResult = mysqli_query($conn, $eventSql);

              // Check if event details are fetched
              if ($eventResult && mysqli_num_rows($eventResult) > 0) {
                  $eventRow = mysqli_fetch_assoc($eventResult);

                  // Call the function to send email
                  $msg = sendRegistrationEmail($row['email'], $row['name'], $eventRow['event_title'], $eventRow['time'], $eventRow['venue']);
                  //echo $msg . "<br>";
             
    // JavaScript code to display alert
    echo "<script>alert('$msg');</script>";

    // Redirect to showreso.php
    header("Location: showreso.php");
    exit; // Make sure to exit after redirection
              }
          }
      } else {
          echo "No records found.";
      }
    ?>
  </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
