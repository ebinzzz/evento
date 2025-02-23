<?php
if (isset($_GET['event_id'])) {
    // Retrieve the event_id from the URL
    $event_id = $_GET['event_id'];

    // You can use the $event_id as needed, for example, to query the database
    echo "Event ID: " . $event_id;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .card {
            width: 444px;
        }

        body {
            background: #eee;
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-center container mt-5">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "events";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM events where event_id=$event_id ";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event_title = $row['event_title'];
        $event_description = $row['pre'];
        $event_date = $row['date'];
        $event_location = $row['venue'];
        $staff = $row['staff'];
        $students = $row['student'];
        $image = $row['image'];
        $capa = $row['capa'];

        // Output event card HTML
        echo '
        <div class="card p-3 bg-transparent ">
            <div class="about-product text-center mt-2">
                <img src="includes/'.$image.'" alt="Event Image" class="event-image">
                <div>
                    <h4>'.$event_title.'</h4>
                    <h6 class="mt-0 text-black-50">'.$event_description.'</h6>
                </div>
            </div>
            <div class="stats mt-2">
                <div class="d-flex justify-content-between p-price"><span>Event Date</span><span>'.$event_date.'</span></div>
                <div class="d-flex justify-content-between p-price"><span>Location</span><span>'.$event_location.'</span></div>
                <div class="d-flex justify-content-between p-price"><span>Student Coordinator</span><span>'.$students.'</span></div>
                <div class="d-flex justify-content-between p-price"><span>Staff Coordinator</span><span>'.$staff.'</span></div>
            </div>';

            // Display available tickets information
            if ($capa > 0) {
                echo "<p>$capa Tickets Available</p>";
            } else {
                echo "<p style='color: red;'>0 Tickets available</p>";
            }

            echo '<br>';

            // PHP logic for the booking button
            if ($capa > 0) {
                echo "<form id='bookingForm' method='GET' action='register.php'>
                          <input type='hidden' name='event_id' value='$event_id'>
                          <button type='submit' class='btn-book'>Book</button>
                      </form>";
            } else {
                echo "<button type='button' class='btn-book' disabled>Unavailable</button>";
            }
        ?>
        </div>
    <?php
    }
}
?>
</div>
</body>
</html>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>




</body>
</html>
<style>
.event-image {
    max-width: 100%;
    height: auto;
}
body {
    background-image: url('pre1.jpg'); /* Set the background image */
    background-repeat: no-repeat;
    background-size: cover; /* This will make the background image cover the entire element, in this case, the body, regardless of its dimensions */
}

.btn-book {
    display: block; /* Ensure the button takes up the full width */
    margin: 0 auto; /* Center align the button */
    background-color: black; /* Gray color */
    color: #fff; /* Text color */
    padding: 10px 20px; /* Add padding */
    cursor: pointer; /* Change cursor on hover */
    border-radius: 30px;
}

.btn-book:hover {
    background-color: #999; /* Darker gray color on hover */
}

.card {
    color: white; /* Set text color to white */
    border-color: #fff;
}

.stats span {
    color: white; /* Set text color to white for the spans inside .stats */
}

.about-product h4,
.about-product h6 {
    color: white; /* Set text color to white for the headings inside .about-product */
}

</style>
