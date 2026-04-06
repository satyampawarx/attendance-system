<?php
include 'db.php';
session_start();

$day = $_POST['day'];
$time = $_POST['time'];
$session_name = $_POST['session_name'];
$date = $_POST['session_date'];
$satyacharya = $_POST['satyacharya'];
$satyapramukh = $_POST['satyapramukh'];

$query = "INSERT INTO session_info(day,time,session_name,session_date,satyacharya,satyapramukh)
VALUES('$day','$time','$session_name','$date','$satyacharya','$satyapramukh')";

pg_query($conn, $query);

// last inserted id
$res = pg_query($conn, "SELECT currval(pg_get_serial_sequence('session_info','id'))");
$row = pg_fetch_assoc($res);

$_SESSION['session_id'] = $row['currval'];

header("Location: attendance.php");
?>