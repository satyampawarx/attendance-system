<?php
include 'db.php';
session_start();

$names = $_POST['name'];
$batch = $_POST['batch'];
$mobile = $_POST['mobile'];
$time = $_POST['time'];
$gender = $_POST['gender'];
$session_id = $_POST['session_id'];

for($i=0; $i<count($names); $i++){
    $query = "INSERT INTO attendance(name,batch,mobile,attendance_time,gender,session_id)
    VALUES('$names[$i]','$batch[$i]','$mobile[$i]','$time[$i]','$gender[$i]','$session_id')";
    pg_query($conn, $query);
}

// Redirect directly to report
header("Location: report.php");
exit();
?>