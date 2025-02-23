<?php
// PHP code to display event details
if (isset($_GET['type_id'])) {
    $type_id = $_GET['type_id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "events";

    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch event data based on type_id
    $event_query = "SELECT * FROM events  WHERE type_id = $type_id";
    $event_result = $conn->query($event_query);

    if ($event_result->num_rows > 0) {
        while ($event_data = $event_result->fetch_assoc()) {
            echo "<h2 style='text-align: center; text-transform: uppercase;'>{$event_data['event_title']} Participants</h2>";

            // Fetch participants data for the event
            $event_id = $event_data['event_id'];
            $participants_query = "SELECT * FROM participants WHERE event_id = $event_id";
            $participants_result = $conn->query($participants_query);

            if ($participants_result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>p_id</th>";
                echo "<th>fullname</th>";
                echo "<th>email</th>";
                echo "<th>mobile</th>";
                echo "<th>college</th>";
                echo "<th>branch</th>";
                echo "</tr>";

                while ($row = $participants_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['p_id']}</td>";
                    echo "<td>{$row['fullname']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['mobile']}</td>";
                    echo "<td>{$row['college']}</td>";
                    echo "<td>{$row['branch']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No participants found for this event.</p>";
            }
        }
    } else {
        echo "<p>No event found for the given type_id</p>";
    }

    // Close database connection
    $conn->close();
}
?>

<style>
   table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #007bff;
  color: #fff;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #ddd;
}
</style>
