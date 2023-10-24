<?php


    include_once('../db/db.php');

    $poziomy = [];

    if(isset($_GET['dzial']) && !empty($_GET['dzial'])) {

        $dzial = $_GET['dzial'];

        $db = new Mysql;
        $db->dbConnect();

        $result = $db->performQuery("SELECT DISTINCT `poziom` FROM `lokalizacje` WHERE `dzial`='".$dzial."'");

        while($row = $result->fetch_assoc()) {

            if($row) {
                array_push($poziomy, $row['poziom']);
            }


        }

        $db->dbDisconnect();

        echo(json_encode($poziomy));
        exit();

    }

?>