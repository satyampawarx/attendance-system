<?php 
session_start(); 
include 'db.php'; // Online database file inject keli

// Safe data fetch query array handling sobat
$existing_names = [];
if (isset($conn) && $conn) {
    $names_query = pg_query($conn, "SELECT DISTINCT name FROM attendance WHERE name IS NOT NULL AND name != '' ORDER BY name ASC");
    if ($names_query) {
        while($row = pg_fetch_assoc($names_query)){
            $existing_names[] = $row['name'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>

<body onload="addRow()">

<datalist id="khojiNames">
    <?php foreach($existing_names as $name): ?>
        <option value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"></option>
    <?php endforeach; ?>
</datalist>

<h2>Attendance Entry</h2>

<form action="save_attendance.php" method="post">

<input type="hidden" name="session_id" value="<?php echo isset($_SESSION['session_id']) ? $_SESSION['session_id'] : ''; ?>">
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