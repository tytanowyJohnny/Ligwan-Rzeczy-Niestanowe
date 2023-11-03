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
    $isValid_order = isset($_POST['input-order']);
    $isValid_link = isset($_POST['input-link']);
    $isValid_syntetyka = isset($_POST['input-syntetyka']);
    $isValid_mpk = isset($_POST['input-mpk']);
    $isValid_podmiot = isset($_POST['input-podmiot']);
    $isValid_cost = isset($_POST['input-cost']);
    $isValid_project = isset($_POST['input-project']);
    $isValid_amount = isset($_POST['input-amount']);
    $isValid_comment = isset($_POST['input-comment']);

    // echo $isValid_order;
    // echo $isValid_link;
    // echo $isValid_syntetyka;
    // echo $isValid_mpk;
    // echo $isValid_cost;
    // echo $isValid_project;
    // echo $isValid_amount;
    // echo $isValid_comment;


    if ($isValid_order && $isValid_link && $isValid_syntetyka && $isValid_mpk && $isValid_cost && $isValid_project && $isValid_amount && $isValid_comment) {

        // echo $_POST['input-cost'];

        // Compose query
        $insertQuery = "INSERT INTO `zgloszenia` (`created_by`, `czas_wprowadzenie`, `zamowienie`, `link`, `syntetyka`, `mpk`, `podmiot`, `cost`, `project`, `amount`, `comment`)
                    VALUES (
                        '" . $user->getUsername() . "',
                        NOW(),
                        '" . $_POST['input-order'] . "',
                        '" . $_POST['input-link'] . "',
                        '" . $_POST['input-syntetyka'] . "',
                        '" . $_POST['input-mpk'] . "',
                        '" . $_POST['input-podmiot'] . "',
                        '" . $_POST['input-cost'] . "',
                        '" . $_POST['input-project'] . "',
                        '" . $_POST['input-amount'] . "',
                        '" . $_POST['input-comment'] . "')";

        // echo $insertQuery;


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