<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<a href="http://localhost/tech/index.php" class="btn btn-primary"><h3>Go Back</h3></a>
    <div class="container">

        <h2>OTP Verification</h2>
        
        <!-- Email submission form -->
        <form id="emailForm" action="verify.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Enter your registred email">
            </div>
            <input type="submit" value="Send OTP">
        </form>

    </div>

</body>
</html>

<style>
    /* styles.css */
    a.btn.btn-primary h3 {
    color: white; /* Set text color to white */
    text-decoration: none; /* Remove underline */
    margin:20px;
}


body {
    font-family: Arial, sans-serif;
    background-color: grey;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 100px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(25, 2, 200, 0.1);
    box-shadow: #007BFF;
    text-shadow: #333;
}

h2 {
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

input[type="email"] {
    width: 95%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: green;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        margin: 50px 10px;
    }

    h2 {
        font-size: 24px;
    }
}

</style>