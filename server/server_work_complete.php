<?php


include_once('../db/db.php');

if (isset($_POST['work_completed_case_id']) && !empty($_POST['work_completed_case_id'])) {

    $rowId = $_POST['work_completed_case_id'];
    //The path you wish to upload the image to
    $imagePath = "upload/images/";
    //Stores the tempname as it is given by the host when uploaded.
    $imagetemp = $_FILES['input-work-completed-image']['tmp_name'];
    //Stores the filename as it was on the client computer.
    $imagename = $_FILES['input-work-completed-image']['name'];

    $fullImagePath = $imagePath . $imagename;

    if (is_uploaded_file($imagetemp)) {
        if (move_uploaded_file($imagetemp, "../" . $fullImagePath)) {

            $db = new Mysql;
            $db->dbConnect();

            $query = "UPDATE `zgloszenia` SET `work_image`='". $fullImagePath ."', `status`='completed', `czas_zakonczenia`=NOW() WHERE `id`=".$rowId;

            $result = $db->performQuery($query);

            $db->dbDisconnect();

            echo (json_encode($result));

        } else {
            echo "Image upload failed";
        }
    }



    
    exit();
}
