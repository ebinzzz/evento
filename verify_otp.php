<?php
// Get email from URL parameter
if(isset($_GET['email'])) {
    // Retrieve email value from the URL
    $email = $_GET['email'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        
        <!-- OTP submission form -->
        <form id="otpForm" action="verify1_otp.php" method="POST">
            <div class="form-group">
            
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
            <input type="submit" value="Validate OTP">
        </form>
    </div>
</body>
</html>

<style>
    body{
        background-color: grey;
    }
    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: aliceblue;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="submit"] {
        width: 95%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        align-items: center;
    }

    input[type="submit"] {
        padding: 10px 15px;
        background-color: green;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        align-items: center;
    }
</style>
