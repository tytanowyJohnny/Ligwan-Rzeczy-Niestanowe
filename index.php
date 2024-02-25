<?php

include_once('db/db.php');
include('includes/model/user.php');
include('includes/model/zgloszenie.php');

$user;

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);
}

if (!isset($_SESSION['user_object'])) {
    header('Location: /login.php');
}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Rzeczy Niestanowe</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Data Tables -->
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>


</head>

<body>
    <!-- Inputs -->
    <div class="container">

        <div class="row mt-3 mb-3 h-100 d-flex align-items-center">

            <div class="col-sm-6">

                <img src="media/logo.png" class="img-fluid" alt="logo" />

            </div>

            <div class="col-sm-4 user-info-box">

                <span><b>Zalogowano jako: </b><?php echo $user->getUserDisplayName() ?></span>
                <br />
                <span><b>Uprawnienia: </b><?php echo $user->getUserTypeDisplayName() ?></span>
                <div id="access_type" style="display: none;"><?php echo $user->getUserAccessType() ?></div>
                

            </div>

            <div class="col-sm-2">
                <form action="logout.php">
                    <button class="btn btn-danger" type="submit">Wyloguj</button>
                </form>
            </div>

        </div>

        <form action="includes/form_processor.php" method="POST" enctype="multipart/form-data" class="pt-3 pb-3 form-background needs-validation" novalidate>

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
                        <select name="input-syntetyka" class="form-select" id="basic-addon-select-syntetyka" required>
                            <option selected disabled value="">-- Wybierz --</option>

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `syntetyki`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['value'] . "'>" . $row['value'] . " - " . $row['label'] . "</option>";
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
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon1">Link</span>
                        <input type="text" id="input-link" name="input-link" class="form-control">
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
                        <select name="input-podmiot" class="form-control selectpicker" id="basic-addon-select-podmiot" data-live-search="true" required>
                            <option selected disabled value="">-- Wybierz --</option>

                            
                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `podmioty` WHERE `active`=1");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['ident'] . "' data-tokens='". $row['name'] ."'>" . $row['name'] . "</option>";
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
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon4">MPK</span>
                        <select name="input-mpk" class="form-select" id="basic-addon-select-mpk" required>
                            <option selected disabled value="">-- Wybierz --</option>

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `mpk`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
                            }

                            $db->dbDisconnect();


                            ?>
                        </select>
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>

            </div>

            <div class="row">

                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon3">Projekt</span>
                        <select name="input-project" class="form-select" id="basic-addon-select-project" required>
                            <option selected disabled value="">-- Wybierz --</option>

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `projects`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
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
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon4">Koszt rodzajowy</span>
                        <select name="input-cost" class="form-select" id="basic-addon-select-cost" required>
                            <option selected disabled value="">-- Wybierz --</option>
                            <!-- <option value="0">Wprowadź ręcznie</option> -->

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `cost`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
                            }

                            $db->dbDisconnect();


                            ?>

                        </select>
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                    <!-- <div id="input-group-usterka-freetext" class="input-group has-validation mb-3 invisible">
                        <input type="text" id="input-usterka-freetext" name="input-usterka-freetext" class="form-control">
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div> -->
                </div>
                <div class="col-sm-2"></div>

            </div>

            <div class="row">

                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon1">Ilość</span>
                        <input type="number" step="1" id="input-amount" name="input-amount" class="form-control">
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon1">Zamówienie</span>
                        <input type="text" id="input-order" name="input-order" class="form-control">
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>

            </div>

            <div class="row">

                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <!-- <span class="input-group-text" id="basic-addon1">Załącznik</span> -->
                        <input name="input-file-pdf" accept="application/pdf" class="form-control" type="file"
                            id="input-file-pdf">
                    </div>
                </div>
                <!-- <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon1">Data dostawy</span>
                        <input type="date" id="input-arrival-date" name="input-arrival-date" class="form-control">
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div> -->
                <div class="col-sm-2"></div>                

            </div>

            <div class="row">

                <div class="col-sm-2"></div>

                <div class="col-sm-8">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon3">Komentarz</span>
                        <textarea class="form-control" id="input-comment" name="input-comment" rows="3"></textarea>
                    </div>
                </div>

                <div class="col-sm-2"></div>
            </div>

            <div class="row">

                <div class="col-sm-6"></div>
                <div class="col-sm-4">
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">Wyślij zgłoszenie</button>
                    </div>
                </div>
                <div class="col-sm-2"></div>

            </div>

        </form>



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
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php

                // Compose query
                $queryString = "SELECT * FROM `zgloszenia`";

                $db = new Mysql;

                $db->dbConnect();

                $result = $db->performQuery($queryString);

                while ($row = $result->fetch_assoc()) {

                    // Generate object
                    $obj = new Zgloszenie(
                        $row['id'], $row['created_by'], $row['czas_wprowadzenie'], $row['zamowienie'], $row['link'], 
                        $row['syntetyka'], $row['mpk'], $row['podmiot'], $row['cost'], $row['project'], $row['amount'], 
                        $row['comment'], $row['status'], $row['zatwierdzajacy'], $row['czas_zatwierdzenia'], $row['zamawiajacy'], 
                        $row['czas_zamowienia'], $row['data_dostawy'], $row['attachment_uri']);

                    echo "<tr id='main-row-" . $obj->get_id() . "'>";
                    echo "<th scope='col'>" . $obj->get_id() . "</th>";
                    echo "<td>" . $obj->get_czas_wprowadzenie() . "</td>";
                    echo "<td>" . $obj->getCreateByDisplayName() . "</td>";
                    echo "<td>" . $obj->get_syntetyka() . "</td>";
                    echo "<td>" . $obj->get_mpk() . "</td>";
                    echo "<td>" . $obj->getPodmiotDisplayValue() . "</td>";
                    echo "<td>" . $obj->get_cost() . "</td>";
                    echo "<td>" . $obj->get_project() . "</td>";
                    echo "<td><a href='" . $obj->get_link() . "' target='_blank'>" . $obj->get_link() . "</a></td>";
                    echo "<td>" . $obj->get_amount() . "</td>";
                    echo "<td>" . $obj->getStatusDisplayValue() . "</td>";
                    echo "</tr>";
                }

                $db->dbDisconnect();

                ?>


            </tbody>

        </table>

    </div>

    <!-- Modals -->
    <div id='image-modal-container'></div>
    <div id='assignment-modal-container'></div>
    <div id='work-completed-modal-container'></div>
    <div id='work-rejected-modal-container'></div>
    <div id='history-modal-container'></div>
    <div id='arrival-modal-container'></div>

    <!-- JS scripts -->
    <script src="js/script.js"></script>
    <script src="js/modal_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>