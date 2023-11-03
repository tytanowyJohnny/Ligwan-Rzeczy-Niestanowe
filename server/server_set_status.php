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

if (isset($_GET['rowId']) && !empty($_GET['rowId']) && isset($_GET['status']) && !empty($_GET['status'])) {

    $rowId = $_GET['rowId'];
    $status = $_GET['status'];
    // $status = 2;

    $dateTimeField = 'czas_zatwierdzenia';

    // switch($status) {

    //     case 'in_progress':
    //         $dateTimeField = 'czas_rozpoczecia';
    //         break;

    //     case 'verified':
    //         $dateTimeField = 'czas_zweryfikowania';
    //         break;

    //     case 'closed':
    //         $dateTimeField = 'czas_zamkniecia';
    //         break;

    // }
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `status`=2, `".$dateTimeField."`=NOW(), `zatwierdzajacy`='".$user->getUsername()."' WHERE `id`=".$rowId;

    $result = $db->performQuery($query);


    $db->dbDisconnect();

    echo (json_encode($result));
    exit();
}
