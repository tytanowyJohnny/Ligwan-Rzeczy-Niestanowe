<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/serverUtils.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/commonUtils.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';

$user;

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset($_SESSION['user_object'])) {
    header('Location: /login.php');
}


if (isset($_POST['request-denied-case-id']) && !empty($_POST['request-denied-case-id']) && isset($_POST['input-request-denied-reason']) && !empty($_POST['input-request-denied-reason'])) {

    $rowId = $_POST['request-denied-case-id'];
    $reason = $_POST['input-request-denied-reason'];

    $additionalInfo = new stdClass();
    $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = STATUS::STATUS_DENIED_DISPLAY_VALUE;
    $additionalInfo->{HistoryEntryType::ADD_INFO_REJECT} = parseInputForJSON($reason);

    $result = setStatus($rowId, STATUS::STATUS_DENIED_VALUE, $user->getUserDisplayName(), $additionalInfo);

    echo (json_encode($result));

    exit();
}
