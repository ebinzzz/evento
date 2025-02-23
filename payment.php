<?php
// Set the maximum execution time to 5 seconds
set_time_limit(5);

// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via POST (sanitize if needed)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $amount = $_POST['amount'];
    $event_id = $_POST['event_id'];
    $pay_id = $_POST['pay_id'];

    // Define the venue name
    $query = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the venue
        $row = $result->fetch_assoc();
        $venue = $row['venue'];
        $query = "SELECT * FROM venues where venue_name= '$venue'";
        $result = mysqli_query($conn, $query);

// Display staff options in dropdown
        while ($row1 = mysqli_fetch_assoc($result)) {

        $ca=$row1['capacity'];
        }

        // Select count of registrations for the event_id
        $query = "SELECT COUNT(*) AS registrations FROM participants WHERE event_id = ?";
        $stmt->close(); // Close the previous statement
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the registrations count
            $row = $result->fetch_assoc();
            $registrations = $row['registrations'];

            // Update capacity
            $new_capacity = $ca - $registrations;
            $query_update = "UPDATE events SET capa = ? WHERE event_id = ?";
            $stmt->close(); // Close the previous statement
            $stmt = $conn->prepare($query_update);
            $stmt->bind_param("ii", $new_capacity, $event_id);
            $stmt->execute();

            // Check if the capacity update was successful
            if ($stmt->affected_rows > 0) {
                echo "Capacity updated successfully.";
            } else {
                echo "Failed to update capacity.";
            }
        } else {
            echo "No registrations found for event with ID $event_id.";
        }
    } else {
        echo "Event not found.";
    }

    // Generate a unique 7-digit ticket ID
    $ticket_id = generateTicketID($conn);

    // Insert data into the database
    $query_insert = "INSERT INTO participants (ticket_id, fullname, email, mobile, college, branch, amount, event_id, id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt->close(); // Close the previous statement
    $stmt = $conn->prepare($query_insert);
    $stmt->bind_param("ssssssisi", $ticket_id, $name, $email, $mobile, $college, $branch, $amount, $event_id, $pay_id);

    if ($stmt->execute()) {
        echo "Payment data inserted successfully.";
    } else {
        echo "Error inserting payment data: " . $stmt->error;
    }

    // Close prepared statements
    $stmt->close();
}

// Close the connection
$conn->close();

// Function to generate a unique 7-digit ticket ID
function generateTicketID($conn)
{
    $unique = false;
    $ticket_id = '';

    // Keep generating a ticket ID until it is unique
    while (!$unique) {
        // Generate a 7-digit random number
        $ticket_id = mt_rand(1000000, 9999999);

        // Check if the ticket ID already exists in the database
        $query_check = "SELECT * FROM participants WHERE ticket_id = ?";
        $stmt = $conn->prepare($query_check);
        $stmt->bind_param("s", $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If no rows are returned, the ticket ID is unique
        if ($result->num_rows == 0) {
            $unique = true;
        }
    }

    return $ticket_id;
}
?>
