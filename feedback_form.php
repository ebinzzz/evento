<?php
// Fetch event_id and p_id from GET parameters
if(isset($_GET['event_id']) && isset($_GET['p_id'])) {
    $event_id = $_GET['event_id'];
    $p_id = $_GET['p_id'];

    // Include your database connection code here
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

    // Retrieve event title
    $sql1 = "SELECT event_title FROM events WHERE event_id = $event_id";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // Fetch event title
        $row1 = $result1->fetch_assoc();
        $event_title = $row1['event_title'];
    } else {
        $event_title = "Event Not Found";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle case where event_id and/or p_id are not provided
    // For example, redirect the user to an error page or display an error message
    exit('Event ID and Participant ID not provided.');
}

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
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

    // Retrieve form data
    $customer_service = $_POST['customer-service'];
    $product_quality = $_POST['product-quality'];
    $additional_comments = $_POST['additional-comments'];
    $encoded_event_id = urlencode($event_id);

    // Insert feedback data into the feedback table
    $sql = "INSERT INTO feedbackk (event_id, participant_id, customer_service, product_quality, additional_comments) 
            VALUES ('$event_id', '$p_id', '$customer_service', '$product_quality', '$additional_comments')";

    if ($conn->query($sql) === TRUE) {
        // Update the 'attend' column of the 'participants' table to 'done'
        $update_sql = "UPDATE participants SET feed = 'done' WHERE p_id = '$p_id'";
        if ($conn->query($update_sql) === TRUE) {
            // Store event_id in session
            header("Location: certificate.py");
            exit; // Ensure that script execution stops after redirection
        } else {
            echo "Error updating participant's attendance: " . $conn->error;
        }
        
    } else {
        echo "Error inserting feedback data: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web Development Workshop Feedback</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .question {
        margin-bottom: 20px;
    }

    .question label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 18px;
        color: #555;
    }

    .options label {
        font-size: 16px;
        color: #666;
        display: flex;
        align-items: center; /* Align items vertically */
    }

    .options input[type="radio"] {
        margin-right: 10px;
        display: none; /* Hide the default radio button */
    }

    .options label:before {
        content: "\2610"; /* Unicode for empty checkbox */
        margin-right: 5px;
    }

    .options input[type="radio"]:checked + label:before {
        content: "\2611"; /* Unicode for checked checkbox */
    }

    textarea {
        width: calc(100% - 20px);
        padding: 10px;
        resize: vertical;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h1><?php echo $event_title; ?> Feedback</h1>
    <form method="post">
        <!-- Hidden input fields for event_id and p_id -->
        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
        <input type="hidden" name="p_id" value="<?php echo htmlspecialchars($p_id); ?>">

        <!-- Questionnaire -->
        <div class="question">
            <label for="customer-service">Customer Service:</label>
            <div class="options">
                <input type="radio" id="very-good-cs" name="customer-service" value="Very Good">
                <label for="very-good-cs">Very Good</label>
                <input type="radio" id="good-cs" name="customer-service" value="Good">
                <label for="good-cs">Good</label>
                <input type="radio" id="average-cs" name="customer-service" value="Average">
                <label for="average-cs">Average</label>
                <input type="radio" id="bad-cs" name="customer-service" value="Bad">
                <label for="bad-cs">Bad</label>
            </div>
        </div>

        <div class="question">
            <label for="product-quality">Product Quality:</label>
            <div class="options">
                <input type="radio" id="very-good-pq" name="product-quality" value="Very Good">
                <label for="very-good-pq">Very Good</label>
                <input type="radio" id="good-pq" name="product-quality" value="Good">
                <label for="good-pq">Good</label>
                <input type="radio" id="average-pq" name="product-quality" value="Average">
                <label for="average-pq">Average</label>
                <input type="radio" id="bad-pq" name="product-quality" value="Bad">
                <label for="bad-pq">Bad</label>
            </div>
        </div>
    
        <!-- Add more containers for additional questions here as needed -->
    
        <div class="question">
            <label for="additional-comments">Additional Comments (Optional):</label>
            <textarea id="additional-comments" name="additional-comments" placeholder="Write your feedback here..."></textarea>
        </div>
        <button type="submit" class="btn">Submit Feedback</button>
        
    </form>
</div>

</body>
</html>
