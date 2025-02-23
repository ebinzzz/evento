<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resource Persons</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 80%;
      margin: 50px auto;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    table tbody tr:hover {
      background-color: #ddd;
    }

    .send-mail-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 5px;
      text-align:center;
    }

    .send-mail-btn:hover {
      background-color: #45a049;
    }
    .back-btn{
      margin:10px;
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
    <h2>Resource Persons</h2>

    <!-- Search form -->
    <form method="GET" action="">
      <input type="text" name="search" placeholder="Search by event name, venue, or name">
      <input type="submit" value="Search">
    </form>

    <?php
      // Include your database connection file
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

      // Fetch resource persons from the database
      $sql = "SELECT * FROM reso";

      // Check if there's a search query
      if(isset($_GET['search'])) {
        $search = $_GET['search'];
        // Modify the SQL query to include the search condition
        $sql = "SELECT * FROM reso WHERE name LIKE '%$search%' OR email LIKE '%$search%' ";
      }

      $result = mysqli_query($conn, $sql);

      // Check if there are any errors in the query
      if(!$result) {
          echo "Error: " . mysqli_error($conn);
      }

      // Check if there are any results
      if (mysqli_num_rows($result) > 0) {
          // Display table headers
          echo "<table>";
          echo "<thead>";
          echo "<tr>";
          echo "<th>Name</th>";
          echo "<th>Email</th>";
          echo "<th>Expertise</th>";
          echo "<th>Event Title</th>";
          echo "<th>Event Time</th>";
          echo "<th>Venue</th>";
          echo "<th>Action</th>";
          echo "</tr>";
          echo "</thead>";

          echo "<tbody>";

          // Loop through the results and display them in table rows
          while ($row = mysqli_fetch_assoc($result)) {
              // Fetch event details for each resource person
              $eventName = $row['eventName'];
              $eventSql = "SELECT * FROM events WHERE event_id = '$eventName'";
              $eventResult = mysqli_query($conn, $eventSql);

              // Check if event details are fetched
              if ($eventResult && mysqli_num_rows($eventResult) > 0) {
                  $eventRow = mysqli_fetch_assoc($eventResult);
                  echo "<tr>";

                  echo "<td>" . $row['name'] . "</td>";
                  echo "<td>" . $row['email'] . "</td>";
                  echo "<td>" . $row['expertise'] . "</td>";
                  echo "<td>" . $eventRow['event_title'] . "</td>";
                  echo "<td>" . $eventRow['time'] . "</td>";
                  echo "<td>" . $eventRow['venue'] . "</td>";
                  echo "<td>
                        <a href='send_emails.php?id={$row['id']}'>
                        <button class='send-mail-btn'>Send Email</button>
                        </a>
                        </td>";
                  echo "</tr>";
              }
          }

          echo "</tbody>";
          echo "</table>";
      } else {
          echo "No records found.";
      }

      // Close database connection
      mysqli_close($conn);
    ?>
  </div>
</body>
</html>
