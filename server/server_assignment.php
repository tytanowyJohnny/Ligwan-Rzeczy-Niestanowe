<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

if (isset($_GET['assignment_type']) && !empty($_GET['assignment_type']) && isset($_GET['assignment_case_id']) && !empty($_GET['assignment_case_id'])) {

    $assignment_type = $_GET['assignment_type'];
    $case_id = $_GET['assignment_case_id'];
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "UPDATE `zgloszenia` SET `wykonawca`='".$assignment_type."', `czas_przypisania`=NOW(), `status`='assigned' WHERE `id`=".$case_id;

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
