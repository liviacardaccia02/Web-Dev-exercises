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

    function getEntries()
    {
        $query = "SELECT * FROM dati";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}