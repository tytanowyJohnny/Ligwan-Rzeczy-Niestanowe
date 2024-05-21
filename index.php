<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/zgloszenie.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php';

$user;

if (!isset ($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset ($_SESSION['user_object'])) {
    header('Location: /login.php');
}

// EDIT EXISTING ENTRY
if (isset ($_POST['load_case_id']) && !empty ($_POST['load_case_id'])) {

    $loadedCaseMode = true;
    $caseId = $_POST['load_case_id'];

    $db = new Mysql();
    $db->dbConnect();
    $query = "SELECT * FROM `zgloszenia` WHERE `id` = " . $caseId;

    $result = $db->performQuery($query);

    $db->dbDisconnect();

    if ($row = $result->fetch_assoc()) {

        if ($row) {

            $loadedCase = new Zgloszenie(
                $row['id'],
                $row['created_by'],
                $row['czas_wprowadzenie'],
                $row['zamowienie'],
                $row['link'],
                $row['syntetyka'],
                $row['mpk'],
                $row['podmiot'],
                $row['cost'],
                $row['project'],
                $row['amount'],
                $row['amount_value'],
                $row['comment'],
                $row['status'],
                $row['data_dostawy'],
                $row['attachment_uri'],
                $row['assigned_department'],
                $row['history']
            );
        }
    }

}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Rzeczy Niestanowe</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Data Tables -->
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <meta http-equiv="Content-Language" content="pl">
    <meta charset="UTF-8">

</head>

<body>
    <!-- Inputs -->
    <div class="container mb-4">

        <div class="row mt-3 mb-3 h-100 d-flex align-items-center">

            <div class="col-sm-6">

                <img src="media/logo.png" class="img-fluid" alt="logo" />

            </div>

            <div class="col-sm-4 user-info-box">

                <span><b>Zalogowano jako: </b>
                    <?php echo $user->getUserDisplayName() ?>
                </span>
                <br />
                <span><b>Widoczność: </b>
                    <?php echo $user->getAssignedDepartmentDisplayValue() ?>
                </span>
                <br />
                <span><b>Uprawnienia: </b>
                    <?php echo $user->getUserAccessDisplayList() ?>
                </span>
                <div id="access_type" style="display: none;">
                    <?php echo $user->getUserAccessType() ?>
                </div>


            </div>

            <div class="col-sm-2">
                <form action="logout.php">
                    <button class="btn btn-danger" type="submit">Wyloguj</button>
                </form>
            </div>

        </div>

        <?php if (in_array(UserType::WPROWADZANIE, $user->getUserAccessList())): ?>
            <form id="main-form" action="includes/form_processor.php" method="POST" enctype="multipart/form-data"
                class="pt-3 pb-3 form-background needs-validation" novalidate>

                <div class="row mb-3">

                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 text-center">
                        <p class="h1 form-header">Formularz zgłoszeniowy</p>
                    </div>
                    <div class="col-sm-2"></div>

                </div>

                <div class="row">

                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon3">Syntetyka</span>
                            <select name="input-syntetyka" class="form-select" id="basic-addon-select-syntetyka">

                                <?php

                                // HANDLE PRE-LOADED CASE SCENARIO
                                if (isset($loadedCaseMode) && $loadedCaseMode) {
                                    echo "<option selected value='" . $loadedCase->get_syntetyka() . "'>" . $loadedCase->get_syntetyka() . " - " . $loadedCase->getSyntetykaDisplayValue() . "</option> -->";
                                } else {
                                    echo "<option selected disabled value=''>-- Wybierz --</option> -->";
                                }

                                // STANDARD OPTIONS FROM DB
                                $db = new Mysql;

                                $db->dbConnect();

                                $result = $db->performQuery("SELECT * FROM `syntetyki`");

                                while ($row = $result->fetch_assoc()) {

                                    echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
                                }

                                $db->dbDisconnect();


                                ?>
                            </select>
                            <!-- <div class="invalid-feedback">
                                To pole jest wymagane
                            </div> -->
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon1">Link</span>
                            <input type="text" id="input-link" name="input-link" class="form-control" value="<?php if(isset($loadedCaseMode) && $loadedCaseMode) echo $loadedCase->get_link() ?>">
                            <div class="invalid-feedback">
                                To pole jest wymagane
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon3">Kontrahent</span>
                            <select name="input-podmiot" class="form-control selectpicker" id="basic-addon-select-podmiot"
                                data-live-search="true" required>

                                <?php


                                // HANDLE PRE-LOADED CASE SCENARIO
                                if (isset($loadedCaseMode) && $loadedCaseMode) {
                                    echo "<option selected value='" . $loadedCase->get_podmiot() . "'>" . $loadedCase->getPodmiotDisplayValue() . "</option> -->";
                                } else {
                                    echo "<option selected disabled value=''>-- Wybierz --</option> -->";                                 
                                }

                                // STANDARD OPTIONS FROM DB
                                $db = new Mysql;

                                $db->dbConnect();

                                $result = $db->performQuery("SELECT * FROM `podmioty` WHERE `active`=1");

                                while ($row = $result->fetch_assoc()) {

                                    echo "<option value='" . $row['ident'] . "' data-tokens='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                }

                                $db->dbDisconnect();


                                ?>

                            </select>
                            <div class="invalid-feedback">
                                To pole jest wymagane
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon4">MPK</span>
                            <select name="input-mpk" class="form-select" id="basic-addon-select-mpk">

                                <?php

                                // HANDLE PRE-LOADED CASE SCENARIO
                                if (isset($loadedCaseMode) && $loadedCaseMode) {
                                    echo "<option selected value='" . $loadedCase->get_mpk() . "'>" . $loadedCase->getMPKDisplayValue() . "</option> -->";
                                } else {
                                    echo "<option selected disabled value=''>-- Wybierz --</option> -->";
                                }

                                // STANDARD OPTIONS FROM DB
                                $db = new Mysql;

                                $db->dbConnect();

                                $result = $db->performQuery("SELECT * FROM `mpk`");

                                while ($row = $result->fetch_assoc()) {

                                    echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
                                }

                                $db->dbDisconnect();


                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>

                </div>

                <div class="row">

                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon3">Projekt</span>
                            <select name="input-project" class="form-select" id="basic-addon-select-project" 
                                data-live-search="true">

                                <?php

                                // HANDLE PRE-LOADED CASE SCENARIO
                                if (isset($loadedCaseMode) && $loadedCaseMode) {
                                    echo "<option selected value='" . $loadedCase->get_project() . "'>" . $loadedCase->getProjectDisplayValue() . "</option> -->";
                                } else {
                                    echo "<option selected disabled value=''>-- Wybierz --</option> -->";
                                }

                                // STANDARD OPTIONS FROM DB
                                $db = new Mysql;

                                $db->dbConnect();

                                $result = $db->performQuery("SELECT * FROM `projects`");

                                while ($row = $result->fetch_assoc()) {

                                    echo "<option value='" . $row['value'] . "' data-tokens='" . $row['label'] . "'>" . $row['label'] . "</option>";
                                }

                                $db->dbDisconnect();


                                ?>

                            </select>
                            <!-- <div class="invalid-feedback">
                                To pole jest wymagane
                            </div> -->
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon4">Koszt rodzajowy</span>
                            <select name="input-cost" class="form-select" id="basic-addon-select-cost"
                                data-live-search="true">

                                <?php

                                // HANDLE PRE-LOADED CASE SCENARIO
                                if (isset($loadedCaseMode) && $loadedCaseMode) {
                                    echo "<option selected value='" . $loadedCase->get_cost() . "'>" . $loadedCase->getCostDisplayValue() . "</option> -->";
                                } else {
                                    echo "<option selected disabled value=''>-- Wybierz --</option> -->";
                                }

                                // STANDARD OPTIONS FROM DB
                                $db = new Mysql;

                                $db->dbConnect();

                                $result = $db->performQuery("SELECT * FROM `cost`");

                                while ($row = $result->fetch_assoc()) {

                                    echo "<option value='" . $row['value'] . "' data-tokens='" . $row['label'] . "'>" . $row['label'] . "</option>";
                                }

                                $db->dbDisconnect();


                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>

                </div>

                <div class="row">

                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon1">Ilość</span>
                            <input type="number" step="1" id="input-amount" name="input-amount" class="form-control" value="<?php if(isset($loadedCaseMode) && $loadedCaseMode) echo $loadedCase->get_amount() ?>" required>
                            <div class="invalid-feedback">
                                To pole jest wymagane
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon1">Wartość</span>
                            <input type="number" step="0.01" id="input-amount-value" name="input-amount-value" class="form-control" placeholder="zł" value="<?php if(isset($loadedCaseMode) && $loadedCaseMode) echo $loadedCase->get_amount_value() ?>" required>
                            <div class="invalid-feedback">
                                To pole jest wymagane
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <input name="input-file-pdf" accept="application/pdf" class="form-control" type="file"
                                id="input-file-pdf">
                        </div>
                    </div>
                    <div class="col-sm-2"></div>

                </div>

                <div class="row">

                    <div class="col-sm-2"></div>

                    <div class="col-sm-8">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text" id="basic-addon3">Komentarz</span>
                            <textarea class="form-control" id="input-comment" name="input-comment" rows="3"><?php if(isset($loadedCaseMode) && $loadedCaseMode) echo $loadedCase->get_comment()?></textarea>
                        </div>
                    </div>

                    <div class="col-sm-2"></div>
                </div>

                <div class="row">

                    <div class="col-sm-6"></div>
                    <div class="col-sm-4">
                        <div class="text-end">
                            <?php if(isset($loadedCaseMode) && $loadedCaseMode) : ?>
                                <input type="hidden" name="reset-flag" id="reset-flag">
                                <button class="btn btn-danger" onclick="$('#reset-flag').val('true')" type="submit">Reset</button>
                                <input type="hidden" name="origin-case-id" value="<?php echo $loadedCase->get_id()?>">
                                <button class="btn btn-primary" type="submit">Wyślij ponownie</button>
                            <?php else : ?>
                                <button class="btn btn-primary" type="submit">Wyślij zgłoszenie</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>

                </div>

            </form>
        <?php endif; ?>



    </div>
    <!-- Table -->
    <div class="container-fluid">

        <table class="table table-striped table-hover mt-5" id="mainTable">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data zlecenia</th>
                    <th scope="col">Zlecający</th>
                    <th scope="col">Syntetyka</th>
                    <th scope="col">MPK</th>
                    <th scope="col">Kontrahent</th>
                    <th scope="col">Koszt rodzajowy</th>
                    <th scope="col">Projekt</th>
                    <th scope="col">Link</th>
                    <th scope="col">Ilość</th>
                    <th scope="col">Wartość</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>

        </table>

    </div>

    <!-- Modals -->
    <div id='image-modal-container'></div>
    <div id='assignment-modal-container'></div>
    <div id='work-completed-modal-container'></div>
    <div id='work-rejected-modal-container'></div>
    <div id='history-modal-container'></div>
    <div id='arrival-modal-container'></div>
    <div id='change-arrival-modal-container'></div>
    <div id='work-acceptance-modal-container'></div>
    <div id='request-denied-modal-container'></div>

    <!-- JS scripts -->
    <script src="js/script.js"></script>
    <script src="js/modal_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>