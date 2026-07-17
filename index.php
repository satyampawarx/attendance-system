<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#6a11cb">
    <link rel="manifest" href="manifest.json">
    <link rel="apple-touch-icon" href="icon-192.png">
    <title>Attendance System</title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>

<body>

<h2>Session Information</h2>

<form action="save_session.php" method="post">

<label>Day</label>
<input type="text" name="day" required><br><br>

<label>Time</label>
<input type="text" name="time" required><br><br>

<label>Session Name</label>
<input type="text" name="session_name" required><br><br>

<label>Date</label>
<input type="date" name="session_date" required><br><br>

<label>Satyacharya</label>
<input type="text" name="satyacharya"><br><br>

<label>Satyapramukh</label>
<input type="text" name="satyapramukh"><br><br>

<input type="submit" value="Next">

</form>

<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js').catch(function(){});
}
</script>

</body>
</html>
