<?php

include('../includes/model/user.php');
include_once('../db/db.php');

$user;

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset($_SESSION['user_object'])) {
    header('Location: /login.php');
}

if (isset($_GET['arrival_date']) && !empty($_GET['arrival_date']) && isset($_GET['arrival_case_id']) && !empty($_GET['arrival_case_id'])) {

    $arrival_date = $_GET['arrival_date'];
    $case_id = $_GET['arrival_case_id'];
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `status`=3, `zamawiajacy`='".$user->getUsername()."', `czas_zamowienia`=NOW(), `data_dostawy`='".$arrival_date."' WHERE `id`=".$case_id;

    // echo ($query);

    $result = $db->performQuery($query);

    // while ($row = $result->fetch_assoc()) {

    //     if ($row) {
    //         array_push($devices, $row['name']);
    //     }
    // }

    $db->dbDisconnect();

    echo (json_encode($result));
    exit();
}
