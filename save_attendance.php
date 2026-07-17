<?php
include 'db.php';
session_start();

$session_id = $_POST['session_id'] ?? '';

if ($session_id === '' || !isset($_SESSION['session_id']) || $_SESSION['session_id'] != $session_id) {
    die("Invalid or expired session. Please start again from Session Information page.");
}

// prevent double submit -- per session_id, so navin session sathi block hot nahi
if (isset($_SESSION['saved_' . $session_id])) {
    header("Location: report.php");
    exit();
}

$names  = $_POST['name']   ?? [];
$batch  = $_POST['batch']  ?? [];
$mobile = $_POST['mobile'] ?? [];
$time   = $_POST['time']   ?? [];
$gender = $_POST['gender'] ?? [];

for ($i = 0; $i < count($names); $i++) {

    $name_val   = trim($names[$i] ?? '');
    $batch_val  = trim($batch[$i] ?? '');
    $mobile_val = trim($mobile[$i] ?? '');
    $time_val   = trim($time[$i] ?? '');
    $gender_val = trim($gender[$i] ?? '');

    if ($name_val === '') {
        continue; // naav nasel tar row skip
    }

    // duplicate check -- parameterized
    $check = pg_query_params($conn, "
        SELECT id FROM attendance
        WHERE name = $1 AND mobile = $2 AND session_id = $3
    ", [$name_val, $mobile_val, $session_id]);

    if ($check && pg_num_rows($check) == 0) {
        pg_query_params($conn, "
            INSERT INTO attendance(name,batch,mobile,attendance_time,gender,session_id)
            VALUES($1,$2,$3,$4,$5,$6)
        ", [$name_val, $batch_val, $mobile_val, $time_val, $gender_val, $session_id]);
    }
}

$_SESSION['saved_' . $session_id] = true;

header("Location: report.php");
exit();
?>
