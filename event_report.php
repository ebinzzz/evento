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

// Get the event_id from the URL
if(isset($_GET['event_id']) && !empty(trim($_GET['event_id']))){
    $event_id = trim($_GET['event_id']);

    // Define your SQL query to retrieve event details, total registrations, and count of attendees with status 'present'
    $query = "SELECT events.event_id, events.event_title, events.date, events.venue, events.pre, events.image, events.staff, events.time, events.time1, events.event_price, events.student, events.reso, 
              COUNT(participants.event_id) AS registrations,
              SUM(CASE WHEN participants.attend = 'present' THEN 1 ELSE 0 END) AS attendees_present,
             reso.name  AS resource_persons
              FROM events 
              JOIN participants ON events.event_id = participants.event_id 
              LEFT JOIN reso ON events.reso = reso.eventName
              WHERE events.event_id = ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch event details
    $row = $result->fetch_assoc();



    $query1 = "SELECT *from reso where eventName=?";

// Prepare and execute the statement
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $event_id);
$stmt1->execute();
$result1 = $stmt1->get_result();

// Fetch event details
$row1 = $result1->fetch_assoc();









    // Check if event exists
    if($row){
        $amt = $row['event_price'];
        $image = $row['image'];
        $tot = $amt * $row['registrations']; 
        $attendees_present = $row['attendees_present']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['event_title']; ?> Event Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
            width: 210mm; /* Width of A4 paper */
            height: 297mm; /* Height of A4 paper */
            margin: 0 auto; /* Center the content */
            box-sizing: border-box;
        }

        .event {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #fff;
            width: 100%; /* Take full width of A4 paper */
            box-sizing: border-box;
        }

       

        .event-details p {
            margin-bottom: 10px;
        }

        .event-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .test, .tech {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .event-details {
            font-size: 16px;
        }
        /* CSS for the print button */
.print-button {
    background-color: #007bff; /* Blue color */
    color: #fff; /* White text */
    padding: 10px 20px; /* Padding */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Cursor style */
    font-size: 16px; /* Font size */
    transition: background-color 0.3s ease; /* Smooth transition */
}

.print-button:hover {
    background-color: #0056b3; /* Darker blue color on hover */
}
@media print {
            .print-button {
                display: none;
            }
        }
        .tech1{
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 50px;
        }
        .event-titl{
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class='event'>
<h2 class="tech1">Report</h2>
    <p class='tech1'><h2><?php echo $row['event_title']; ?></h2></p>


    <h3 class="test">Description</h3>
    <p class="test"><?php echo $row['pre']; ?></p>

    <h3 class="tech">Detail</h3>
    <div class='event-details'>
        <p>The event was conducted on <?php echo $row['date']; ?> at <?php echo $row['venue']; ?> from <?php echo substr($row['time'], 0, 5)?>am to <?php echo substr($row['time1'], 0, 5)?>pm. A total of <?php echo $row['registrations']; ?> participants were registered and <?php echo $attendees_present; ?> attended the event.</p>

        <p>The <?php echo $row['event_title']; ?> event was conducted under the guidance of Staff Coordinator <?php echo $row['staff']; ?> and student coordinator <?php echo $row['student']; ?>.</p>
                
        <h3>Resource Persons</h3>
        <?php
    if ($row1) {
        echo $row1['name'] . " is a highly esteemed resource person and holds the position of " . $row1['expertise'] . ". They have significantly contributed to the field and are known for their outstanding knowledge and experience.";
    }
    ?>
        
        <h3>The Total Revenue Collected</h3>
        <p>The event price: <?php echo $row['event_price']; ?> * Total number of registrations for event: <?php echo $row['registrations']; ?></p>
        <p>The total revenue collected from the event is Rs <?php echo $tot; ?></p>
    </div> <!-- Close .event-details -->
 <!-- Print Button -->



 <?php

 if(isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Define an array of questions and their corresponding columns in the database
    $questions = array(
        "customer_service" => "Customer Service",
        "product_quality" => "Product Quality"
        // Add more questions here if needed
    );

    // Loop through each question
    foreach ($questions as $column => $question) {
        $sql = "SELECT $column, COUNT(*) as count FROM feedbackk WHERE event_id='$event_id' GROUP BY $column";
        $result = $conn->query($sql);

        // Initialize variables for counting feedback
        $feedbackData = array();

        // Check if there are feedback records
        if ($result->num_rows > 0) {
            // Fetch feedback data
            while($row = $result->fetch_assoc()) {
                $feedbackData[$row[$column]] = $row['count'];
            }

            // Display feedback data
            echo "<div class='container'>";
            echo "<h1>$question Feedback Summary</h1>";

            echo "<div class='feedback-item'>";
            echo "<h2>Feedback Distribution</h2>";
            echo "<div id='pieChart_$column'></div>"; // Placeholder for the pie chart
            echo "</div>";

            echo "<div class='feedback-item'>";
            echo "<h2>Feedback Details</h2>";
            // Display individual feedback details
            $result->data_seek(0); // Reset result pointer
            while($row = $result->fetch_assoc()) {
                echo "<p><strong>$question:</strong> " . $row[$column]. " - Count: " . $row['count'] . "</p>";
            }
            echo "</div>";

            echo "</div>";

            // JavaScript for rendering the pie chart
            echo "<script src='https://cdn.jsdelivr.net/npm/apexcharts'></script>";
            echo "<script>";
            echo "var options_$column = {
                    series: [" . implode(",", array_values($feedbackData)) . "],
                    labels: ['" . implode("','", array_keys($feedbackData)) . "'],
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    legend: {
                        show: true,
                        position: 'bottom'
                    }
                };

                var chart_$column = new ApexCharts(document.querySelector('#pieChart_$column'), options_$column);
                chart_$column.render();";
            echo "</script>";
        } else {
            echo "<p>No feedback data available for $question.</p>";
        }
    }
}

// Check if event_id and question are set in the URL
if(isset($_GET['event_id']) && isset($_GET['question'])) {
    $event_id = $_GET['event_id'];
    $question = $_GET['question'];

    $sql = "SELECT participant_id, $question FROM feedbackk WHERE event_id='$event_id'";
    $result = $conn->query($sql);

    // Check if there are feedback records
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h1>Feedback Details for Question: $question</h1>";

        echo "<div class='feedback-item'>";
        echo "<h2>Participant Feedback</h2>";
        echo "<table>";
        echo "<tr><th>Participant ID</th><th>$question</th></tr>";
        // Display individual feedback details
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["participant_id"]. "</td><td>" . $row[$question]. "</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        echo "</div>";
    } else {
        echo "<p>No feedback data available for this question.</p>";
    }
}

// Close database connection

?>
<style>
/* Styles for container */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

/* Styles for feedback items */
.feedback-item {
    margin-bottom: 30px;
}

.feedback-item h2 {
    margin-bottom: 10px;
    font-size: 20px;
}

/* Styles for individual feedback details */
.feedback-details p {
    margin-bottom: 5px;
}

.feedback-details p strong {
    font-weight: bold;
}

/* Styles for pie chart container */
.pie-chart-container {
    margin-top: 20px;
}
</style>

<button class="print-button" onclick="printEventReport()">Print Event Report</button>

</div> <!-- Close .event -->

</body>
<script>
    function printEventReport() {
        window.print();
    }
</script>
</html>

<?php
    } else {
        echo "Event not found";
    }
} else {
    echo "Invalid event ID";
}
?>
