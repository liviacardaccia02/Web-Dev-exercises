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

    function getElementById($id)
    {
        $query = "SELECT * FROM dati WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
class DbOP
{
    private $db;
    function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "febbraio");
        if ($this->db->connect_error) {
            die("Connection failed" . $this->db->connect_error);
        }
    }


    function getElements($id)
    {
        $query = "SELECT * FROM dati";
        if ($id != null) {
            $query .= " WHERE id = ?";
        }
        $stmt = $this->db->prepare($query);
        if ($id != null) {
            $stmt->bind_param("i", $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function verify_input()
    {
        if (isset($_GET["mode"])) {
            if ($_GET["mode"] == "html" || $_GET["mode"] == "json") {
                if (isset($_GET["id"])) {
                    $result = $this->getElements($_GET["id"]);
                } else {
                    $result = $this->getElements(null);
                }
                return count($result) > 0;
            }
        }
        return false;
    }

    function select_row($id)
    {
        return $this->getElements($id);
    }

    function print_html($data)
    {
        require_once ("print.php");
    }

    function print_json($data)
    {
        echo json_encode($data);
    }
}

$dbOp = new DbOP();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($dbOp->verify_input()) {
        $data = $dbOp->select_row(isset($_GET["id"]) ? $_GET["id"] : null);
        if ($_GET["mode"] == "html") {
            $dbOp->print_html($data);
        } else if ($_GET["mode"] == "json") {
            $dbOp->print_json($data);
        } else {
            $message = "Metodo errato";
        }
    } else {
        $message = "Errore nei dati di input";
    }
}

if (isset($message)) {
    echo $message;
}
?>