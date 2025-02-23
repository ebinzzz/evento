<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate form data (you may add more validation as needed)
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields";
    } else {
        // Database connection
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $database = "ebin";

        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password for security (you may use a stronger hashing algorithm)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute SQL statement to insert data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
}
?>
