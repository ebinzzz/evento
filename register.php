<?php
// Start session and include necessary files
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db/connect.php";

// Initialize event price variable
$event_price = 0;

// Check if the event_id is set in the URL parameters
if (isset($_GET['event_id'])) {
    // Retrieve the event ID from the URL
    $event_id = $_GET['event_id'];

    // Query to select event price based on event_id
    $sql = "SELECT event_price FROM events WHERE event_id = $event_id";

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch the event price from the result set
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Set the event price
            $event_price = $row['event_price'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glassmorphism Registration Form</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <div class="wrapper">
    <form id="signup_form" method="post" action="make_payment.php" class="was-validated">
      <input type="hidden" name="event_id" value="<?php echo isset($_GET['event_id']) ? $_GET['event_id'] : ''; ?>">
      <input type="hidden" name="amount" value="<?php echo $event_price; ?>">

      <h2>Registration Form</h2>
      <div class="input-field">
        <i class="fas fa-user"></i>
        <input type="text" name="fullname" required>
        <label>Enter Name</label>
      </div>
      <div class="input-field">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" required>
        <label>Enter your email</label>
        <div id="email-error" class="error-message">Please enter a valid email address</div>
      </div>
      <div class="input-field">
        <i class="fas fa-phone"></i>
        <input type="number" name="mobile" required>
        <label>Enter phone no</label>
      </div>
      <div class="input-field">
        <i class="fas fa-university"></i>
        <input type="text" name="branch" required>
        <label>Enter your Branch</label>
      </div>
      <div class="input-field">
        <i class="fas fa-school"></i>
        <input type="text" name="college" required>
        <label>Enter your College</label>
      </div>
      
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    document.getElementById('email').addEventListener('input', function() {
      var email = this.value;
      var emailError = document.getElementById('email-error');
      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

      if (emailPattern.test(email)) {
        emailError.style.display = 'none';
      } else {
        emailError.style.display = 'block';
      }
    });
  </script>
</body>
</html>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
  position: relative;
  overflow: hidden;
}

.wrapper {
  width: 400px;
  border-radius: 10px;
  padding: 30px;
  text-align: center;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  z-index: 1;
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #fff;
}

.input-field {
  position: relative;
  margin: 20px 0;
}

.input-field input {
  width: 100%;
  height: 45px;
  background: transparent;
  border: none;
  border-bottom: 2px solid #fff;
  outline: none;
  font-size: 16px;
  color: #fff;
  padding-left: 35px;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 12px;
  top: -10px;
  color: #71b7e6;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 35px;
  transform: translateY(-50%);
  color: #fff;
  font-size: 16px;
  pointer-events: none;
  transition: 0.2s ease;
}

.input-field i {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 20px;
  color: #fff;
}

button {
  background: #71b7e6;
  color: #fff;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 5px;
  font-size: 16px;
  transition: 0.3s ease;
  margin-top: 20px;
}

button:hover {
  background: #9b59b6;
}

.error-message {
  color: red;
  font-size: 12px;
  display: none;
}

@media (max-width: 420px) {
  .wrapper {
    width: 100%;
    padding: 20px;
  }
}

</style>