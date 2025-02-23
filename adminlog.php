<!doctype html>
<html lang="en">
  <head>
  	<title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
  </head>
  <body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">EVENTO @ 2024</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Have an account?</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                            <select id="user" name="user"  required   placeholder="user type">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" name="submit">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                        <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
                        <div class="social d-flex text-center">
                            <a href="adminreg.php" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
                            <a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        // Fetch username and password from login form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL query to fetch user data based on username
        $query = "SELECT * FROM user WHERE username=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Password matches
            $_SESSION['username'] = $user['username'];
            if ($_POST['user'] == $user['user_type'] ) {
                // Redirect to dashboard for admin
                header("Location: dashboard.php");
                exit();
            } elseif ($_POST['user'] == $user['user_type']) {
                // Redirect to dashboard for user and pass event_id
                header("Location: dashboard.php?event_id=" . $user['event_id']);
                exit();
            } else {
                // Invalid user type for session username
                echo "Invalid user type";
            }
        } else {
            // Invalid username or password
            echo "Invalid username or password";
        }
        $stmt->close();
        $conn->close();
    }
}
?>


    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
<style>
     select {
        background-color: transparent; /* Set background color of select to transparent */
        width:100%;
        height: 50px;
        border-radius: 100px;
        color: #fff;
        padding-left:20px ;
    }

    /* Style for option elements */
    option {
        background-color: transparent; /* Set background color of options to transparent */
        width:100%;
        height: 50px;
        border-radius: 100px;
        color: black;
    }
</style>