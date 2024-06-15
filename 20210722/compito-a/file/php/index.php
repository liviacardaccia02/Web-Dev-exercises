<?php

class DataBaseHelper
{
    private $db;

    function __construct($hostname, $username, $password, $database)
    {
        $this->db = new mysqli($hostname, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Connection failed" . $this->db->connect_error);
        }
    }

    function getCount()
    {
        $query = "SELECT * FROM estrazione";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC));
    }

    function isAlreadyPresent($number)
    {
        $query = "SELECT * FROM estrazione WHERE numero = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $number);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    function insertNumber($number)
    {
        $query = "INSERT INTO estrazione (numero) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $number);
        return $stmt->execute();
    }

    function clear()
    {
        $query = "DELETE FROM estrazione";
        $stmt = $this->db->prepare($query);
        return $stmt->execute();
    }
}

$dbh = new DataBaseHelper("localhost", "root", "", "lotto");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action == "extract") {
        $number = rand(1, 90);
        if ($dbh->getCount() < 5 && !$dbh->isAlreadyPresent($number)) {
            if ($dbh->insertNumber($number)) {
                $message = json_encode(["success" => "Numero inserito correttamente"]);
            } else {
                $message = json_encode(["error" => "Errore nell'inserimento del numero"]);
            }
        } else {
            $message = json_encode(["error" => "Non è possibile inserire altri numeri"]);
        }
    } else if ($action == "new") {
        if ($dbh->clear()) {
            $message = json_encode(["success" => "Partita iniziata"]);
        } else {
            $message = json_encode(["error" => "Errore nella creazione della partita"]);
        }
    } else if ($action == "check") {
        if (isset($_GET["sequence"])) {
            $sequence = $_GET["sequence"];
            $numbers = explode("-", $sequence);

            foreach ($numbers as $number) {
                if (!$dbh->isAlreadyPresent($number)) {
                    $message = json_encode(["error" => "Hai perso"]);
                    break;
                } else {
                    $message = json_encode(["success" => "Hai vinto"]);
                }
            }
        }
    }
}
echo $message;
?>