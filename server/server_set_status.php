<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/serverUtils.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';

$user;

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset($_SESSION['user_object'])) {
    header('Location: /login.php');
}

if (isset($_GET['rowId']) && !empty($_GET['rowId']) && isset($_GET['status']) && !empty($_GET['status'])) {

    $rowId = $_GET['rowId'];
    $status = $_GET['status'];

    $additionalInfo = new stdClass();
    $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = getStatusDisplayValue($status);

    $response = setStatus($rowId, $status, $user->getUserDisplayName(), $additionalInfo); 

    echo (json_encode($response));
    exit();
}
