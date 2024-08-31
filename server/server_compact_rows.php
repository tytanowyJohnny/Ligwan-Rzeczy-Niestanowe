<?php

// ini_set('display_errors',1); 
// error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/commonUtils.php';

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


$query = "SELECT z.* FROM `zgloszenia` AS z INNER JOIN `users` AS u ON z.created_by = u.kod INNER JOIN `podmioty` AS p ON z.podmiot = p.ident INNER JOIN `statusy` AS s ON z.status = s.id";

// SEARCH
if(!empty($requestData['search']['value'])) {

    $searchValue = $requestData['search']['value'];

    $query .= " WHERE z.id LIKE '%" . $searchValue . "%' OR";
    $query .= " z.sygnatura LIKE '%" . $searchValue . "%' OR";
    $query .= " u.imie LIKE '%" . $searchValue . "%' OR";
    $query .= " u.nazwisko LIKE '%" . $searchValue . "%' OR";
    $query .= " z.czas_wprowadzenie LIKE '%" . $searchValue . "%' OR";
    $query .= " z.syntetyka LIKE '%" . $searchValue . "%' OR";
    $query .= " z.mpk LIKE '%" . $searchValue . "%' OR";
    $query .= " p.name LIKE '%" . $searchValue . "%' OR";
    $query .= " z.cost LIKE '%" . $searchValue . "%' OR";
    $query .= " z.project LIKE '%" . $searchValue . "%' OR";
    $query .= " z.link LIKE '%" . $searchValue . "%' OR";
    $query .= " z.amount LIKE '%" . $searchValue . "%' OR";
    $query .= " z.amount_value LIKE '%" . $searchValue . "%' OR";
    $query .= " z.comment LIKE '%" . $searchValue . "%' OR";
    $query .= " s.label LIKE '%" . $searchValue . "%'";

}

$allRecordsQuery;

if(!$elevatedVisibility) {
    if(!empty($requestData['search']['value'])) {
        $query .=  " AND z.assigned_department = '" . $userDepartment . "'";
        $allRecordsQuery = "SELECT COUNT(*) FROM `zgloszenia`";
    } else {
        $query .=  " WHERE z.assigned_department = '" . $userDepartment . "'";
        $allRecordsQuery = "SELECT COUNT(*) FROM `zgloszenia` WHERE `assigned_department` = '" . $userDepartment . "'";
    }
}

// SORT
$columns = ["z.id", "z.czas_wprowadzenie", "u.imie, u.nazwisko", "z.syntetyka", "z.mpk", "p.name", "z.cost", "z.project", "z.link", "z.amount", "z.amount_value", "s.label"];

if(!empty($requestData['order'])) {

    $colValue = $requestData['order'][0]['column'];
    $dir = $requestData['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

    $query .= " ORDER BY " . $columns[$colValue] . " " . $dir;

}

// PAGINATION
$beginDraw = intval($requestData['start']);
$endDraw = $beginDraw + intval($requestData['length']);

if($requestData['length'] > 0)
    $query .= " LIMIT " . $beginDraw . "," . $endDraw;

$result = $db->performQuery($query);
$totalRowsResult = $db->performQuery($allRecordsQuery);
$totalRowsCount = mysqli_fetch_array($totalRowsResult);

$db->dbDisconnect();

$compactRowsArr = [];

while ($row = $result->fetch_assoc()) {

    if ($row) {

        $obj = new Zgloszenie(
            $row['id'],
            $row['sygnatura'],
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
            $row['amount_value'],
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
            "amount_value" => $obj->get_amount_value() . "zł",
            "statusDisplayValue" => $obj->getStatusAndDeliveryDate()

        );

        array_push($compactRowsArr, $compactInfo);

        // // SEARCH
        // if(!empty($requestData['search']['value'])) {

        //     if(in_array($requestData['search']['value'], $compactInfo)) {
        //         array_push($compactRowsArr, $compactInfo);
        //     }

        // } else {

        //     array_push($compactRowsArr, $compactInfo);
        // }
        
    }
}

$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal" => intval($totalRowsCount[0]),//intval($totalRows), //count($compactRowsArr),  // total number of records
    "recordsFiltered" => !empty($requestData['search']['value']) ? count($compactRowsArr) : intval($totalRowsCount[0]), //count($compactRowsArr), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $compactRowsArr//$compactRowsArr // total data array
);


echo (json_encode($json_data));
// echo 'TEST';
exit();

?>

