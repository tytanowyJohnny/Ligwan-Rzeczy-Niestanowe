<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';


function changeArrival($caseId, $userDisplayName, $arrivalDate, $additionalInfo = NULL) {

    $db = new Mysql;
    $db->dbConnect();
    $query = "UPDATE `zgloszenia` SET `data_dostawy`='" . $arrivalDate . "'  WHERE `id`=" . $caseId;
    $result = $db->performQuery($query);
    $db->dbDisconnect();

    // HISTORY UPDATE
    return updateHistory($caseId, HistoryEntryType::composeHistoryEntry(HistoryEntryType::ARRIVAL_DATE_CHANGE, $userDisplayName, $additionalInfo));

}
function setArrival($caseId, $status, $userDisplayName, $arrivalDate, $additionalInfo = NULL) {

    $statusUpdate = setStatus($caseId, $status, $userDisplayName, $additionalInfo);

    $db = new Mysql();
    $db->dbConnect();
    $query = "UPDATE `zgloszenia` SET `data_dostawy`='" . $arrivalDate . "' WHERE `id`=" . $caseId;
    $result = $db->performQuery($query);

    return $result;

}
function setStatus($caseId, $status, $userDisplayName, $additionalInfo = NULL)
{

    $db = new Mysql;
    $db->dbConnect();
    $query = "UPDATE `zgloszenia` SET `status`=" . $status . " WHERE `id`=" . $caseId;
    $result = $db->performQuery($query);
    $db->dbDisconnect();

    // HISTORY UPDATE
    return updateHistory($caseId, HistoryEntryType::composeHistoryEntry(HistoryEntryType::STATE_CHANGE, $userDisplayName, $additionalInfo));

}

function getStatusDisplayValue($statusId) {

    $db = new Mysql;
    $db->dbConnect();
    $query = "SELECT `label` FROM `statusy` WHERE `id`=" . $statusId;
    $result = $db->performQuery($query);
    $db->dbDisconnect();

    if($row = $result->fetch_assoc()) {
        if($row) {
            return $row['label'];
        }
    }

    return false;

}

function updateHistory($caseId, $historyEntryJson)
{

    $db = new Mysql();
    $db->dbConnect();

    $historyArr = array();

    // GET CURRENT HISTORY IF EXISTS
    $historyQuery = "SELECT `history` FROM `zgloszenia` WHERE `id` = " . $caseId . " AND `history` IS NOT NULL";

    $result = $db->performQuery($historyQuery);

    if ($row = $result->fetch_assoc()) {

        $historyArr = json_decode($row['history']);

    }

    array_push($historyArr, $historyEntryJson);

    // $arrayEncoded = array_map('utf8_encode', $historyArr);

    $historyQuery = "UPDATE `zgloszenia` SET `history` = '" . json_encode($historyArr, JSON_UNESCAPED_UNICODE) . "' WHERE `id` = " . $caseId;

    $result = $db->performQuery($historyQuery);

    $db->dbDisconnect();

    return $result;
}

function getUserTypeDisplayValue($typeId)
{

    // echo 'TEST';
    $db = new Mysql();
    $db->dbConnect();

    $typeQuery = "SELECT `type_label` FROM `user_types` WHERE `id`=" . $typeId;

    $typeResult = $db->performQuery($typeQuery);

    $db->dbDisconnect();

    if (!$typeResult)
        return false;

    while ($row = $typeResult->fetch_assoc()) {

        if ($row) {
            return $row['type_label'];
        }
    }

    return 'Nieznany';

}

function getAssignedDepartmentAbbr($departmentId)
{

    $query = "SELECT `abbreviation` FROM `departments` WHERE `id` = " . $departmentId;

    $db = new Mysql();
    $db->dbConnect();

    $result = $db->performQuery($query);

    $db->dbDisconnect();

    if ($row = $result->fetch_assoc()) {
        return $row['abbreviation'];
    }

    return false;


}

function hasElevatedVisibility($departmentId)
{

    $query = "SELECT `elevated_visibility` FROM `departments` WHERE `id` = '" . $departmentId . "'";

    $db = new Mysql();
    $db->dbConnect();

    $result = $db->performQuery($query);

    $db->dbDisconnect();

    if ($row = $result->fetch_assoc()) {

        return $row['elevated_visibility'];

    }

    return false;

}


?>