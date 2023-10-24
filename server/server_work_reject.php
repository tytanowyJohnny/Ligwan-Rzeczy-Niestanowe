<?php


include_once('../db/db.php');

if (isset($_POST['work_rejected_case_id']) && !empty($_POST['work_rejected_case_id']) && isset($_POST['input_work_rejected_reason']) && !empty($_POST['input_work_rejected_reason'])) {

    $rowId = $_POST['work_rejected_case_id'];
    $reason = $_POST['input_work_rejected_reason'];

    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `rejected_reason`='" . $reason . "', `status`='rejected', `czas_zweryfikowania`=NOW() WHERE `id`=" . $rowId;

    $result = $db->performQuery($query);

    $db->dbDisconnect();

    echo (json_encode($result));


    exit();
}
