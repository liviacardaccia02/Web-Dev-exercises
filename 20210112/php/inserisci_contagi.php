<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['data']) && isset($_POST['contagi'])) {
        $data = $_POST['data'];
        $contagi = $_POST['contagi'];

        if (preg_match('/^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])-\d{4}$/', $data)) {
            list($month, $day, $year) = explode('-', $data);

            if (checkdate($month, $day, $year)) {
                if (!isset($_SESSION['contagi'])) {
                    $_SESSION['contagi'] = [];
                }

                if (isset($_SESSION['contagi'][$data])) {
                    $_SESSION['contagi'][$data] = $contagi;
                    echo "Numero di contagi aggiornato per la data $data.";
                } else {
                    $_SESSION['contagi'][$data] = $contagi;
                    echo "Numero di contagi inserito per la data $data.";
                }
            } else {
                echo "La data non è valida.";
            }
        } else {
            echo "Il formato della data non è valido. Deve essere mm-dd-aaaa.";
        }
    } else {
        echo "Le variabili 'data' e 'contagi' devono essere passate in POST.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Inserisci Contagi</title>
</head>

<body>
    <form method="post" action="inserisci_contagi.php">
        <label for="data">Data (mm-dd-aaaa):</label>
        <input type="text" id="data" name="data" required>
        <label for="contagi">Numero di contagi:</label>
        <input type="number" id="contagi" name="contagi" required>
        <button type="submit">Inserisci</button>
    </form>
</body>

</html>