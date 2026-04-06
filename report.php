<?php
include 'db.php';
session_start();

$session_id = $_SESSION['session_id'];

// session info
$s = pg_query($conn, "SELECT * FROM session_info WHERE id='$session_id'");
$session = pg_fetch_assoc($s);

// attendance
$result = pg_query($conn, "SELECT * FROM attendance WHERE session_id='$session_id'");

$male = 0;
$female = 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">

<style>
.report-box{
    width: 90%;
    margin: auto;
    border: 3px solid black;
    padding: 12px;
    background: white;
}

@media print {

    button {
        display: none;
    }

    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    th, td {
        border: 1px solid black;
        padding: 6px;
        text-align: center;
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

    @page {
        size: A4;
        margin: 10mm;
    }
}
</style>

</head>
<body>

<div class="report-box">

<table border="1" width="100%">

<tr class="title-row">
<th colspan="5">प्रवचन / सत्र उपस्थिति रजिस्टर</th>
</tr>

<tr>
<td class="info-cell">दिन</td>
<td><?php echo $session['day']; ?></td>
<td class="info-cell">समय</td>
<td colspan="3"><?php echo $session['time']; ?></td>
</tr>

<tr>
<td class="info-cell">प्रवचन / सत्र</td>
<td><?php echo $session['session_name']; ?></td>
<td class="info-cell">तारीख</td>
<td colspan="3"><?php echo $session['session_date']; ?></td>
</tr>

<tr>
<td class="info-cell">सत्याचार्य</td>
<td><?php echo $session['satyacharya']; ?></td>
<td class="info-cell">सत्यप्रबंधक</td>
<td colspan="3"><?php echo $session['satyapramukh']; ?></td>
</tr>

<tr>
<td colspan="5"></td>
</tr>

<tr class="header-blue">
<th>अ. क्र.</th>
<th>खोजी का नाम</th>
<th>बैच</th>
<th>मोबाइल नं.</th>
<th>उपस्थिति समय</th>
</tr>

<?php
$i=1;
while($row = pg_fetch_assoc($result)){
    if($row['gender'] == 'Male') $male++;
    else $female++;

    echo "<tr>
    <td>".$i++."</td>
    <td>".$row['name']."</td>
    <td>".$row['batch']."</td>
    <td>".$row['mobile']."</td>
    <td>".$row['attendance_time']."</td>
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
<td><?php echo ($male+$female); ?></td>
<td colspan="2"></td>
</tr>

</table>

</div>

<br>
<button onclick="window.print()">Print Report</button>
<a href="export_excel.php">
    <button>Download Excel</button>
</a>
</body>
</html>