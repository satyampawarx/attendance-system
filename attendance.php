<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<script src="js/script.js"></script>
</head>

<body onload="addRow()">

<h2>Attendance Entry</h2>

<form action="save_attendance.php" method="post">

<input type="hidden" name="session_id" value="<?php echo $_SESSION['session_id']; ?>">
<div style="overflow-x:auto;">
<table id="table">
<tr>
<th>Name</th>
<th>Batch</th>
<th>Mobile</th>
<th>Time</th>
<th>Gender</th>
</tr>
</table>
</div>
<br>
<button type="button" onclick="addRow()">Add Row</button>

<h3>
Gents: <span id="maleCount">0</span> |
Ladies: <span id="femaleCount">0</span> |
Total: <span id="totalCount">0</span>
</h3>

<br>
<input type="submit" value="Save Attendance" onclick="disableBtn(this)">

</form>

</body>
</html>