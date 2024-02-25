<?php


include_once('../db/db.php');
include('../includes/model/zgloszenie.php');

// $rowInfo = [];

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
                $row['project'], $row['amount'], $row['comment'], $row['status'], $row['zatwierdzajacy'], 
                $row['czas_zatwierdzenia'], $row['zamawiajacy'], $row['czas_zamowienia'], $row['data_dostawy'], $row['attachment_uri']);
            
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
            $info->zatwierdzajacyDisplayName = $tempZgloszenie->getZatwierdzajacyDisplayName();
            $info->czas_zatwierdzenia = $tempZgloszenie->get_czas_zatwierdzenia();
            $info->zamawiajacy = $tempZgloszenie->get_zamawiajacy();
            $info->zamawiajacyDisplayName = $tempZgloszenie->getZamawiającyDisplayName();
            $info->czas_zamowienia = $tempZgloszenie->get_czas_zamowienia();
            $info->data_dostawy = $tempZgloszenie->get_data_dostawy();
            $info->attachment_uri = $tempZgloszenie->get_attachment_uri();

            // array_push($rowInfo, $info);
        }
    }

    $db->dbDisconnect();

    echo (json_encode($info));
    exit();
}
