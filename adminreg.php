<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="username">User:</label>
                <select id="user" name="user"  required   placeholder="user type">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            </select>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register">Register</button>
            </div>
        </form>
    </div>

    <?php
    session_start();

    // Database connection
    $host = "localhost"; // Host name
    $dbUsername = "root"; // MySQL username
    $dbPassword = ""; // MySQL password
    $dbName = "events"; // Database name

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            // Fetch and sanitize input data
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $_POST['user'];
            $confirm_password = $_POST['confirm_password'];

            // Check if password matches confirm password
            if ($password !== $confirm_password) {
                echo "Passwords do not match.";
                exit();
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert user into database
            $query = "INSERT INTO user (username,user_type, password) VALUES (?,?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $username,$user, $hashed_password);

            if ($stmt->execute()) {
                echo "User registered successfully!";
            } else {
                echo "Error: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
    ?>

</body>
</html>
<style>
    /* Reset default styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  width: 400px;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container h2 {
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="password"],
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button[type="submit"] {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

</style>