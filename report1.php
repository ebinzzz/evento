<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Event Report</h1>
        <?php include 'generate_report.php'; ?>
  
</body>
</html>
<style>
  /* pdf_styles.css */
.event {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.event-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.event-details {
    margin-bottom: 10px;
}

.event-details p {
    margin: 5px 0;
}

.coordinator-label {
    font-weight: bold;
}

.coordinator-name {
    margin-left: 5px;
}


</style>