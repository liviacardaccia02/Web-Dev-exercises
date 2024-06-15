<?php

class DataBaseHelper
{
    private $db;

    function __construct($localhost, $username, $password, $database)
    {
        $this->db = new mysqli($localhost, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Connection failed" . $this->db->connect_error);
        }
    }

    function insertCitizien($name, $surname, $code, $birth, $sex)
    {
        $query = "INSERT INTO cittadino (nome, cognome, codicefiscale, datanascita, sesso) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", $name, $surname, $code, $birth, $sex);

        return $stmt->execute();
    }

    function getCitiziens($id)
    {
        $query = "SELECT * FROM cittadino";
        if ($id != null) {
            $query .= "WHERE id = ?";
        }
        $stmt = $this->db->prepare($query);
        if ($id != null) {
            $stmt->bind_param("i", $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

$dbh = new DataBaseHelper("localhost", "root", "", "db_esami");

if (
    $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nome"])
    && isset($_POST["cognome"]) && isset($_POST["codicefiscale"])
    && isset($_POST["datanascita"]) && isset($_POST["sesso"])
) {
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $codicefiscale = $_POST["codicefiscale"];
    $datanascita = $_POST["datanascita"];
    $sesso = $_POST["sesso"];

    if (is_a($nome, "string") && is_a($cognome, "string")) {
        if (strlen($codicefiscale) == 16) {
            if (date("YYYY-MM-DD", strtotime($datanascita))) {
                if ($sesso == "M" || $sesso == "F" || $sesso == "A") {
                    if ($dbh->insertCitizien($nome, $cognome, $codicefiscale, $datanascita, $sesso)) {
                        echo "Inserimento avvenuto con successo";
                    } else {
                        echo "Errore durante l'inserimento";
                    }
                } else {
                    echo "Errore nel sesso inserito";
                }
            } else {
                echo "Errore nella data inserita";
            }
        } else {
            echo "Errore nel codice fiscale inserito";
        }
    } else {
        echo "Errore nei dati inseriti";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $citiziens = $dbh->getCitiziens($id);
    } else {
        $citiziens = $dbh->getCitiziens(null);
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cittadini</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th id="nome">Nome</th>
                <th id="cognome">Cognome</th>
                <th id="codicefiscale">Codice Fiscale</th>
                <th id="datanascita">Data di Nascita</th>
                <th id="sesso">Sesso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citiziens as $citizien): ?>
                <tr>
                    <td><?= $citizien["nome"] ?></td>
                    <td><?= $citizien["cognome"] ?></td>
                    <td><?= $citizien["codicefiscale"] ?></td>
                    <td><?= $citizien["datanascita"] ?></td>
                    <td><?= $citizien["sesso"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>