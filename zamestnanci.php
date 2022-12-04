<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 class="h1">Seznam zaměstnanců</h1>

<?php

$title = "Zamestnanci";
require_once 'pripojeni.php';


$stmt = $pdo->query('SELECT employee_id, employee.name, surname, job, wage, room, phone, room.name as room_name 
FROM employee, room WHERE room.room_id = employee.room ');

if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
}
else
{

    echo "<table class='table'>";
    echo "<tr><th>Jméno</th><th>Místnost</th><th>Telefon</th><th>Pozice</th></tr>";
    while ($row = $stmt ->fetch()) {
        echo "<tr>";
        echo "<td><a href='zamestnanec.php?employeeId={$row['employee_id']}'> {$row['name']} {$row['surname']} </a></td>";
        echo "<td>{$row['room_name']}</td>";
        echo "<td>{$row['phone']}</td>";
        echo "<td>{$row['job']}</td>";
        echo "</tr>";

    }
    echo "</table>";
}
unset($stmt);

?>

<a href="viewer.php">Zpět</a>

</body>
</html>
