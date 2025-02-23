<?php
// Assuming you have already connected to your MySQL database
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

// Define your SQL query to retrieve event details and registrations count
$query = "SELECT events.event_id, events.event_title, events.date, events.venue,events.pre,events.image, events.staff,events.time,events.time1,events.event_price, events.student, events.reso, COUNT(participants.event_id) AS registrations 
          FROM events 
          JOIN participants ON events.event_id = participants.event_id 
          GROUP BY events.event_id";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Report</title>
    <style>
        .event {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .event-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .event-details {
            margin-left: 20px;
            font-size: 16px;
        }
.tech{
    margin-left:20px;
}
.test{
    margin-left:20px;

}
.event-image {
    height: 300px; /* Custom height */
    width: 300px; /* Custom width */
}

.summary {
    margin-top: 20px;
}

        
    </style>
</head>
<body>

<?php
$totalRegistrations = 0;
$totalRevenue = 0;

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Output each event details in paragraph format
    while ($row = mysqli_fetch_assoc($result)) {
        $amt = $row['event_price'];
        $image = $row['image'];
        $tot = $amt * $row['registrations']; 

        // Increment total registrations and revenue
        $totalRegistrations += $row['registrations'];
        $totalRevenue += $tot; 
?>
        <!-- Output HTML content for each event -->
        <div class='event'>
            <p class='event-title'><h2><?php echo $row['event_title']; ?></h2></p>
            <img src="includes/<?php echo $image; ?>" alt="Event Image" class="event-image">

            <h3 class="test">Description</h3>
            <p class="test"><?php echo $row['pre']; ?></p>

            <h3 class="tech">Detail</h3>
            <div class='event-details'>
                <p>The event was conducted on <?php echo $row['date']; ?> at <?php echo $row['venue']; ?> From <?php echo substr($row['time'], 0, 5)?>am to <?php echo substr($row['time1'], 0, 5)?>pm. A total of <?php echo $row['registrations']; ?> participants were registered and attended the event.</p>

                <p>The <?php echo $row['event_title']; ?> event was conducted under the guidance of Staff Coordinator <?php echo $row['staff']; ?> and student coordinator <?php echo $row['student']; ?>.</p>
                
                <h3>The Total Revenue Collected</h3>
                <p>The event price: <?php echo $row['event_price']; ?> * Total number of registrations for event: <?php echo $row['registrations']; ?></p>
                <p>The total revenue collected from the event is Rs <?php echo $tot; ?></p>
            </div> <!-- Close .event-details -->
        </div> <!-- Close .event -->
<?php
    }
} else {
    echo "<p>No events found</p>";
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Summary -->
<div class="summary">
    <h2>Summary</h2>
    <p>Total number of registrations across all events: <?php echo $totalRegistrations; ?></p>
    <p>Total revenue collected from all events: Rs <?php echo $totalRevenue; ?></p>
</div>

</body>
</html>
