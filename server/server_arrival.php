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

if (isset($_GET['order_number']) && !empty($_GET['order_number']) && isset($_GET['arrival_date']) && !empty($_GET['arrival_date']) && isset($_GET['arrival_case_id']) && !empty($_GET['arrival_case_id'])) {

    $arrival_date = $_GET['arrival_date'];
    $case_id = $_GET['arrival_case_id'];
    $order_number = $_GET['order_number'];

    $additionalInfo = new stdClass();
    $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = STATUS::STATUS_ORDERED_DISPLAY_VALUE;
    $additionalInfo->{HistoryEntryType::ADD_INFO_ORDER_NUMBER} = $order_number;
    $additionalInfo->{HistoryEntryType::ADD_INFO_ARRIVAL_DATE} = $arrival_date;

    $result = setStatus($case_id, STATUS::STATUS_ORDERED_VALUE, $user->getUserDisplayName(), $additionalInfo);

    echo (json_encode($result));
    exit();
}
