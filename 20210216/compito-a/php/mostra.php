<?php
require_once ("database.php");

$dbh = new DataBaseHelper("localhost", "root", "", "febbraio");

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostra</title>
</head>

<body>
    <h1>Database</h1>
    <div>
        <?php foreach ($dbh->getEntries() as $entry) {
            echo $entry["chiave"] . " ";
            echo $entry["valore"] . "</br>";
        }
        ?>
    </div>
    <h1>Cookie</h1>
    <div>
        <?php foreach ($_COOKIE as $key => $value) {
            if ($key != "PHPSESSID") {
                echo $key . " ";
                echo $value . "</br>";
            }
        }
        ?>
    </div>
</body>

</html>