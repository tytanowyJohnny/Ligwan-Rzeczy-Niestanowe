<?php


include_once('../db/db.php');

if (isset($_GET['rowId']) && !empty($_GET['rowId']) && isset($_GET['status']) && !empty($_GET['status'])) {

    $rowId = $_GET['rowId'];
    $status = $_GET['status'];

    $dateTimeField;

    switch($status) {

        case 'in_progress':
            $dateTimeField = 'czas_rozpoczecia';
            break;

        case 'verified':
            $dateTimeField = 'czas_zweryfikowania';
            break;

        case 'closed':
            $dateTimeField = 'czas_zamkniecia';
            break;

    }
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `status`='".$status."', `".$dateTimeField."`=NOW() WHERE `id`=".$rowId;

    $result = $db->performQuery($query);


    $db->dbDisconnect();

    echo (json_encode($result));
    exit();
}
