<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Start Sending Emails</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    h2 {
        text-align: center;
        color: #333;
    }
    .event-container {
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between; /* Align items horizontally */
        width: 50%;
    }
    .event-name {
        color: #333;
        font-size: large;
    }
    .event-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;  
    }
    .event-button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <h2>Feedbacklink Sender</h2>
    
    <!-- PHP code to dynamically generate containers for each event with its associated button -->
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
    
    // Fetch events
    $sql = "SELECT event_id, event_title FROM events";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="event-container">';
            echo '<div class="event-name">' . $row["event_title"] . '</div>';
            echo '<form action="send_emails.php" method="post">';
            echo '<input type="hidden" name="event_id" value="' . $row["event_id"] . '">';
            echo '<button class="event-button"><a href="resultfeed.php?event_id=' . $row["event_id"] . '">Track Feedback</a></button>'; // Added button
            echo '<input class="event-button" type="submit" name="start" value="Start Sending">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "No events found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
