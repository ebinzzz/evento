<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch registered events for the given email
$encodedEmail = $_GET['email'];
$email = urldecode(base64_decode($encodedEmail));
// Fetch registered events and ticket IDs for the given email
$query = "SELECT events.event_id, events.event_title, events.date, events.venue, participants.ticket_id
          FROM events
          INNER JOIN participants ON events.event_id = participants.event_id
          WHERE participants.email = '$email'";

$result = $connection->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Registered Events for <?php echo $email; ?></h2>

<table>
    <tr>
        <th>Event ID</th>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Event Location</th>
        <th>Ticket Link</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ticketLink = "http://localhost/tech/ticket.php?id=" . $row["ticket_id"];
            echo "<tr>";
            echo "<td>" . $row["event_id"] . "</td>";
            echo "<td>" . $row["event_title"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["venue"] . "</td>";
            echo "<td><a href='" . $ticketLink . "' target='_blank'>View Ticket</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No events registered</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close the connection
$connection->close();
?>
