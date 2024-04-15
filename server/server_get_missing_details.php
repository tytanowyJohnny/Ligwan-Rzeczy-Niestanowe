<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

$db = new Mysql;
$db->dbConnect();

// MPK

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

// KOSZT RODZAJOWY

$costQuery = "SELECT * FROM `cost`";

$costResult = $db->performQuery($costQuery);

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

// SYNTETYKA

$syntetykaQuery = "SELECT * FROM `syntetyki`";

$syntetykaResult = $db->performQuery($syntetykaQuery);

$syntetykaResultArray = array();

while ($syntetykaRow = $syntetykaResult->fetch_assoc()) {

    if ($syntetykaRow) {

        $syntetykaRowJson = new stdClass();

        $syntetykaRowJson->id = $syntetykaRow["id"];
        $syntetykaRowJson->label = $syntetykaRow["label"];
        $syntetykaRowJson->value = $syntetykaRow["value"];

        array_push($syntetykaResultArray, $syntetykaRowJson);

    }
}

// PROJEKT

$projectQuery = "SELECT * FROM `projects`";

$projectResult = $db->performQuery($projectQuery);

$projectResultArray = array();

while ($projectRow = $projectResult->fetch_assoc()) {

    if ($projectRow) {

        $projectRowJson = new stdClass();

        $projectRowJson->id = $projectRow["id"];
        $projectRowJson->label = $projectRow["label"];
        $projectRowJson->value = $projectRow["value"];

        array_push($projectResultArray, $projectRowJson);

    }
}

// FINALIZE

$finalResultArray = array();

array_push($finalResultArray, $mpkResultArray);
array_push($finalResultArray, $costResultArray);
array_push($finalResultArray, $syntetykaResultArray);
array_push($finalResultArray, $projectResultArray);

echo json_encode($finalResultArray, JSON_UNESCAPED_UNICODE);

exit();
