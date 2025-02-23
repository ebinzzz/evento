<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Details</title>
  <style>
 body, html {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: Arial, sans-serif;
}

.video-background {
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 100vh;
  background-size: cover;
  background-position: center;
}

video {
  position: absolute;
  left: 50%;
  top: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: -1;
  transform: translateX(-50%) translateY(-50%);
}

.content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #fff;
  text-align: center;
  z-index: 1;
  width: 100%;
}

/* Additional styles for your content */


    .container {
      width: 80%;
      margin: 50px auto;
      text-align: center;
      background-color: transparent; /* Transparent background */
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px; /* Add space between containers */
    }

    .button {
      padding: 20px 40px;
      background-color: transparent;
      color: #fff;
      font-size: 20px;
      text-transform: uppercase;
      cursor: pointer;
      margin: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: black;
    }

    .participant-details {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd; /* Add gap between rows */
      background-color: transparent; /* White background color */
      color: white;
    }

    th:first-child, td:first-child {
      border-left: 1px solid #ddd; /* Add left border for first column */
    }

    th:last-child, td:last-child {
      border-right: 1px solid #ddd; /* Add right border for last column */
    }
    @media print {
      /* Print-specific styles */
      body {
        background-color: white;
      }
      #participantsTable {
        background-color: black;
        color: white;
      }
    }
    #searchContainer {
  text-align: center; /* Center-align the search container */
  margin-bottom: 10px; /* Add space between search input and table */
  width: 400px; /* Set the width of the search container */
  height: 70px; /* Set the height of the search container */
}


#searchInput {
  width: 300px; /* Set the width of the search input */
  padding: 10px; /* Add padding to increase the size of the input box */
  font-size: 18px; /* Increase the font size for better visibility */
}
.table-container {
  max-height: 400px; /* Adjust the maximum height as needed */
  overflow-y: auto; /* Enable vertical scrolling */
}



  </style>
</head>
<body>
<div class="video-background">
    <video autoplay muted loop id="myVideo">
      <source src="video (2160p).mp4" type="video/mp4">
      Your browser does not support HTML5 video.
    </video>

<div class="container">
  <form action="getEventData.php" method="get">
    <button class="button" type="submit" name="type_id" value="1">Technical Event</button>
    <button class="button" type="submit" name="type_id" value="2">Gaming Event</button>
    <button class="button" type="submit" name="type_id" value="3">On Stage Event</button>
    <button class="button" type="submit" name="type_id" value="4">Off Stage Event</button>
  </form>

  <div class="participant-details">
    <?php
    // PHP code to display event details
    if(isset($_GET['type_id'])) {
        $type_id = $_GET['type_id'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "events";

        // Establish database connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch event data based on type_id
        $event_query = "SELECT * FROM events WHERE type_id = $type_id";
        $event_result = $conn->query($event_query);

        if ($event_result->num_rows > 0) {
            $event_data = $event_result->fetch_assoc();
            echo "<h2>{$event_data['event_name']} Participants</h2>";

            // Fetch participants data for the event
            $event_id = $event_data['event_id'];
            $participants_query = "SELECT * FROM participants WHERE event_id= $event_id and type_id=$type_id";
            $participants_result = $conn->query($participants_query);

            if ($participants_result->num_rows > 0) {
                echo "<ul>";
                while ($row = $participants_result->fetch_assoc()) {
                    echo "<li>{$row['participant_name']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No participants found for this event.</p>";
            }
        } else {
            echo "<p>No event found for the given type_id</p>";
        }

        // Close database connection
        $conn->close();
    }
    ?>
      <button onclick="printTable()">Print Table</button>
    <div id="searchContainer">
      <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for participants...">
    </div>

    <?php
    // PHP code to display event details

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "events";

    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch participants data for the event
    $participants_query = "SELECT * FROM participants";
    $participants_result = $conn->query($participants_query);

    if ($participants_result->num_rows > 0) {

      
      
        // Output the number of rows retrieved

        // Display participants data in a table
        
        echo "<table id='participantsTable' border='1'>";
        echo "<tr>";
        echo "<th>p_id</th>";
        echo "<th>fullname</th>";
        echo "<th>event</th>";
        echo "<th>email</th>";
        echo "<th>mobile</th>";
        echo "<th>college</th>";
        echo "<th>branch</th>";
        echo "<th>payment_type</th>";
        echo "<th>amount</th>";
        echo "<th>id</th>";
        echo "</tr>";

        while ($row = $participants_result->fetch_assoc()) {
          $event_id = $row['event_id'];
          $sql1 = "SELECT event_title FROM events WHERE event_id = '$event_id'";
          $result1 = $conn->query($sql1); // Pass the SQL query to $conn->query() function
            
          // Check if the query was successful
          if ($result1) {
              // Check if there is at least one row returned
              if ($result1->num_rows > 0) {
                  // Fetch the result as an associative array
                  $row1 = $result1->fetch_assoc();
                  $event_title = $row1['event_title'];
                  // Now you can use $event_title as needed
              } else {
                  // Handle case where no rows were found
                  $event_title = "Event Title Not Found";
              }
          } else {
              // Handle query execution errors
              $event_title = "Error retrieving event title";
          }
          
          // Display the participant details with the event title
          echo "<tr>";
          echo "<td>{$row['p_id']}</td>";
          echo "<td>{$row['fullname']}</td>";
          echo "<td>{$event_title}</td>"; // Display the event title
          echo "<td>{$row['email']}</td>";
          echo "<td>{$row['mobile']}</td>";
          echo "<td>{$row['college']}</td>";
          echo "<td>{$row['branch']}</td>";
          echo "<td>{$row['payment_type']}</td>";
          echo "<td>{$row['amount']}</td>";
          echo "<td>{$row['id']}</td>";
          echo "</tr>";
      }
      

        echo "</table>";
    } else {
        echo "<p>No participants found for this event.</p>";
    }

    // Close database connection
    $conn->close();

    ?>

    <script>
      function searchTable() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("participantsTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td");
          for (var j = 0; j < td.length; j++) {
            if (td[j]) {
              txtValue = td[j].textContent || td[j].innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break;
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }
      }
    </script>
  </div>
</div>

</body>
</html>

<script>
  function printTable() {
    window.print();
  }
</script>