<?php
include 'db.php';
session_start();

$day            = trim($_POST['day'] ?? '');
$time           = trim($_POST['time'] ?? '');
$session_name   = trim($_POST['session_name'] ?? '');
$date           = trim($_POST['session_date'] ?? '');
$satyacharya    = trim($_POST['satyacharya'] ?? '');
$satyapramukh   = trim($_POST['satyapramukh'] ?? '');

$query = "INSERT INTO session_info(day,time,session_name,session_date,satyacharya,satyapramukh)
VALUES($1,$2,$3,$4,$5,$6)";

$result = pg_query_params($conn, $query, [
    $day, $time, $session_name, $date, $satyacharya, $satyapramukh
]);

if (!$result) {
    die("Session save karayla problem ala. Please try again.");
}

// last inserted id
$res = pg_query($conn, "SELECT currval(pg_get_serial_sequence('session_info','id'))");
$row = pg_fetch_assoc($res);

// naya session sathi purvicha 'saved' flag reset kara, nahitar attendance save honar nahi
unset($_SESSION['saved']);

$_SESSION['session_id'] = $row['currval'];

header("Location: attendance.php");
exit();
?>
