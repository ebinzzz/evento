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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $event = $_POST['event'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $amount = $_POST['amount'];
    $paymentType = $_POST['paymentType'];

    // Generate unique ticket ID
    $ticket_id = generateTicketID($conn);

    // Check if email and event_id combination already exists
    $check_sql = "SELECT * FROM participants WHERE email = ? AND event_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $email, $event);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Error: Email and Event combination already registered.');</script>";
    } else {
        // Prepare insert statement
        $insert_sql = "INSERT INTO participants (ticket_id, fullname, event_id, email, mobile, college, branch, amount, payment_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare and bind parameters
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssisssdss", $ticket_id, $fullName, $event, $email, $mobile, $college, $branch, $amount, $paymentType);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Participant registered successfully!');</script>";
            
            // Redirect to dashboard.php
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Error: Unable to register participant.'); window.location.href='addpar.php';</script>";
        }

        // Close statement
        $stmt->close();
    }

    // Close check statement
    $check_stmt->close();
}

// Close the database connection
$conn->close();

function generateTicketID($conn) {
    $unique = false;
    $ticket_id = '';

    // Keep generating a ticket ID until it is unique
    while (!$unique) {
        // Generate a 7-digit random number
        $ticket_id = mt_rand(1000000, 9999999);

        // Check if the ticket ID already exists in the database
        $check_sql = "SELECT * FROM participants WHERE ticket_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $ticket_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        // If no rows are returned, the ticket ID is unique
        if ($result->num_rows == 0) {
            $unique = true;
        }

        // Close check statement
        $check_stmt->close();
    }

    return $ticket_id;
}
?>
