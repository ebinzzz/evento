<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reports</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #333; /* Dark background */
            color: #eee; /* Light text color */
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .event-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .event-link {
            display: inline-block;
            background-color: #555; /* Darker background */
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-decoration: none;
            color: #eee; /* Light text color */
            transition: all 0.3s ease;
            width: calc(25% - 40px); /* Four events in each row with margins */
            box-sizing: border-box;
            text-align: center;
            box-shadow: 0 0 10px rgba(255,255,255,0.5); /* Glow effect */
        }

        .event-link:hover {
            background-color: #444; /* Darker background on hover */
            box-shadow: 0 0 20px rgba(255,255,255,0.8); /* Increased glow effect on hover */
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 300px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<h1>Event Reports</h1>

<div class="search-container">
    <input type="text" class="search-input" id="searchInput" placeholder="Search for events...">
</div>

<div class="event-links">
    <?php
    // Assuming you have already connected to your MySQL database
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

    // Define your SQL query to retrieve event details and registrations count
    $query = "SELECT event_id, event_title FROM events";
    $result = mysqli_query($conn, $query);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        // Output links to each event report
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a class='event-link' href='event_report.php?event_id=".$row['event_id']."'>".$row['event_title']."</a>";
        }
    } else {
        echo "<p>No events found</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const eventLinks = document.querySelectorAll('.event-link');

    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase().trim();
        eventLinks.forEach(link => {
            const eventName = link.innerText.toLowerCase();
            if (eventName.includes(searchText)) {
                link.style.display = 'inline-block';
            } else {
                link.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
