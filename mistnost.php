
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail místnosti <?php echo $room->no ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="room">

<?php

$roomId = filter_input(
    INPUT_GET,
    'roomId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if (!$roomId) {
    http_response_code(400);
    echo "<h1>Bad request</h1>";
    die;
}


require_once "pripojeni.php";

$query = "SELECT * FROM `room` WHERE `room_id`=:roomId";

$stmt = $pdo->prepare($query);
$stmt->execute(['roomId' => $roomId]);

if ($stmt->rowCount() === 0)
{
    http_response_code(404);
    echo "<h1>Not found</h1>";
    die;
}

$room = $stmt->fetch();

$query2 = "SELECT * FROM `employee` WHERE `room`=:roomId";
$stmt2 = $pdo->prepare($query2);
$stmt2->execute(['roomId' => $roomId]);

echo "<h1>Místnost: {$room['name']}</h1>";

echo "<div class='room__list'>";

echo "<div class='detail-title'>Číslo:";
echo "<div class='value'>{$room['no']}</div>";
echo "</div>";
echo "<div class='detail-title'>Název:";
echo "<div class='value'>{$room['name']}</div>";
echo "</div>";
echo "<div class='detail-title'>Tel:";
echo "<div class='value'>{$room['phone']}</div>";
echo "</div>";
echo "<div class='detail-title'>Lidé:</div>";
while ($row = $stmt2->fetch()) {
    echo "<div class='values'><a href='zamestnanec.php?employeeId={$row['employee_id']}'> {$row['name']} {$row['surname']} </a></div>";
}

echo "<div class='detail-title'>Průměrná mzda: </div>";
$query3 = "SELECT avg(wage) as avarage_wage FROM `employee` WHERE `room`=:roomId";
$avg = $pdo->prepare($query3);
$avg->execute(['roomId' => $roomId]);
$avg2 = $avg->fetch();
echo "<div class='values'>{$avg2['avarage_wage']}</div>";

echo "<div class='detail-title'>Klíče:</div>";
$stmtKeys = $pdo->query("SELECT * FROM employee, ip_3.key WHERE ip_3.key.room=$roomId AND employee.employee_id = ip_3.key.employee");

while ($row = $stmtKeys->fetch()) {
    echo "<div class='values'><a href='zamestnanec.php?employeeId={$row['employee_id']}' > {$row['name']} {$row['surname']} </a> </div>";
}

echo "</div>";

echo "<div class='return'><a href='mistnosti.php'>Zpět na místnosti</a></div>";
?>

</section>


</body>
</html>