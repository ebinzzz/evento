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

// Initialize variables
$event_id = $event_title = $event_price = $type_id = $staff = $student = $date = $time = $venue = "";

// Check if event ID is provided in the URL
if(isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    
    // Fetch event data from the database based on event ID
    $sql = "SELECT * FROM events WHERE event_id = $event_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $event_title = $row["event_title"];
        $event_price = $row["event_price"];
        $type_id = $row["type_id"];
        $staff = $row["staff"];
        $student = $row["student"];
        $date = $row["date"];
        $time = $row["time"];   
        $time1 = $row["time1"]; 
        $venue = $row["venue"];
    } else {
        echo "Event not found";
        exit();
    }
} else {
    echo "Event ID not provided";
    exit();
}

// Handle form submission for event update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_title = $_POST["event_title"];
    $event_price = $_POST["event_price"];
    $type_id = $_POST["type_id"];
    $staff = $_POST["staff"];
    $student = $_POST["student"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $time1 = $_POST["time1"];
    $venue = $_POST["venue"];

    // Check if an image file is uploaded
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        // Upload the image to the server
        $targetDirectory = "uploads/"; // Specify the directory where you want to store uploaded images
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
           // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    

    // Update event details in the database
    $sql_update = "UPDATE events SET event_title='$event_title', event_price='$event_price', image='$targetFile', type_id='$type_id', staff='$staff', student='$student', date='$date', time='$time',time1='$time1', venue='$venue' WHERE event_id=$event_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Event updated successfully');</script>";
        // Redirect to schedule.php after a short delay
        echo "<script>setTimeout(function() { window.location.href = 'http://localhost/tech/includes/shedule.php'; }, 1000);</script>";
    } else {
        echo "Error updating event: " . $conn->error;
    }
} else {
    echo "No image file was uploaded.";
}       
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <style>
        /* Your CSS styles here */
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    margin-top: 20px;
    color: #333;
}

form {
    width: 50%;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="date"],
input[type="time"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="file"] {
    margin-bottom: 10px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.error {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}
    </style>
</head>
<body>
    <h2>Update Event</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="event_title">Event Title:</label><br>
        <input type="text" id="event_title" name="event_title" value="<?php echo $event_title; ?>"><br>

        <label for="event_price">Event Price:</label><br>
        <input type="text" id="event_price" name="event_price" value="<?php echo $event_price; ?>"><br>

        <label for="image">Upload Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br>
        

        <label for="type_id">Type ID:</label><br>
        <input type="text" id="type_id" name="type_id" value="<?php echo $type_id; ?>"><br>

        <label for="staff">Staff:</label><br>
        <input type="text" id="staff" name="staff" value="<?php echo $staff; ?>"><br>

        <label for="student">Student:</label><br>
        <input type="text" id="student" name="student" value="<?php echo $student; ?>"><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>"><br>

        <label for="time">From Time:</label><br>
        <input type="time" id="time" name="time" value="<?php echo $time; ?>"><br>

        <label for="time">To Time:</label><br>
        <input type="time" id="time1" name="time1" value="<?php echo $time1; ?>"><br>

        <label for="venue">Venue:</label><br>
        <input type="text" id="venue" name="venue" value="<?php echo $venue; ?>"><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
