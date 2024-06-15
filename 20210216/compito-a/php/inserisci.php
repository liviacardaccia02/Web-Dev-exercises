<?php

class DataBaseHelper
{
    private $db;

    function __construct($hostname, $username, $password, $database)
    {
        $this->db = new mysqli($hostname, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Conncetion failed" . $this->db->connect_error);
        }
    }

    function insertValue($chiave, $valore)
    {
        $query = "INSERT INTO dati (chiave, valore) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $chiave, $valore);

        return $stmt->execute();
    }

    function isAlreadyPresent($chiave, $valore)
    {
        $query = "SELECT * FROM dati WHERE chiave = ? AND valore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $chiave, $valore);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

}

$dbh = new DataBaseHelper("localhost", "root", "", "febbraio");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["chiave"]) && isset($_POST["valore"]) && isset($_POST["metodo"])) {
    $chiave = $_POST["chiave"];
    $valore = $_POST["valore"];
    $metodo = $_POST["metodo"];
    if ($metodo == "cookie") {
        setcookie("chiave", $chiave);
        setcookie("valore", $valore);
    } else if ($metodo == "db") {
        if (!$dbh->isAlreadyPresent($chiave, $valore)) {
            $message = $dbh->insertValue($chiave, $valore) ? json_encode(["succes" => "Key inserted correctly"]) : json_encode(["error" => "Could not insert key"]);
        } else {
            $message = json_encode(["succes" => "Already up to date"]);
        }
    } else {
        $message = json_encode(["error" => "Wrong method"]);
    }
} else {
    $message = json_encode(["error" => "Parameters empty"]);
}
?>