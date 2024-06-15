<?php

require_once ("database.php");

$dbh = new DataBaseHelper("localhost", "root", "", "febbraio");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["chiave"]) && isset($_GET["valore"]) && isset($_GET["metodo"])) {
    $chiave = $_GET["chiave"];
    $valore = $_GET["valore"];
    $metodo = $_GET["metodo"];
    if ($metodo == "cookie") {
        setcookie($chiave, $valore);
        $message = json_encode(["succes" => "Cookie set correctly"]);
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
echo $message;
?>