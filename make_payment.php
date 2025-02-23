<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
// Start session and include necessary files
session_start();
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


// Check if the form values are set
if (
    isset($_POST['fullname']) &&
    isset($_POST['email']) &&
    isset($_POST['mobile']) &&
    isset($_POST['college']) &&
    isset($_POST['branch']) &&
    isset($_POST['amount'])  // Removed the extra comma here
) {
    // Retrieve form values
    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $amount = $_POST['amount'];

    // If event_id is set, you can retrieve it as well
    if (isset($_POST['event_id'])) {
        $event_id = $_POST['event_id'];
        // Process event_id if needed
    }
    $stmt = $conn->prepare("SELECT event_title FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id); // Assuming event_id is an integer
$stmt->execute();

// Bind the result variables
$stmt->bind_result($event_title);

// Fetch and display the result
if ($stmt->fetch()) {
  
} else {
    echo "Event not found";
}

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <a href="http://localhost/tech/index.php"><h3>Back</h3></a>
    <h1>Registration Detail Verification</h1>
    
    <!-- Receipt Section -->
    <div id="receipt">
        <h2><?php echo"$event_title" ?></h2>
        <p><strong>Name:</strong> <span id="receipt_name"><?php echo $full_name; ?></span></p>
        <p><strong>Email:</strong> <span id="receipt_email"><?php echo $email; ?></span></p>
        <p><strong>Mobile:</strong> <span id="receipt_mobile"><?php echo $mobile; ?></span></p>
        <p><strong>College:</strong> <span id="receipt_college"><?php echo $college; ?></span></p>
        <p><strong>Branch:</strong> <span id="receipt_branch"><?php echo $branch; ?></span></p>
        <p><strong>Amount:</strong> <span id="receipt_amount"><?php echo $amount; ?></span></p>
   

    <form id="paymentForm" method="POST">
        <input type="hidden" name="fullname" id="name" value="<?php echo $full_name; ?>">
        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
        <input type="hidden" name="mobile" id="mobile" value="<?php echo $mobile; ?>">
        <input type="hidden" name="college" id="college" value="<?php echo $college; ?>">
        <input type="hidden" name="branch" id="branch" value="<?php echo $branch; ?>">
        <input type="hidden" name="amount" id="amount" value="<?php echo $amount; ?>">
        <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id; ?>">
        <button type="button" name="submit" onclick="MakePayment()">Verified</button>
    </form>
    </div>

    <script>
        // Display receipt when the page loads
        $(document).ready(function() {
            $("#receipt").show();
        });

        function MakePayment() {
            var name = $("#name").val();
            var email = $("#email").val();
            var mobile = $("#mobile").val();
            var college = $("#college").val();
            var branch = $("#branch").val();
            var amount = $("#amount").val();
            var event_id = $("#event_id").val();

            var options = {
                "key": "rzp_test_pXVIBUvlB40c8v",
                "amount": amount*100,
                "currency": "INR",
                "name": name,
                "description": "Payment for " , // Adjust the description as needed
                "image": "https://example.com/your_logo",
                "handler": function (response) {
                    // Handle the response after payment success
                    // Validate and sanitize the inputs if needed.
                    $.ajax({
                        type: 'POST',
                        url: 'payment.php',
                        data: {
                            name: name,
                            pay_id: response.razorpay_payment_id,
                            email: email,
                            mobile: mobile,
                            college: college,
                            branch: branch,
                            amount: amount,
                            event_id: event_id,
                        },
                        success: function(response) {
                            console.log(response); // Log the response for debugging
                            // If payment.php returns a response, handle it here
                            window.location.href = "success.php";
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log any errors for debugging
                        }
                    });
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    </script>


</body>
</html>


<style>
/* Style the form container */
/* Style for Receipt Section */
/* Style for Receipt Section */
#receipt {
    width: 80%;
    margin: 50px auto;
    padding: 20px;
    background-color: #f7f9fc;
    border: 2px solid #007BFF; /* Razorpay blue color */
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

#receipt h2 {
    font-size: 28px;
    color: #007BFF; /* Razorpay blue color */
    border-bottom: 2px solid #007BFF; /* Razorpay blue color */
    padding-bottom: 10px;
    margin-bottom: 25px;
}

#receipt p {
    font-size: 20px;
    margin-bottom: 20px;
    color: #333; /* Dark text color */
}

#receipt strong {
    font-weight: bold;
    color: #007BFF; /* Razorpay blue color */
}

/* Responsive Design */
@media (max-width: 768px) {
    #receipt {
        width: 95%;
    }
    
    #receipt h2 {
        font-size: 24px;
    }

    #receipt p {
        font-size: 18px;
    }
}


form {
  width: 300px;
  margin-top:5%;
  margin-left:39%;
  padding: 20px;
  background-color: grey;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Style labels */
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

/* Style input fields */
input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  transition: border-color 0.3s;
}

/* Style button */
button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* Hover effect for the button */
button:hover {
  background-color: #0056b3;
}

/* Add a special style for the focused input field */
input[type="text"]:focus,
input[type="number"]:focus {
  border-color: #007bff;
  outline: none;
}

/* Style for hidden input fields (if needed) */
input[type="hidden"] {
  display: none; /* Hide hidden input fields */
}

/* Optional: Style error messages or validation feedback */
.error {
  color: #ff0000;
  font-size: 14px;
  margin-top: 5px;
}
h1{
    text-align:center;
}
body{
    background:grey;
}
a{
    text-decoration:none;
}

    </style>