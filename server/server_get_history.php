<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

if (isset($_GET['rowId']) && !empty($_GET['rowId'])) {

    $rowId = $_GET['rowId'];
    
    $db = new Mysql;
    $db->dbConnect();

    $query = "SELECT `history` FROM `zgloszenia` WHERE `id`=".$rowId;

    $result = $db->performQuery($query);

    $db->dbDisconnect();

    if($row = $result->fetch_assoc()) {

        if($row) {

            $historyJson = json_decode($row['history'], true);

            // echo $historyJson[0]['type'];

            $historyString = '';

            foreach($historyJson as $historyJsonProp) {

                $historyString .= '--------------------------' . '<br />';

                $historyString .= '<b>Typ wpisu:</b> ' . $historyJsonProp['type'] . '<br />';
                if($historyJsonProp['timestamp'] != null)
                    $historyString .= '<b>Czas:</b> ' . $historyJsonProp['timestamp'] . '<br />';
                $historyString .= '<b>Wykonał:</b> ' . $historyJsonProp['userDisplayName'] . '<br />';
                $historyString .= '<b><i><u>Dodatkowe informacje:</u></i></b>' . '</br >';;

                foreach($historyJsonProp['additionalInfo'] as $addInfoPropKey => $value) {

                    $historyString .= '<b>' . $addInfoPropKey . ':</b> ' . $value . '<br />';
                }

            }

            echo $historyString;

        }


    }

}

exit();
