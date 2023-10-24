<html>

<head></head>

<body>

    <?php

    

    include_once('../db/db.php');
    include('model/user.php');

    $user;

    if (!isset($_SESSION)) {
        session_start();
        $user = unserialize($_SESSION['user_object']);
    }

    if (!isset($_SESSION['user_object'])) {
        header('Location: ../login.php');
    }

    

    // Validate if variables were passed on correctly
    $isValid_dzial = isset($_POST['input-dzial']);
    $isValid_status = isset($_POST['input-status']);
    // $isValid_poziom = isset($_POST['input-poziom']); // Poziom might be empty
    $isValid_device = isset($_POST['input-device']);
    $isValid_pomieszczenie = isset($_POST['input-pomieszczenie']);
    $isValid_usterka = isset($_POST['input-usterka']);
    $isValid_dzialZglaszajacy = isset($_POST['input-dzial-zglaszajacy']);

    if ($isValid_dzial && $isValid_status && $isValid_device && $isValid_pomieszczenie && $isValid_usterka && $isValid_dzialZglaszajacy) {


        //Stores the filename as it was on the client computer.
        $imagename = $_FILES['input-zdjecie-usterka']['name'];
        //Stores the filetype e.g image/jpeg
        $imagetype = $_FILES['input-zdjecie-usterka']['type'];
        //Stores any error codes from the upload.
        $imageerror = $_FILES['input-zdjecie-usterka']['error'];
        //Stores the tempname as it is given by the host when uploaded.
        $imagetemp = $_FILES['input-zdjecie-usterka']['tmp_name'];

        //The path you wish to upload the image to
        $imagePath = "upload/images/";

        $fullImagePath = $imagePath . $imagename;


        if (!is_uploaded_file($imagetemp) || !move_uploaded_file($imagetemp, "../" . $fullImagePath))
            $fullImagePath = null;

        // Manual input
        $manualUsterkaValue = ($_POST['input-usterka'] == '0') ? $_POST['input-usterka-freetext'] : "";
        // Poziom value check
        $poziomValue = isset($_POST['input-poziom']) ? isset($_POST['input-poziom']) : "";

        // Compose query
        $insertQuery = "INSERT INTO `zgloszenia`(`created_by`, `czas_wprowadzenie`, `status`, `dzial`, `poziom`, `pomieszczenie`, `usterka`, `usterka_manual`, `device`, `device_file`, `dzial_zglaszajacy`, `wykonawca`, `work_image`, `reject_reason`)
                    VALUES (
                        '" . $user->getUsername() . "',
                        NOW(),
                        '" . $_POST['input-status'] . "',
                        '" . $_POST['input-dzial'] . "',
                        '" . $_POST['input-poziom'] . "',
                        '" . $_POST['input-pomieszczenie'] . "',
                        '" . $_POST['input-usterka'] . "',
                        '" . $manualUsterkaValue . "',
                        '" . $_POST['input-device'] . "',
                        NULLIF('$fullImagePath', ''),
                        '" . $_POST['input-dzial-zglaszajacy'] . "',
                        '', '', '')";

        echo $insertQuery;


        // Write to DB
        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($insertQuery);

        $db->dbDisconnect();

        // Whatever happens, redirect to main page
        header('Location: ../index.php');
    }
    ?>

</body>

</html>