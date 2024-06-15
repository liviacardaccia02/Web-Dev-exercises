<?php

class DataBaseHelper
{
    private $db;

    function __construct($hostname, $username, $password, $database)
    {
        $this->db = new mysqli($hostname, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    function newGame($statoiniziale)
    {
        $query = "INSERT INTO sudoku (statoiniziale) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $statoiniziale);
        $result = $stmt->execute();

        return $result ? $stmt->insert_id : false;
    }

}

$dbh = new DataBaseHelper("localhost", "root", "", "esami");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $statoiniziale = "000005000000020000000006000000070000001000000000003000000000000008000000000000004";
    $result = $dbh->newGame($statoiniziale);
    setcookie("gameId", $result, time() + 3600, '/');
    echo json_encode(["statoiniziale" => $statoiniziale]);
    // if ($result == false) {
    //     echo json_encode(["error" => "Errore nella creazione del gioco"]);
    // } else {
    //     echo json_encode(["statoiniziale" => $statoiniziale]);
    //     setcookie("gameId", $result, time() + 3600, '/');
    // }
} else {
    echo json_encode(["error" => "Metodo non valido"]);
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $solution = $_POST["solution"];

//     if (!isset($_COOKIE["gameId"])) {
//         echo json_encode(["error" => "Cookie non impostato"]);
//     } else {
//         if (validate_solution($solution)) {
//             echo json_encode(["succes" => "Soluzione corretta"]);
//         } else {
//             echo json_encode(["error" => "Soluzione non valida"]);
//         }
//     }
// }

function validate_solution($solution)
{
    return true;
}

?>