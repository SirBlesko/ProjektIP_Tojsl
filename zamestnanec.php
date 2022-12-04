
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail zaměstnance <?php echo $employee->no ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="employee">

<?php

$employeeId = filter_input(
    INPUT_GET,
    'employeeId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if (!$employeeId) {
    http_response_code(400);
    echo "<h1>Bad request</h1>";
    die;
}


$employeeId = filter_input(
    INPUT_GET,
    'employeeId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

require_once "pripojeni.php";

$query = "SELECT * FROM `employee` WHERE `employee_id`=:employeeId";

$stmt = $pdo->prepare($query);
$stmt->execute(['employeeId' => $employeeId]);

if ($stmt->rowCount() === 0)
{
    http_response_code(404);
    echo "<h1>Not found</h1>";
    die;
}

$employee = $stmt->fetch();

echo "<h1>Zaměstnanec: {$employee['name']}</h1>";

echo "<div class='employee__list'>";

echo "<div class='detail-title'>Jméno:";
echo "<div class='value'>{$employee['name']}</div>";
echo "</div>";
echo "<div class='detail-title'>Příjmení: ";
echo "<div class='value'>{$employee['surname']}</div>";
echo "</div>";
echo "<div class='detail-title'>Pozice: ";
echo "<div class='value'>{$employee['job']}</div>";
echo "</div>";
echo "<div class='detail-title'>Mzda: ";
echo "<div class='value'>{$employee['wage']}</div>";
echo "</div>";
echo "<div class='detail-title'>Místnost: ";
echo "<div class='value'>{$employee['room']}</div>";
echo "</div>";
echo "<div class='detail-title'>Klíče:</div>";

$stmt2 =$pdo->query("SELECT * FROM room,ip_3.key WHERE ip_3.key.employee=$employeeId AND room.room_id=ip_3.key.room");
while ($row = $stmt2->fetch()) {
    echo "<div class='values'> <a href='mistnost.php?roomId={$row['room_id']}' > {$row['name']} </a> </div>";
}

echo "</div>";

echo "<div class='return'><a href='mistnosti.php'>Zpět na místnosti</a></div>";
?>

</section>

</body>
</html>