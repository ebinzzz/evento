<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch participants from the database
$sql = "SELECT * FROM participants";
$result = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if participant_id and status are set
    if (isset($_POST['participant_id']) && isset($_POST['status'])) {
        // Sanitize input to prevent SQL injection
        $participantId = $conn->real_escape_string($_POST['participant_id']);
        $status = $conn->real_escape_string($_POST['status']);
        
        // Update attendance status in the database
        $updateSql = "UPDATE participants SET attend = '$status' WHERE p_id = '$participantId'";
        if ($conn->query($updateSql) === TRUE) {
            echo "Attendance for participant with ID $participantId updated successfully.";
        } else {
            echo "Error updating attendance: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Marking</title>

    <style>
        .attendance-scanner-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50; /* Green */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    transition-duration: 0.4s;
    margin: 10px;
}

.attendance-scanner-btn:hover {
    background-color: #45a049; /* Darker green */
}

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .attendance-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: transparent; /* No initial background color */
            color: black;
            border-color:black;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }

        .attendance-btn.present {
            background-color: #4CAF50;
        }

        .attendance-btn.absent {
            background-color: #FF5733;
        }
    </style>
</head>
<body>
    
<a href="dashboard.php">
      <!-- You can use a button or an arrow -->
      <button class="back-btn">Back to Dashboard</button>
      <!-- Or you can use an arrow symbol -->
      <!-- <span>&#8592; Back to Dashboard</span> -->
    </a>
    <div class="container">
        <h2>Attendance Marking</h2>
        <a href="attend1.html" class="attendance-scanner-btn">Scan QR Code</a>
        <a href="http://localhost/tech/downattend.php" class="attendance-scanner-btn">Attendence Sheet</a>
        <br>
        <br>

        <table>
            <thead>
                <tr>
                <th>id</th>
                <th>ticket</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display participants and generate checkboxes
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["p_id"] . '</td>';
                        echo '<td>' . $row["ticket_id"] . '</td>';
                        echo '<td>' . $row["fullname"] . '</td>';
                        echo '<td>' . $row["email"] . '</td>';
                        // Check the initial attendance status and set the button class accordingly
                        $attendance_class = ($row["attend"] == 'present') ? 'present' : 'absent';
                        echo '<td><button class="attendance-btn ' . $attendance_class . '" data-participant-id="' . $row["p_id"] . '">' . ucfirst($attendance_class) . '</button></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No participants found</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <p id="attendanceMessage"></p>
    </div>

    <script>
        // JavaScript for handling attendance marking
        document.querySelectorAll('.attendance-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var status = this.textContent.toLowerCase(); // Get the current status from the button text
                var newStatus = (status === 'present') ? 'absent' : 'present'; // Toggle the status
                var message = 'You are marked ' + newStatus + '!';
                document.getElementById('attendanceMessage').textContent = message;

                // Update button class and text
                this.classList.remove(status);
                this.classList.add(newStatus);
                this.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                // Update attendance status in the database via AJAX
                var participantId = this.getAttribute('data-participant-id');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send('participant_id=' + participantId + '&status=' + newStatus);
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
