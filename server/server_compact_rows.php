<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

$user;

if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['user_object'])) {
        header('Location: /login.php');
    }

    $user = unserialize($_SESSION['user_object']);
}

$db = new Mysql;
$db->dbConnect();

$userDepartment = $user->getAssignedDepartmentValue();
$elevatedVisibility = hasElevatedVisibility($userDepartment);
$requestData = $_REQUEST;

$query = "SELECT * FROM `zgloszenia` WHERE `assigned_department` = '" . $userDepartment . "'";

if ($elevatedVisibility)
    $query = "SELECT * FROM `zgloszenia`";


$result = $db->performQuery($query);

$db->dbDisconnect();

$compactRowsArr = [];

while ($row = $result->fetch_assoc()) {

    if ($row) {

        $obj = new Zgloszenie(
            $row['id'],
            $row['created_by'],
            $row['czas_wprowadzenie'],
            $row['zamowienie'],
            $row['link'],
            $row['syntetyka'],
            $row['mpk'],
            $row['podmiot'],
            $row['cost'],
            $row['project'],
            $row['amount'],
            $row['comment'],
            $row['status'],
            $row['data_dostawy'],
            $row['attachment_uri'],
            $row['assigned_department'],
            $row['history']
        );

        $compactInfo = array(
            "DT_RowId" => "main-row-" . $obj->get_id(),
            "id" => $obj->get_id(),
            "czas_wprowadzenie" => $obj->get_czas_wprowadzenie(),
            "createdByDisplayName" => $obj->getCreateByDisplayName(),
            "syntetyka" => $obj->get_syntetyka(),
            "mpk" => $obj->get_mpk(),
            "podmiotDisplayValue" => $obj->getPodmiotDisplayValue(),
            "cost" => $obj-> get_cost(),
            "project" => $obj->get_project(),
            "link" => "<a href='https://" . $obj->get_link() . "' target='_blank'>" . $obj->get_link() . "</a>",
            "amount" => $obj->get_amount(),
            "statusDisplayValue" => $obj->getStatusDisplayValue()

        );

        if(!empty($requestData['search']['value'])) {

            if(in_array($requestData['search']['value'], $compactInfo)) {
                array_push($compactRowsArr, $compactInfo);
            }

        } else {

            array_push($compactRowsArr, $compactInfo);
        }

        
    }
}

$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal" => count($compactRowsArr),  // total number of records
    "recordsFiltered" => count($compactRowsArr), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $compactRowsArr   // total data array
);


echo (json_encode($json_data));
// echo 'TEST';
exit();

?>

