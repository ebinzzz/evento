<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Coordinator Details</h2>
    <table>
        <tr>
            <th>Staff Name</th>
            <th>Staff Email</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Event</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "events";
        
        $conn = new mysqli($servername, $username, $password, $database);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Query to fetch staff coordinators along with events
        $query_staff = "SELECT s.staff_name AS staff_name, s.email AS staff_email, 
                        se.event_title AS event_title 
                        FROM staff s 
                        LEFT JOIN events se ON s.email = se.staff ";

        // Query to fetch student coordinators along with events
        $query_student = "SELECT st.student_name AS student_name, st.email AS student_email, 
                          se.event_title AS event_title 
                          FROM students st 
                          LEFT JOIN events se ON st.student_name = se.student ";

        $result_staff = mysqli_query($conn, $query_staff);
        $result_student = mysqli_query($conn, $query_student);

        // Combine and align staff and student details according to events
        while ($row_staff = mysqli_fetch_assoc($result_staff)) {
            echo "<tr>";
            echo "<td>" . $row_staff['staff_name'] . "</td>";
            echo "<td>" . $row_staff['staff_email'] . "</td>";
            echo "<td></td>"; // Empty column for student name
            echo "<td></td>"; // Empty column for student email
            echo "<td>" . ($row_staff['event_title'] ?? 'Not assigned') . "</td>";
            echo "</tr>";
        }

        while ($row_student = mysqli_fetch_assoc($result_student)) {
            echo "<tr>";
            echo "<td></td>"; // Empty column for staff name
            echo "<td></td>"; // Empty column for staff email
            echo "<td>" . $row_student['student_name'] . "</td>";
            echo "<td>" . $row_student['student_email'] . "</td>";
            echo "<td>" . ($row_student['event_title'] ?? 'Not assigned') . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
