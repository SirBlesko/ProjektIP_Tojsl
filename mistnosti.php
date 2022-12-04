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

<h1 class="h1">Seznam místností</h1>

<?php

$title = "Mistnosti";
require_once 'pripojeni.php';

$stmt = $pdo->query('SELECT room_id, name, no, phone FROM room ORDER BY no');

if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
}
else
{

    echo "<table class='table'>";
    echo "<tr><th>Název</th><th>Číslo</th><th>Telefon</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td><a href='mistnost.php?roomId={$row['room_id']}'>{$row['name']}</a></td>";
        echo "<td>{$row['no']}</td>";
        echo "<td>{$row['phone']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
unset($stmt);

?>

<a href="viewer.php" class="return">Zpět</a>

</body>
</html>
