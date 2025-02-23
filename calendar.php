<?php
$host = 'localhost';
$db   = 'events';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class Calendar {
    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function fetchEventsFromDatabase($selectedDate) {
        global $conn;

        $sql = "SELECT event_title, date, color FROM events WHERE MONTH(date) = ? AND YEAR(date) = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $year = $this->active_year;
        $month = $this->active_month;

        $stmt->bind_param("ss", $month, $year);
        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            die("Get result failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        while ($event = $result->fetch_assoc()) {
            $this->add_event($event['event_title'], $event['date'], 1, $event['color'] ?? 'green');
        }
    }

    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function __toString() {
        $num_days = date('t', strtotime($this->active_year . '-' . $this->active_month));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_year . '-' . $this->active_month)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-1'));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '<div class="day_name">' . $day . '</div>';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '<div class="day_num ignore">' . ($num_days_last_month-$i+1) . '</div>';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == $this->active_day) {
                $selected = ' selected';
            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            foreach ($this->events as $event) {
                if (date('Y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) == date('Y-m-d', strtotime($event[1]))) {
                    $html .= '<div class="event' . $event[3] . '">' . $event[0] . '</div>';
                }
            }
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '<div class="day_num ignore">' . $i . '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$calendar = new Calendar($selectedDate);
$calendar->fetchEventsFromDatabase($selectedDate);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Calendar</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="calendar.css" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<a href="http://localhost/tech/index.php" class="btn btn-primary"><h3>Go Back</h3></a>
    <nav class="navtop">
        <div>
            <?php
            $prevMonth = date('Y-m-01', strtotime('-1 month', strtotime($selectedDate)));
            $nextMonth = date('Y-m-01', strtotime('+1 month', strtotime($selectedDate)));
            ?>
            <a href="?date=<?= $prevMonth ?>"><i class="fas fa-arrow-left"></i> Previous</a>
            <h1>Event Calendar</h1>
            <a href="?date=<?= $nextMonth ?>">Next <i class="fas fa-arrow-right"></i></a>
        </div>
    </nav>
    <div class="content home">
        <?= $calendar ?>
    </div>
</body>
</html>

<style>
    * {
    box-sizing: border-box;
    font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
    font-size: 16px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
body {
    background-color: #FFFFFF;
    margin: 0;
}
.navtop {
    background-color: #3b4656;
    height: 60px;
    width: 100%;
    border: 0;
}
.navtop div {
    display: flex;
    margin: 0 auto;
    width: 800px;
    height: 100%;
}
.navtop div h1, .navtop div a {
    display: inline-flex;
    align-items: center;
}
.navtop div h1 {
    flex: 1;
    font-size: 24px;
    padding: 0;
    margin: 0;
    color: #ebedee;
    font-weight: normal;
}
.navtop div a {
    padding: 0 20px;
    text-decoration: none;
    color: #c4c8cc;
    font-weight: bold;
}
.navtop div a i {
    padding: 2px 8px 0 0;
}
.navtop div a:hover {
    color: #ebedee;
}
.content {
    width: 800px;
    margin: 0 auto;
}
.content h2 {
    margin: 0;
    padding: 25px 0;
    font-size: 22px;
    border-bottom: 1px solid #ebebeb;
    color: #666666;
}
.calendar {
    display: flex;
    flex-flow: column;
}
.calendar .header .month-year {
    font-size: 20px;
    font-weight: bold;
    color: #636e73;
    padding: 20px 0;
}
.calendar .days {
    display: flex;
    flex-flow: wrap;
}
.calendar .days .day_name {
    width: calc(100% / 7);
    border-right: 1px solid #2c7aca;
    padding: 20px;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: bold;
    color: #818589;
    color: #fff;
    background-color: #448cd6;
}
.calendar .days .day_name:nth-child(7) {
    border: none;
}
.calendar .days .day_num {
    display: flex;
    flex-flow: column;
    width: calc(100% / 7);
    border-right: 1px solid #e6e9ea;
    border-bottom: 1px solid #e6e9ea;
    padding: 15px;
    font-weight: bold;
    color: #7c878d;
    cursor: pointer;
    min-height: 100px;
}
.calendar .days .day_num span {
    display: inline-flex;
    width: 30px;
    font-size: 14px;
}
.calendar .days .day_num .event {
    margin-top: 10px;
    font-weight: 500;
    font-size: 14px;
    padding: 3px 6px;
    border-radius: 4px;
    background-color: #f7c30d;
    color: #fff;
    word-wrap: break-word;
}
.calendar .days .day_num .event.green {
    background-color: #51ce57;
}
.calendar .days .day_num .event.blue {
    background-color: #518fce;
}
.calendar .days .day_num .event.red {
    background-color: #ce5151;
}
.calendar .days .day_num:nth-child(7n+1) {
    border-left: 1px solid #e6e9ea;
}
.calendar .days .day_num:hover {
    background-color: #fdfdfd;
}
.calendar .days .day_num.ignore {
    background-color: #fdfdfd;
    color: #ced2d4;
    cursor: inherit;
}
.calendar .days .day_num.selected {
    background-color: #f1f2f3;
    cursor: inherit;
}
</style>