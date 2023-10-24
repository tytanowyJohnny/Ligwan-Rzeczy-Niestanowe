<?php


include_once('../db/db.php');

//$rowTimelineInfo = [];

if (isset($_GET['rowId']) && !empty($_GET['rowId'])) {

    $rowId = $_GET['rowId'];
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "SELECT `czas_wprowadzenie`,`czas_przypisania`,`czas_rozpoczecia`,`czas_zakonczenia`,`czas_zweryfikowania`,`czas_zamkniecia` FROM `zgloszenia` WHERE `id`=".$rowId;

    $result = $db->performQuery($query);

    while($row = $result->fetch_assoc()) {

        if($row) {

            $rowTimelineInfo = new stdClass();
            $rowTimelineInfo->czas_wprowadzenie = $row['czas_wprowadzenie'];
            $rowTimelineInfo->czas_przypisania = $row['czas_przypisania'];
            $rowTimelineInfo->czas_rozpoczecia = $row['czas_rozpoczecia'];
            $rowTimelineInfo->czas_zakonczenia = $row['czas_zakonczenia'];
            $rowTimelineInfo->czas_zweryfikowania = $row['czas_zweryfikowania'];
            $rowTimelineInfo->czas_zamkniecia = $row['czas_zamkniecia'];
        }


    }

    $db->dbDisconnect();

    echo (json_encode(($rowTimelineInfo) != null ? $rowTimelineInfo : ''));

    exit();
}
