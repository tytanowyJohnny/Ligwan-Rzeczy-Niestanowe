<?php


include_once('../db/db.php');
include_once('../includes/model/zgloszenie.php');
include_once('../includes/model/flow_processor.php');
include_once('../includes/model/user.php');

require_once __DIR__ . '/../includes/serverUtils.php';

$user;

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset($_SESSION['user_object'])) {
    header('Location: ../login.php');
}

if (isset($_GET['rowId']) && !empty($_GET['rowId'])) {

    $rowId = $_GET['rowId'];

    $info = new stdClass();
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "SELECT * FROM `zgloszenia` WHERE `id`=".$rowId;

    // echo ($query);

    $result = $db->performQuery($query);

    while ($row = $result->fetch_assoc()) {

        if ($row) {

            $tempZgloszenie = new Zgloszenie(
                $row['id'], $row['created_by'], $row['czas_wprowadzenie'], $row['zamowienie'], 
                $row['link'], $row['syntetyka'], $row['mpk'], $row['podmiot'], $row['cost'], 
                $row['project'], $row['amount'], $row['comment'], $row['status'],
                $row['data_dostawy'], $row['attachment_uri'], $row['assigned_department'],
                $row['history']);
            
            $info->id = $tempZgloszenie->get_id();
            $info->czas_wprowadzenie = $tempZgloszenie->get_czas_wprowadzenie();
            $info->order = $tempZgloszenie->get_order();
            // $info->orderDisplayValue = $tempZgloszenie->getOrderDisplayValue();
            $info->link = $tempZgloszenie->get_link();
            $info->syntetyka = $tempZgloszenie->get_syntetyka();
            $info->syntetykaDisplayValue = $tempZgloszenie->getSyntetykaDisplayValue();
            $info->mpk = $tempZgloszenie->get_mpk();
            $info->mpkDisplayValue = $tempZgloszenie->getMPKDisplayValue();
            $info->podmiot = $tempZgloszenie->get_podmiot();
            $info->cost = $tempZgloszenie->get_cost();
            $info->costDisplayValue = $tempZgloszenie->getCostDisplayValue();
            $info->project = $tempZgloszenie->get_project();
            $info->projectDisplayValue = $tempZgloszenie->getProjectDisplayValue();
            $info->amount = $tempZgloszenie->get_amount();
            $info->comment = $tempZgloszenie->get_comment();
            $info->status = $tempZgloszenie->get_status();
            $info->data_dostawy = $tempZgloszenie->get_data_dostawy();
            $info->attachment_uri = $tempZgloszenie->get_attachment_uri();
            $info->assigned_department = $tempZgloszenie->get_assigned_department();
            $info->assignedDepartmentDisplayValue = getAssignedDepartmentAbbr($tempZgloszenie->get_assigned_department());
            

            $fp = new FlowProcessor();
            $info->validTransitions = $fp->getValidTransitions($tempZgloszenie->get_status(), $user->getUserAccessList());

            // array_push($rowInfo, $info);
        }
    }

    $db->dbDisconnect();

    echo (json_encode($info));
    exit();
}
