<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Mostra Contagi</title>
</head>

<body>
    <h1>Elenco dei contagi</h1>
    <ul>
        <?php
        if (isset($_SESSION['contagi']) && !empty($_SESSION['contagi'])) {
            foreach ($_SESSION['contagi'] as $data => $contagi) {
                echo "<li>$data - $contagi</li>";
            }
        } else {
            echo "<li>Nessun dato di contagio disponibile.</li>";
        }
        ?>
    </ul>
</body>

</html>