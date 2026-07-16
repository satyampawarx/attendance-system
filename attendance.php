<?php 
// Errors screen var disnyasathi he don lines add kele ahet
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); 
include 'db.php'; 

$existing_names = [];
$existing_mobiles = [];
$existing_batches = [];
$session_time = ""; 

if (isset($conn) && $conn) {
    if (isset($_SESSION['session_id'])) {
        $sess_id = pg_escape_string($conn, $_SESSION['session_id']);
        $sess_query = pg_query($conn, "SELECT time FROM session_info WHERE id='$sess_id'");
        if ($sess_query && pg_num_rows($sess_query) > 0) {
            $sess_row = pg_fetch_assoc($sess_query);
            $session_time = $sess_row['time']; 
        }
    }

    $names_query = pg_query($conn, "
        SELECT DISTINCT TRIM(name) as clean_name 
        FROM attendance 
        WHERE name IS NOT NULL 
        AND TRIM(name) != '' 
        AND name ~ '^[a-zA-Z\s]+$' 
        ORDER BY clean_name ASC
    ");
    if ($names_query) { 
        while($row = pg_fetch_assoc($names_query)){ 
            $existing_names[] = $row['clean_name']; 
        } 
    }
    
    $mobiles_query = pg_query($conn, "SELECT DISTINCT TRIM(mobile) as clean_mobile FROM attendance WHERE mobile IS NOT NULL AND TRIM(mobile) != '' ORDER BY clean_mobile ASC");
    if ($mobiles_query) { while($row = pg_fetch_assoc($mobiles_query)){ $existing_mobiles[] = $row['clean_mobile']; } }
    
    $batches_query = pg_query($conn, "SELECT DISTINCT TRIM(batch) as clean_batch FROM attendance WHERE batch IS NOT NULL AND TRIM(batch) != '' ORDER BY clean_batch ASC");
    if ($batches_query) { while($row = pg_fetch_assoc($batches_query)){ $existing_batches[] = $row['clean_batch']; } }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    
    <script>
        var defaultSessionTime = "<?php echo htmlspecialchars($session_time, ENT_QUOTES, 'UTF-8'); ?>";
    </script>
    <script src="js/script.js"></script>
</head>

<body onload="addRow()">

<datalist id="khojiNames"><?php foreach($existing_names as $name): ?><option value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"></option><?php endforeach; ?></datalist>
<datalist id="khojiMobiles"><?php foreach($existing_mobiles as $mobile): ?><option value="<?php echo htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8'); ?>"></option><?php endforeach; ?></datalist>
<datalist id="khojiBatches"><?php foreach($existing_batches as $batch): ?><option value="<?php echo htmlspecialchars($batch, ENT_QUOTES, 'UTF-8'); ?>"></option><?php endforeach; ?></datalist>

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

<button type="button" class="btn-gradient" onclick="addRow()">+ Add New Row</button>

<h3 class="stats-box">
Gents: <span id="maleCount">0</span> |
Ladies: <span id="femaleCount">0</span> |
Total: <span id="totalCount">0</span>
</h3>

<input type="submit" class="btn-gradient" value="Save Attendance" onclick="disableBtn(this)">

</form>

</body>
</html>