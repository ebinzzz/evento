<!DOCTYPE html>
<html>
<head>
    <title>Participants List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #e6e6e6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .print-button {
            margin-top: 20px;
            display: block;
            width: 100px;
            height: 50px;
            border-radius: 10px;
            font-size: medium;
            background-color: #4CAF50;
        }
        .print-button:hover {
            background-color: red;

        }

        @media print {
            .print-button {
                display: none;
            }

            .container {
                box-shadow: none;
            }
        }
        .test{
            text-align: center;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">

<?php
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

    if (isset($_POST['event']) && !empty($_POST['event'])) {
        $event_id = $_POST['event'];

        // Fetch event title
        $stmt1 = $pdo->prepare('SELECT *  FROM events WHERE event_id = :event_id');
        $stmt1->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt1->execute();

        $event = $stmt1->fetch();
        $event_title = $event['event_title'];

        // Fetch participants attending the selected event
        $stmt = $pdo->prepare('SELECT p_id, fullname, branch FROM participants WHERE event_id = :event_id AND attend = "present"');
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        $participants = $stmt->fetchAll();

        if (count($participants) > 0) {
            echo "<h2 class='test'>COLLEGE OF ENGINEERING CHERTHALA</h2>";
            echo "<h2 class='test'>Participants List For $event_title</h2>";
            echo '<table>';
            echo '<tr><th>ID</th><th>Name</th><th>Branch</th></tr>';

            foreach ($participants as $participant) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($participant['p_id']) . '</td>';
                echo '<td>' . htmlspecialchars($participant['fullname']) . '</td>';
                echo '<td>' . htmlspecialchars($participant['branch']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            $stmt2 = $pdo->prepare('SELECT staff, student FROM events WHERE event_id = :event_id');
$stmt2->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt2->execute();

$row1 = $stmt2->fetch();

echo '<h2 class="test"></h2>';
echo '<p>The attendance sheet has been meticulously prepared through rigorous verification by the coordinators. As such, additional verification is unnecessary. For further information, please contact ';
echo'Staff Coordinator:->';
echo isset($row1['staff']) ? htmlspecialchars($row1['staff']) : 'N/A';
echo ' or ';
echo'Student Coordinator:-> ';
echo isset($row1['student']) ? htmlspecialchars($row1['student']) : 'N/A';
echo '.</p>';

            echo '<button class="print-button" onclick="window.print()">Print List</button>';
        } else {
            echo '<p>No participants found for the selected event.</p>';
        }

        // Fetch coordinators' information
       

    } else {
        echo '<p>No event selected.</p>';
    }

} catch (\PDOException $e) {
    echo '<p>Error fetching participants: ' . htmlspecialchars($e->getMessage()) . '</p>';
}

?>

</div>



</body>
</html>
