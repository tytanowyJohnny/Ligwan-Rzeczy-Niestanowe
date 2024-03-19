<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/serverUtils.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

$user;

if (!isset ($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset ($_SESSION['user_object'])) {
    header('Location: /login.php');
}

if (isset ($_GET['accepted_case_id'])) {

    $mpkValue = isset ($_GET['mpk_value']) ? $_GET['mpk_value'] : null;
    $costValue = isset ($_GET['cost_value']) ? $_GET['cost_value'] : null;
    $rowId = $_GET['accepted_case_id'];

    // MPK && COST
    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `mpk` = COALESCE(";
    ($mpkValue != null) ? $query .= "'" . $mpkValue . "'" : $query .= "NULL";
    $query .= ", `mpk`), `cost` = COALESCE(";
    ($costValue != null) ? $query .= "'" . $costValue . "'" : $query .= "NULL";
    $query .= ", `cost`) WHERE `id`= $rowId";

    $result = $db->performQuery($query);
    $db->dbDisconnect();

    if ($result) {
        // STATUS
        $additionalInfo = new stdClass();
        $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = STATUS::STATUS_ACCEPTED_DISPLAY_VALUE;

        setStatus($rowId, STATUS::STATUS_ACCEPTED_VALUE, $user->getUserDisplayName(), $additionalInfo);
    }

    echo (json_encode($result));

}

exit();

