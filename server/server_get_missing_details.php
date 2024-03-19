<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

$db = new Mysql;
$db->dbConnect();

$mpkQuery = "SELECT * FROM `mpk`";

$mpkResult = $db->performQuery($mpkQuery);

$mpkResultArray = array();

while ($mpkRow = $mpkResult->fetch_assoc()) {

    if ($mpkRow) {

        $mpkRowJson = new stdClass();

        $mpkRowJson->id = $mpkRow["id"];
        $mpkRowJson->label = $mpkRow["label"];
        $mpkRowJson->value = $mpkRow["value"];

        array_push($mpkResultArray, $mpkRowJson);

    }

}

$costQuery = "SELECT * FROM `cost`";

$costResult = $db->performQuery($costQuery);

$db->dbDisconnect();

$costResultArray = array();

while ($costRow = $costResult->fetch_assoc()) {

    if ($costRow) {

        $costRowJson = new stdClass();

        $costRowJson->id = $costRow["id"];
        $costRowJson->label = $costRow["label"];
        $costRowJson->value = $costRow["value"];

        array_push($costResultArray, $costRowJson);

    }
}

$finalResultArray = array();

array_push($finalResultArray, $mpkResultArray);
array_push($finalResultArray, $costResultArray);

echo json_encode($finalResultArray, JSON_UNESCAPED_UNICODE);

exit();
