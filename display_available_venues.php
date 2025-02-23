<?php
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

// Fetch the selected date
$date = $_POST["date"];

// Fetch available venues for the selected date
$sql_available_venues = "SELECT * FROM venues WHERE venue_name NOT IN 
                         (SELECT venue FROM events WHERE date = '$date')";
$result_available_venues = $conn->query($sql_available_venues);

if ($result_available_venues->num_rows > 0) {
    // Display available venues as a table
    echo "<h2>Available Venues for $date:</h2>";
    echo "<table>";
    echo "<tr><th>Venue</th><th>Capacity</th><th>Action</th></tr>";
    while ($row = $result_available_venues->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["venue_name"] . "</td>";
        echo "<td>" . $row["capacity"] . "</td>"; // Displaying venue capacity
        echo "<td><form action='addeve.php' method='POST'>";
        echo "<input type='hidden' name='date' value='$date'>";
        echo "<input type='hidden' name='venue' value='" . $row["venue_name"] . "'>";
        echo "<button type='submit'>Schedule</button>";
        echo "</form></td>";
        echo "</tr>";
        
    }
    echo "</table>";
} else {
    echo "No available venues for the specified date.";
}

// Close connection
$conn->close();
?>
<style>
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    button {
        padding: 8px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: #45a049;
    }
</style>
