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

// Check if event_id is set in the URL
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
$conn->close();
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
