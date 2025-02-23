<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event and Participant Selector</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label, select, input {
            display: block;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="process.php" method="post">
                    <h2 class="text-center mb-4">Event and Participant Selector</h2>
                    <label for="event">Select Event:</label>
                    <select name="event" id="event" class="form-control" required>
                        <?php
                        // Retrieve database credentials from environment variables or a config file
                        $host = getenv('DB_HOST') ?: 'localhost';
                        $db   = getenv('DB_NAME') ?: 'events';
                        $user = getenv('DB_USER') ?: 'root';
                        $pass = getenv('DB_PASS') ?: '';
                        $charset = 'utf8mb4';

                        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                        $options = [
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES   => false,
                        ];

                        try {
                            $pdo = new PDO($dsn, $user, $pass, $options);
                            $stmt = $pdo->query('SELECT event_id, event_title FROM events');

                            while ($row = $stmt->fetch()) {
                                echo '<option value="' . $row['event_id'] . '">' . $row['event_title'] . '</option>';
                            }
                        } catch (\PDOException $e) {
                            echo '<option value="">Error fetching events</option>';
                        }
                        ?>
                    </select>

                    <input type="submit" value="Submit" class="btn btn-primary mt-3">
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
