<?php
include 'db.php';
session_start();

// prevent double submit
if(isset($_SESSION['saved'])){
    header("Location: report.php");
    exit();
}

$_SESSION['saved'] = true;

$names = $_POST['name'];
$batch = $_POST['batch'];
$mobile = $_POST['mobile'];
$time = $_POST['time'];
$gender = $_POST['gender'];
$session_id = $_POST['session_id'];

for($i=0; $i<count($names); $i++){

    // check duplicate
    $check = pg_query($conn, "
        SELECT * FROM attendance 
        WHERE name='$names[$i]' 
        AND mobile='$mobile[$i]' 
        AND session_id='$session_id'
    ");

    if(pg_num_rows($check) == 0){

        $query = "INSERT INTO attendance(name,batch,mobile,attendance_time,gender,session_id)
        VALUES('$names[$i]','$batch[$i]','$mobile[$i]','$time[$i]','$gender[$i]','$session_id')";

        pg_query($conn, $query);
    }
}

// redirect
header("Location: report.php");
exit();
?>