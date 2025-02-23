<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Resource Person to Event</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<a href="dashboard.php">
      <!-- You can use a button or an arrow -->
      <button class="back-btn">Back to Dashboard</button>
      <!-- Or you can use an arrow symbol -->
      <!-- <span>&#8592; Back to Dashboard</span> -->
    </a>
  <div class="container">
    <h2>Add Resource Person to Event</h2>
    <form action="add_resource.php" method="post" class="form">
      <div class="form-group">
        <label for="eventName">Event Name</label><br>
        <select id="eventName" name="eventName" required>
          <option value="">Select Event</option>
          <?php
            // Include your database connection file
            // Database connection parameters
            $servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
            $username = "root"; // Change this to your MySQL username
            $password = ""; // Change this to your MySQL password
            $database = "events"; // Change this to your MySQL database name
    
            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch events from the database
            $sql = "SELECT event_id, event_title FROM events";
            $result = mysqli_query($conn, $sql);

            // Loop through the results and create options
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<option value='" . $row['event_id'] . "'>" . $row['event_title'] . "</option>";
            }

            // Close database connection
            mysqli_close($conn);
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Contact</label><br>
        <input type="number" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="Place">Place</label><br>
        <input type="text" id="place" name="place" required>
      </div>
    
      <div class="form-group">
        <label for="expertise">Expertise</label><br>
        <input type="text" id="expertise" name="expertise" required>
      </div>
      <div class="form-group">
        <label for="expertise">Fee</label><br>
        <input type="number" id="fee" name="fee" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Add Resource Person" class="btn">
      </div>
    </form>
  </div>
</body>
</html>

<style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  width: 40%;
  height: 60%;
  margin: 50px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  font-size: 24px;
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="email"],input[type="number"],Select {
  width: 90%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
}

.btn:hover {
  background-color: #45a049;
}
.back-btn{
      margin:10px;
    }



</style>