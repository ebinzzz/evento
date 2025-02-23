<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "username";
$password = "password";
$database = "your_database";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch participants from the database
$sql = "SELECT * FROM participants";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Marking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .attendance-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
        .attendance-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Attendance Marking</h2>
        <p>Click the button to mark attendance:</p>
        <form action="process_attendance.php" method="POST">
            <?php
            // Display participants and generate checkboxes
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<input type="checkbox" name="attendance[]" value="' . $row["email"] . '"> ' . $row["name"] . '<br>';
                }
            } else {
                echo "0 participants found";
            }
            ?>
            <br>
            <button type="submit" class="attendance-btn">Submit Attendance</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
