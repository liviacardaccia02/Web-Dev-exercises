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
        <?php
        echo $_POST["chiave"];
        echo $_POST["valore"];
        ?>
    </div>
    <h1>Cookie</h1>
    <div>
        <?php
        echo $chiave["chiave"];
        echo $valore["valore"];
        ?>
    </div>
</body>

</html>