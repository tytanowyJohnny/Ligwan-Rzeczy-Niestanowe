<?php


include_once('../db/db.php');
include('../includes/model/zgloszenie.php');

$rowInfo = [];

if (isset($_GET['rowId']) && !empty($_GET['rowId'])) {

    $rowId = $_GET['rowId'];
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "SELECT * FROM `zgloszenia` WHERE `id`=".$rowId;

    // echo ($query);

    $result = $db->performQuery($query);

    while ($row = $result->fetch_assoc()) {

        if ($row) {
            
            $info = new stdClass();
            $info->status = $row['status'];
            $info->wykonawca = getContractorDisplayValue($row['wykonawca']);
            $info->damage_image_url = $row['device_file'];
            $info->work_image_url = $row['work_image'];
            $info->rejected_reason = $row['rejected_reason'];
            $info->input_timestamp = $row['czas_wprowadzenie'];

            array_push($rowInfo, $info);
        }
    }

    $db->dbDisconnect();

    echo (json_encode($rowInfo));
    exit();
}
