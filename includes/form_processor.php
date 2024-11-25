<?php



include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/serverUtils.php';

$user;

if (!isset ($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset ($_SESSION['user_object'])) {
    header('Location: ../login.php');
}



// Validate if variables were passed on correctly
// $isValid_order = isset($_POST['input-order']);
$isValid_link = isset ($_POST['input-link']);
$isValid_syntetyka = isset ($_POST['input-syntetyka']);
$isValid_mpk = isset ($_POST['input-mpk']) && !empty($_POST['input-mpk']);
$isValid_podmiot = isset ($_POST['input-podmiot']);
$isValid_cost = isset ($_POST['input-cost']) && !empty($_POST['input-cost']);
$isValid_project = isset ($_POST['input-project']);
$isValid_amount = isset ($_POST['input-amount']);
$isValid_amount_value = isset ($_POST['input-amount-value']);
$isValid_comment = isset ($_POST['input-comment']);
$isValid_cel_kosztu = isset ($_POST['input-cel-kosztu']);

$resetFlag = isset ($_POST['reset-flag']) && !empty ($_POST['reset-flag']);

// echo 'order'.$isValid_order;
// echo 'link'.$isValid_link;
// echo 'syntetyka'.$isValid_syntetyka;
// echo 'mpk'.$isValid_mpk;
// echo 'podmiot'.$isValid_podmiot;
// echo 'cost'.$isValid_cost;
// echo 'project'.$isValid_project;
// echo 'amount'.$isValid_amount;
// echo 'comment'.$isValid_comment;



if (!$resetFlag && $isValid_podmiot && $isValid_amount && $isValid_amount_value) {

    // Attachment
    // The path you wish to upload the image to
    $imagePath = "upload/pdf/";
    //Stores the tempname as it is given by the host when uploaded.
    $imagetemp = $_FILES['input-file-pdf']['tmp_name'];
    //Stores the filename as it was on the client computer.
    $imagename = $_FILES['input-file-pdf']['name'];

    if (is_uploaded_file($imagetemp)) {
        $fullImagePath = $imagePath . $imagename;
        move_uploaded_file($imagetemp, "../" . $fullImagePath);
    }

    if (empty ($fullImagePath))
        $fullImagePath = 'NULL';

    $mpkValue = $isValid_mpk ? $_POST['input-mpk'] : '';
    $costValue = $isValid_cost ? $_POST['input-cost'] : '';
    $linkValue = $isValid_link ? $_POST['input-link'] : '';
    $syntetykaValue = $isValid_syntetyka ? $_POST['input-syntetyka'] : '';
    $projectValue = $isValid_project ? $_POST['input-project'] : '';
    $commentValue = $isValid_comment ? $_POST['input-comment'] : '';
    $celKosztu = $isValid_cel_kosztu ? $_POST['input-cel-kosztu'] : '';

    // Compose query
    $insertQuery = "INSERT INTO `zgloszenia` (`created_by`, `assigned_department`, `czas_wprowadzenie`, `link`, 
                                                    `syntetyka`, `mpk`, `podmiot`, `cost`, `project`, `amount`, 
                                                    `amount_value`, `comment`, `attachment_uri`, `cel_kosztu`)
                    VALUES (
                        '" . $user->getUsername() . "',
                        '" . $user->getAssignedDepartmentValue() . "',
                        NOW(),
                        '" . $linkValue . "',
                        '" . $syntetykaValue . "',
                        '" . $mpkValue . "',
                        '" . $_POST['input-podmiot'] . "',
                        '" . $costValue . "',
                        '" . $projectValue . "',
                        '" . $_POST['input-amount'] . "',
                        '" . $_POST['input-amount-value'] . "',
                        '" . $commentValue . "',
                        '" . $fullImagePath . "',
                        '" . $celKosztu . "')";

    // echo $insertQuery;


    // Write to DB
    $db = new Mysql;
    $db->dbConnect();
    $result = $db->performQuery($insertQuery);
    $insertedRowId = $db->getLatestID();
    $db->dbDisconnect();

    // Handle original case if necessary
    if (isset ($_POST['origin-case-id'])) {

        $originCaseId = $_POST['origin-case-id'];

        $additionalInfo = new stdClass();
        $additionalInfo->{HistoryEntryType::ADD_INFO_STATUS} = STATUS::STATUS_CLOSED_DISPLAY_VALUE;
        $additionalInfo->{HistoryEntryType::ADD_INFO_NEW_CASE} = $insertedRowId;

        setStatus($originCaseId, STATUS::STATUS_CLOSED_VALUE, $user->getUserDisplayName(), $additionalInfo);

    }


}

// Whatever happens, redirect to main page
header('Location: ../index.php');

?>