<?php
// Assuming you have a database connection already established
// Replace 'localhost', 'username', 'password', and 'database_name' with your actual database credentials
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
// Assuming you have the participant's ID available in a variable called $participant_id
// Assuming you're getting the ID from the URL query parameter 'id'

// Fetching name and event_id from participants table
$sql = "SELECT fullname, event_id FROM participants WHERE p_id = '18'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $name = $row["fullname"];
        $event_id = $row["event_id"];
    }
} else {
    echo "No records found in participants table";
}

// Fetching event_title from events table based on event_id
$sql = "SELECT event_title FROM events WHERE event_id = $event_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $event_title = $row["event_title"];
    }
} else {
    echo "No records found in events table";
}

// Close the connection
mysqli_close($conn);
?>

<div class="image-container">
    <img src="ap.png" alt="Hackathon template">
    <div class="name-overlay" style="left: 57%; top: 50%; transform: translate(-50%, -50%);"><?php echo $name; ?></div>
</div>

<div class="name-overlay1" style="left: 61%; top: 55.9%; transform: translate(-50%, -50%);"><?php echo $event_title; ?></div>


<style>
.image-container {
  display: flex;
  justify-content: center;
}

.image-container img {
  max-width: 100%;
  height: auto;
  margin:10%;
}

.name-overlay {
  position: absolute;
  padding: 10px;
  background-color: transparent;
  text-align: center;
  font-size: 70px;
  font-family: cursive;
  color:gold;
}
.name-overlay1 {
  position: absolute;
  padding: 10px;
  background-color: transparent;
  text-align: center;
  font-size: 35px;
  font-family: "Poppins", sans-serif;
  color: rgb(117, 172, 117);
  text-transform: uppercase;
  
  }
</style>