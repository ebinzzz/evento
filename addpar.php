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

// Fetch events from the database
$sql = "SELECT event_id, event_title, event_price FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participant Registration</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <h2>Participant Registration Form</h2>
  <button id="darkModeToggle">Dark Mode</button>
  <form id="registrationForm" method="post" action="parti.php">
    <div class="form-group">
      <label for="fullName">Full Name</label>
      <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter full name" required>
    </div>
    <div class="form-group">
      <label for="event">Event</label>
      <select class="form-control" id="event" name="event" required>
        <option value="">Select event</option>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $event_id = $row["event_id"];
                $event_title = $row["event_title"];
                $event_price = $row["event_price"];

                // Check if event price is retrieved correctly
                if (isset($event_price)) {
                    echo "<option value='$event_id'>$event_title [$event_price]</option>";
                } else {
                    echo "<option value='$event_id'>$event_title, Price not available</option>";
                }
            }
        } else {
            echo "<option value=''>No events found</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
    </div>
    <div class="form-group">
      <label for="mobile">Mobile</label>
      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" required>
    </div>
    <div class="form-group">
      <label for="college">College</label>
      <input type="text" class="form-control" id="college" name="college" placeholder="Enter college" required>
    </div>
    <div class="form-group">
      <label for="branch">Branch</label>
      <input type="text" class="form-control" id="branch" name="branch" placeholder="Enter branch" required>
    </div>
    <div class="form-group">
      <label for="amount">Amount</label>
      <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount" required >
    </div>
    <div class="form-group">
      <label for="paymentType">Payment Type</label>
      <select class="form-control" id="paymentType" name="paymentType" required>
        <option value="">Select payment type</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
        <option value="Online">Online</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="script.js"></script> 
</body>
</html>



<style>
    h2 {
        text-align: center;
    }

    body {
  transition: background-color 0.3s ease;
}

.dark-mode {
  background-color: #222;
  color: #fff;
}

.content {
  padding: 20px;
  margin: 20px;
}

</style>
