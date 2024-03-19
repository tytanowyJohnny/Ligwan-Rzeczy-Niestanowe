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


if (isset($_POST['work_rejected_case_id']) && !empty($_POST['work_rejected_case_id']) && isset($_POST['input_work_rejected_reason']) && !empty($_POST['input_work_rejected_reason'])) {

    $rowId = $_POST['work_rejected_case_id'];
    $reason = $_POST['input_work_rejected_reason'];

    $additionalInfo = new stdClass();
    $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = STATUS::STATUS_REJECTED_DISPLAY_VALUE;
    $additionalInfo->{HistoryEntryType::ADD_INFO_REJECT} = $reason;

    $result = setStatus($rowId, STATUS::STATUS_REJECTED_VALUE, $user->getUserDisplayName(), $additionalInfo);

    echo (json_encode($result));

    exit();
}
