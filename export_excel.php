<?php
include 'db.php';
session_start();

$session_id = $_SESSION['session_id'] ?? '';

if ($session_id === '') {
    die("Session mahiti sapadli nahi.");
}

$s = pg_query_params($conn, "SELECT * FROM session_info WHERE id=$1", [$session_id]);
$session = pg_fetch_assoc($s);

if (!$session) {
    die("Session sapadle nahi.");
}

$result = pg_query_params($conn, "SELECT * FROM attendance WHERE session_id=$1", [$session_id]);

function h($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

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
<td>" . h($session['day']) . "</td>
<td style='background:#c6d9f1'><b>समय</b></td>
<td colspan='2'>" . h($session['time']) . "</td>
</tr>";

echo "<tr>
<td style='background:#c6d9f1'><b>प्रवचन / सत्र</b></td>
<td>" . h($session['session_name']) . "</td>
<td style='background:#c6d9f1'><b>तारीख</b></td>
<td colspan='2'>" . h(date("d-m-Y", strtotime($session['session_date']))) . "</td>
</tr>";

echo "<tr>
<td style='background:#c6d9f1'><b>सत्याचार्य</b></td>
<td>" . h($session['satyacharya']) . "</td>
<td style='background:#c6d9f1'><b>सत्यप्रबंधक</b></td>
<td colspan='2'>" . h($session['satyapramukh']) . "</td>
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

$i = 1;
$male = 0;
$female = 0;

while ($row = pg_fetch_assoc($result)) {
    if ($row['gender'] == 'Male') $male++;
    else $female++;

    echo "<tr>
    <td>" . $i++ . "</td>
    <td>" . h($row['name']) . "</td>
    <td>" . h($row['batch']) . "</td>
    <td style='mso-number-format:\"\\@\"'>" . h($row['mobile']) . "</td>
    <td>" . h($row['attendance_time']) . "</td>
    </tr>";
}

echo "<tr></tr>";

// Counts
echo "<tr>
<td colspan='2'><b>जेन्ट्स खोजी</b></td>
<td>" . $male . "</td>
<td colspan='2'></td>
</tr>";

echo "<tr>
<td colspan='2'><b>लेडीज खोजी</b></td>
<td>" . $female . "</td>
<td colspan='2'></td>
</tr>";

echo "<tr>
<td colspan='2'><b>कुल खोजी</b></td>
<td>" . ($male + $female) . "</td>
<td colspan='2'></td>
</tr>";

echo "</table>";
?>
