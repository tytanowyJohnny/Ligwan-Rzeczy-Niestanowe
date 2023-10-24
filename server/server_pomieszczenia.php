<?php


    include_once('../db/db.php');

    $pomieszczenia = [];

    if(isset($_GET['dzial']) && !empty($_GET['dzial']) && isset($_GET['poziom']) && !empty($_GET['poziom'])) {

        $dzial = $_GET['dzial'];
        $poziom = $_GET['poziom'];

        $db = new Mysql;
        $db->dbConnect();

        //echo "SELECT * FROM `lokalizacje` WHERE `dzial`='".$dzial."'". " AND `poziom`='".$poziom."'";

        $query = "SELECT * FROM `lokalizacje` WHERE `dzial`='".$dzial."'". " AND `poziom`='".$poziom."'";

        $result = $db->performQuery($query);

        while($row = $result->fetch_assoc()) {

            if($row) {
                array_push($pomieszczenia, $row['pomieszczenie']);
            }


        }

        $db->dbDisconnect();

        echo(json_encode($pomieszczenia));
        exit();

    }

?>