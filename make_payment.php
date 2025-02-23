<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<?php
// Start session and include necessary files
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db/connect.php";

// Check if the form values are set
if (
    isset($_POST['full_name']) &&
    isset($_POST['email']) &&
    isset($_POST['mobile']) &&
    isset($_POST['college']) &&
    isset($_POST['branch']) &&
    isset($_POST['amount'])  // Removed the extra comma here
) {
    // Retrieve form values
    $full_name = $_POST['full_name'];
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
    <a href="demo.php"><h3>Back</h3></a>
    <h1>Fee Detail Verification</h1>
    <form method="POST">
       
    
        <input type="hidden" name="name" id="name" value="<?php echo $fullname; ?>">
        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
        <input type="hidden" name="mobile" id="mobile" value="<?php echo $mobile; ?>">
        <input type="hidden" name="college" id="college" value="<?php echo $college; ?>">
        <input type="hidden" name="branch" id="branch" value="<?php echo $branch; ?>">
        <input type="hidden" name="amount" id="amount" value="<?php echo $amount; ?>">
       
        <button type="button" name="submit" onclick="MakePayment()">Verified</button>
    </form>

    <script>
        function MakePayment() {
            var name = $("#name").val();
            var email = $("#email").val() ; // Amount should be in paise
            var mobile= $("#mobile").val();
            var college = $("#college").val();
            var branch = $("#branch").val();
            var amount = $("#amount").val();


            // Validate and sanitize the inputs if needed.
            jQuery.ajax({
            type: 'POST',
            url: 'payment.php',
            data: {
                record_id: record_id,
                name: name,
                amount: amount,
                remark:remark,
                fee_id1:fee_id1,
                cource:cource,
                sem:sem,
                cat:cat,
               
            },
        });
    
            var options = {
                "key": "rzp_test_pXVIBUvlB40c8v",
                "amount": amount*100,
                "currency": "INR",
                "name": name,
                "description": "Payment for " + remark, // Adjust the description as needed
                "image": "https://example.com/your_logo",
                "handler": function (response) {
                    // Handle the response after payment success
                    jQuery.ajax({
                        type: "POST",
                        url: "payment.php", // Adjust the URL for payment processing
                        data: {
                            pay_id: response.razorpay_payment_id,
                            record_id: record_id,
                            // Add any other relevant data here
                        },
                        success: function (result) {
                            window.location.href = "success.php"; // Redirect to a success page
                        },
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