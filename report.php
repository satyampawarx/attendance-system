<?php
include 'db.php';
session_start();

$session_id = $_SESSION['session_id'] ?? '';

if ($session_id === '') {
    die("Session mahiti sapadli nahi. Please Session Information page varun suru kara.");
}

// session info -- parameterized
$s = pg_query_params($conn, "SELECT * FROM session_info WHERE id=$1", [$session_id]);
$session = pg_fetch_assoc($s);

if (!$session) {
    die("Session sapadle nahi.");
}

// attendance -- parameterized
$result = pg_query_params($conn, "SELECT * FROM attendance WHERE session_id=$1", [$session_id]);

$male = 0;
$female = 0;

function h($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#6a11cb">
<link rel="manifest" href="manifest.json">
<link rel="apple-touch-icon" href="icon-192.png">

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
body {
    background-color: #f4f7fb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.report-box {
    width: 94%;
    max-width: 900px;
    margin: 20px auto;
    border: 2px solid #333;
    padding: 12px;
    background: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

table {
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    table-layout: fixed;
    font-size: 14px;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Column widths colgroup madhe dilya ahet (khali table madhe) */

@media only screen and (max-width: 600px) {
    #reportContent {
        padding: 8px;
    }
    th, td {
        font-size: 10.5px;
        padding: 4px 3px;
    }
    .title-row {
        font-size: 14px;
    }
}
.title-row {
    background: #d9d9d9;
    font-size: 18px;
    font-weight: bold;
}

.header-blue {
    background: #b8cce4;
    font-weight: bold;
}

.info-cell {
    background: #ddebf7;
    font-weight: bold;
}

/* Action Buttons Styling */
.action-buttons {
    text-align: center;
    margin-bottom: 30px;
}

.btn-action {
    padding: 10px 15px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    transition: 0.2s;
}

.btn-print { background-color: #607d8b; }
.btn-excel { background-color: #4caf50; }
.btn-image { background-color: #ff9800; }

.btn-action:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

@media print {
    .action-buttons {
        display: none;
    }
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: white;
    }
    .report-box {
        border: none;
        box-shadow: none;
        width: 100%;
    }
    @page {
        size: A4;
        margin: 10mm;
    }
}
</style>

</head>
<body>

<div class="report-box" id="reportContent">

    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 40px; font-weight: bold; color: #ff5722; letter-spacing: 2px;">स्वानंद</div>
        <div style="font-size: 20px; font-weight: 600; color: #555; margin-top: 5px;">तेजस्थान</div>
    </div>

    <table border="1" width="100%">
    <colgroup>
        <col style="width:10%">
        <col style="width:28%">
        <col style="width:15%">
        <col style="width:22%">
        <col style="width:25%">
    </colgroup>

<tr class="title-row">
<th colspan="5">प्रवचन / सत्र उपस्थिति रजिस्टर</th>
</tr>

<tr>
<td class="info-cell">दिन</td>
<td><?php echo h($session['day']); ?></td>
<td class="info-cell">समय</td>
<td colspan="3"><?php echo h($session['time']); ?></td>
</tr>

<tr>
<td class="info-cell">प्रवचन / सत्र</td>
<td><?php echo h($session['session_name']); ?></td>
<td class="info-cell">तारीख</td>
<td colspan="3"><?php echo h(date("d-m-Y", strtotime($session['session_date']))); ?></td>
</tr>

<tr>
<td class="info-cell">सत्याचार्य</td>
<td><?php echo h($session['satyacharya']); ?></td>
<td class="info-cell">सत्यप्रबंधक</td>
<td colspan="3"><?php echo h($session['satyapramukh']); ?></td>
</tr>

<tr>
<td colspan="5"></td>
</tr>

<tr class="header-blue attendee-th">
<th>अ. क्र.</th>
<th>खोजी का नाम</th>
<th>बैच</th>
<th>मोबाइल नं.</th>
<th>उपस्थिति समय</th>
</tr>

<?php
$i = 1;
while ($row = pg_fetch_assoc($result)) {
    if ($row['gender'] == 'Male') $male++;
    else $female++;

    echo "<tr class='attendee-row'>
    <td>" . $i++ . "</td>
    <td>" . h($row['name']) . "</td>
    <td>" . h($row['batch']) . "</td>
    <td>" . h($row['mobile']) . "</td>
    <td>" . h($row['attendance_time']) . "</td>
    </tr>";
}
?>

<tr>
<td colspan="2"><b>जेन्ट्स खोजी</b></td>
<td><?php echo $male; ?></td>
<td colspan="3"></td>
</tr>

<tr>
<td colspan="2"><b>लेडीज खोजी</b></td>
<td><?php echo $female; ?></td>
<td colspan="3"></td>
</tr>

<tr>
<td colspan="2"><b>कुल खोजी</b></td>
<td><?php echo ($male + $female); ?></td>
<td colspan="2"></td>
</tr>

</table>

</div>

<div class="action-buttons">
    <button class="btn-action btn-print" onclick="window.print()">🖨️ Print Report</button>

    <a href="export_excel.php" style="text-decoration: none;">
        <button class="btn-action btn-excel">📊 Download Excel</button>
    </a>

    <button class="btn-action btn-image" onclick="downloadAsImage()">📸 Download as Image</button>
</div>

<script>
function downloadAsImage() {
    var reportBox = document.getElementById("reportContent");

    html2canvas(reportBox, {scale: 2, backgroundColor: "#ffffff"}).then(function(canvas) {
        var link = document.createElement('a');

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var formattedDate = dd + '-' + mm + '-' + yyyy;

        link.download = 'Attendance_Report_' + formattedDate + '.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js').catch(function(){});
}
</script>

</body>
</html>
