<?php
include 'db.php';
session_start();

$session_id = $_SESSION['session_id'];

$s = pg_query($conn, "SELECT * FROM session_info WHERE id='$session_id'");
$session = pg_fetch_assoc($s);

$result = pg_query($conn, "SELECT * FROM attendance WHERE session_id='$session_id'");

// Aajchi date fetch karun file name madhe add keli
$today_date = date("d-m-Y");
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Attendance_Report_{$today_date}.xls");

echo "\xEF\xBB\xBF"; // UTF-8 Hindi support

echo "<table border='1'>";

// Title
echo "<tr>
<td colspan='5' align='center' style='font-size:18px; font-weight:bold; background:#d9d9d9'>
प्रवचन / सत्र उपस्थिति रजिस्टर
</td>
</tr>";

// Session Info
echo "<tr>
<td style='background:#c6d9f1'><b>दिन</b></td>
<td>".$session['day']."</td>
<td style='background:#c6d9f1'><b>समय</b></td>
<td colspan='2'>".$session['time']."</td>
</tr>";

echo "<tr>
<td style='background:#c6d9f1'><b>प्रवचन / सत्र</b></td>
<td>".$session['session_name']."</td>
<td style='background:#c6d9f1'><b>तारीख</b></td>
<td colspan='2'>".date("d-m-Y", strtotime($session['session_date']))."</td>
</tr>";

echo "<tr>
<td style='background:#c6d9f1'><b>सत्याचार्य</b></td>
<td>".$session['satyacharya']."</td>
<td style='background:#c6d9f1'><b>सत्यप्रबंधक</b></td>
<td colspan='2'>".$session['satyapramukh']."</td>
</tr>";

echo "<tr></tr>";

// Table Header
echo "<tr style='background:#b8cce4'>
<th>अ. क्र.</th>
<th>खोजी का नाम</th>
<th>बैच</th>
<th>मोबाइल नं.</th>
<th>उपस्थिति समय</th>
</tr>";

$i=1;
$male=0;
$female=0;

while($row = pg_fetch_assoc($result)){
    if($row['gender']=='Male') $male++;
    else $female++;

    echo "<tr>
    <td>".$i++."</td>
    <td>".$row['name']."</td>
    <td>".$row['batch']."</td>
    <td style='mso-number-format:\"\\@\"'>".$row['mobile']."</td>
    <td>".$row['attendance_time']."</td>
    </tr>";
}

echo "<tr></tr>";

// Counts
echo "<tr>
<td colspan='2'><b>जेन्ट्स खोजी</b></td>
<td>".$male."</td>
<td colspan='2'></td>
</tr>";

echo "<tr>
<td colspan='2'><b>लेडीज खोजी</b></td>
<td>".$female."</td>
<td colspan='2'></td>
</tr>";

echo "<tr>
<td colspan='2'><b>कुल खोजी</b></td>
<td>".($male+$female)."</td>
<td colspan='2'></td>
</tr>";

echo "</table>";
?>