<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Venue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Venue</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="venueName">Venue Name:</label>
            <input type="text" id="venueName" name="venueName" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required>

            <input type="submit" value="Add Venue">
        </form>
    </div>
</body>
</html>

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from the form
    $venueName = $_POST["venueName"];
    $capacity = $_POST["capacity"];

    // Prepare SQL statement for inserting into the venues table
    $sql_insert = "INSERT INTO venues (venue_name, capacity) VALUES ('$venueName', '$capacity')";

    // Execute SQL statement
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql_insert . "<br>" . $conn->error . "');</script>";
    }
}

// Close connection
$conn->close();
?>
