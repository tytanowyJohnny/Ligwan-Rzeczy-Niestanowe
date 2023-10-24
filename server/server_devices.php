<?php


    include_once('../db/db.php');

    $devices = [];

    if(isset($_GET['dzial_code']) && !empty($_GET['dzial_code']) && isset($_GET['pomieszczenie']) && !empty($_GET['pomieszczenie'])) {

        $dzial_code = $_GET['dzial_code'];
        $pomieszczenie = $_GET['pomieszczenie'];

        $db = new Mysql;
        $db->dbConnect();

        $query = "SELECT * FROM `devices` WHERE `".$dzial_code."` = 1";

        // echo ($query);

        $result = $db->performQuery($query);

        while($row = $result->fetch_assoc()) {

            if($row) {
                array_push($devices, $row['name']);
            }


        }

        $db->dbDisconnect();

        echo(json_encode($devices));
        exit();

    }

?>