<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['data'])) {
        $data = $_POST['data'];

        if (isset($_SESSION['contagi'][$data])) {
            unset($_SESSION['contagi'][$data]);
            echo "Dati di contagio per la data $data cancellati.";
        } else {
            echo "Nessun dato di contagio trovato per la data $data.";
        }
    } else {
        echo "La variabile 'data' deve essere passata in POST.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Cancella Contagi</title>
</head>

<body>
    <form method="post" action="cancella_contagi.php">
        <label for="data">Data (mm-dd-aaaa):</label>
        <input type="text" id="data" name="data" required>
        <button type="submit">Cancella</button>
    </form>
</body>

</html>