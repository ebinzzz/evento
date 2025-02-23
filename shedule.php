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

// Fetch event data from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Delete event if requested
if(isset($_GET['delete_event'])) {
    $delete_id = $_GET['delete_event'];
    $sql_delete = "DELETE FROM events WHERE event_id = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Event deleted successfully');</script>";
    } else {
        echo "Error deleting event: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title class="btn">Event Schedule</title>
    <style>
        
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        @media print {
            /* Hide the last column during printing */
            .no-print {
                display: none;
            }
        }
     
    :root {
        --background-color: #f4f4f4;
        --text-color: #333;
        --table-border-color: #dddddd;
        --table-header-background-color: #f2f2f2;
        --table-row-background-color: #f9f9f9;
        --table-row-hover-color: #f2f2f2;
    }

    /* Dark Mode */
    body.dark-mode {
        --background-color: #333;
        --text-color: #f4f4f4;
        --table-border-color: #888;
        --table-header-background-color: #444;
        --table-row-background-color: #555;
        --table-row-hover-color: #444;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        margin: 0;
        padding: 0;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Table Styles */
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        color: var(--text-color);
    }

    th, td {
        border: 1px solid var(--table-border-color);
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: var(--table-header-background-color);
        color: var(--text-color);
        text-transform: uppercase;
    }
    
    .title .btn {
    background-color: var(--table-header-background-color);
    color: var(--text-color);
    text-transform: uppercase;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.title .btn:hover {
    background-color: darken(var(--table-header-background-color), 10%);
    color: lighten(var(--text-color), 10%);
}


    tr:nth-child(even) {
        background-color: var(--table-row-background-color);
    }
    tr:nth-child(odd) {
        background-color: var(--table-row-background-color);
    }

    tr:hover {
        background-color: var(--table-row-hover-color);
    }

    /* Rest of your CSS styles */


        .action-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-danger{
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        :root {
        --background-color: #f4f4f4;
        --text-color: #333;
    }

    /* Dark Mode */
    body.dark-mode {
        --background-color: #333;
        --text-color: #f4f4f4;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        margin: 0;
        padding: 0;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    h3 {
            text-align: center;
        }
        .back-btn{
      margin:20px;
    }


    </style>
</head>
<body>
    <h2>Event Schedule</h2>
    <a href="dashboard.php">
      <!-- You can use a button or an arrow -->
      <button class="no=print"class="back-btn">Back to Dashboard</button>
      <!-- Or you can use an arrow symbol -->
      <!-- <span>&#8592; Back to Dashboard</span> -->
    </a>
    <button class="no-print" onclick="printPage()">Print</button>

    <button class="no-print" onclick="toggleDarkMode()">Toggle Dark Mode</button>
    <button  class="no-print" onclick="location.href='ebin.html'" class="btn">New Event</button>


    <?php

// Fetch unique event dates from the database
$sql_dates = "SELECT DISTINCT date FROM events";
$result_dates = $conn->query($sql_dates);

?>


    <?php
    // Loop through each unique date
    while ($row_date = $result_dates->fetch_assoc()) {
        $event_date = $row_date['date'];

        // Fetch event data for the current date from the database
        $sql_events = "SELECT * FROM events WHERE date = '$event_date'";
        $result_events = $conn->query($sql_events);

        if ($result_events->num_rows > 0) {
            // Display the date as a section header
            echo "<h3>Date: $event_date</h3>";
            // Start a new table for events of this date
            echo "<table>";
            echo "<tr>
                    <th>Event No.</th>
                    <th>Event Title</th>
                    <th>Event Price</th>
                    <th>Type ID</th>
                    <th>Staff</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>From Time</th>
                    <th>To Time</th>
                    <th>Venue</th>
                    <th class='no-print'>Actions</th> 
                </tr>";

            // Output data of each row for this date
            while ($row_event = $result_events->fetch_assoc()) {
                // Fetch type_title from event_type table based on type_id
                $type_id = $row_event["type_id"];
                $sql_type = "SELECT type_title FROM event_type WHERE type_id = $type_id";
                $result_type = $conn->query($sql_type);
                $type_title = ($result_type->num_rows > 0) ? $result_type->fetch_assoc()['type_title'] : '';

                // Display event details
                echo "<tr>";
                echo "<td>".$row_event["event_id"]."</td>";
                echo "<td>".$row_event["event_title"]."</td>";
                echo "<td>".$row_event["event_price"]."</td>";
                echo "<td>".$type_title."</td>";
                echo "<td>".$row_event["staff"]."</td>";
                echo "<td>".$row_event["student"]."</td>";
                echo "<td>".$row_event["date"]."</td>";
                echo "<td>".$row_event["time"]."</td>";
                echo "<td>".$row_event["time1"]."</td>";
                echo "<td>".$row_event["venue"]."</td>";
                echo "<td class='no-print'>
                        <button class='action-btn' onclick='updateEvent(".$row_event['event_id'].")'>Update</button>
                        <br><br>
                        <button class='btn-danger' onclick='deleteEvent(".$row_event['event_id'].")'>Delete</button>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p> $event_date</p>";
        }
    }

    // Close connection
    $conn->close();
    ?>

    <!-- Your scripts go here -->
    <script>
        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                window.location.href = 'shedule.php?delete_event=' + eventId;
            }
        }

        function updateEvent(eventId) {
            // Redirect the user to the update page with the event_id parameter
            window.location.href = 'update_event.php?event_id=' + eventId;
        }

        // Function to print the current page
        function printPage() {
            window.print();
        }

        // Function to toggle dark mode
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>
