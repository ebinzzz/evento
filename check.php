<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result-container {
            margin-top: 20px;
        }
        .event-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Event Search</h2>
        <form method="POST" action="check.php"> <!-- Form submission to search.php -->
        <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Search</button>
        </form>
        <div class="result-container">
            <!-- PHP code will be used to display search results here -->
            <?php
            // Database connection parameters
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
                // Retrieve participant ID from the form
                $email = $_POST['email'];

                // Fetch event name and ticket for the given email
                $sql = "SELECT participants.event_id, participants.ticket_id, events.event_title FROM participants JOIN events ON participants.event_id = events.event_id WHERE participants.email = '$email'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='event-container'>";
                        echo "<h3>Event Name: " . $row["event_title"] . "</h3>";
                        echo "<p>Ticket ID: " . $row["ticket_id"] . "</p>";
                        echo "<button>Register</button>";
                        echo "</div>";
                    }
                } else {
                    echo "0 results";
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
