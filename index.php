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
    <title>Leśnik Drzewiarz</title>
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
                <span><b>Dostęp: </b><?php echo $user->getUserTypeDisplayName() ?></span>

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
                    <p class="h1">Formularz zgłoszeniowy</p>
                </div>
                <div class="col-sm-2"></div>

            </div>

            <div class="row">

                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon1">Lokalizacja/Dział</span>
                        <select name="input-dzial" class="form-select" id="basic-addon-select-dzial" required>
                            <option selected disabled value="">-- Wybierz --</option>


                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `lokalizacje` GROUP BY `dzial`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['dzial_code'] . "'>" . $row['dzial'] . "</option>";
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
                        <span class="input-group-text" id="basic-addon2">Status</span>
                        <select name="input-status" class="form-select" id="basic-addon-select-status" required readonly>
                            <option selected value="new">Nowy</option>

                            <?php


                            // $db = new Mysql;

                            // $db->dbConnect();

                            // $result = $db->performQuery("SELECT * FROM `statusy`");

                            // while ($row = $result->fetch_assoc()) {

                            //     echo "<option value='" . $row['value'] . "'>" . $row['label'] . "</option>";
                            // }

                            // $db->dbDisconnect();


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
                        <span class="input-group-text" id="basic-addon3">Poziom</span>
                        <select name="input-poziom" class="form-select" id="basic-addon-select-poziom" required>
                            <option selected disabled value="">-- Wybierz --</option>
                        </select>
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon4">Urządzenie</span>
                        <select name="input-device" class="form-select" id="basic-addon-select-device" required>
                            <option selected disabled value="">-- Wybierz --</option>
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
                        <span class="input-group-text" id="basic-addon3">Pomieszczenie</span>
                        <select name="input-pomieszczenie" class="form-select" id="basic-addon-select-pomieszczenie" required>
                            <option selected disabled value="">-- Wybierz --</option>
                        </select>
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text" id="basic-addon4">Usterka</span>
                        <select name="input-usterka" class="form-select" id="basic-addon-select-usterka" required>
                            <option selected disabled value="">-- Wybierz --</option>
                            <option value="0">Wprowadź ręcznie</option>

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `usterki`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }

                            $db->dbDisconnect();


                            ?>

                        </select>
                        <div class="invalid-feedback">
                            To pole jest wymagane
                        </div>
                    </div>
                    <div id="input-group-usterka-freetext" class="input-group has-validation mb-3 invisible">
                        <input type="text" id="input-usterka-freetext" name="input-usterka-freetext" class="form-control">
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
                        <span class="input-group-text" id="basic-addon3">Dział zgłaszający</span>
                        <select name="input-dzial-zglaszajacy" class="form-select" id="basic-addon3-select" required>
                            <option selected disabled value="">-- Wybierz --</option>

                            <?php


                            $db = new Mysql;

                            $db->dbConnect();

                            $result = $db->performQuery("SELECT * FROM `lokalizacje` GROUP BY `dzial`");

                            while ($row = $result->fetch_assoc()) {

                                echo "<option value='" . $row['dzial_code'] . "'>" . $row['dzial'] . "</option>";
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
                        <input name="input-zdjecie-usterka" class="form-control" type="file" id="input-zdjecie-usterka">
                        <!-- <div class="invalid-feedback">
                            Zdjęcie jest wymagane
                        </div> -->
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
                    <th scope="col">Czas wprowadzenia</th>
                    <th scope="col">Wprowadził(a)</th>
                    <th scope="col">Dział zgłaszający</th>
                    <th scope="col">Dział</th>
                    <th scope="col">Poziom</th>
                    <th scope="col">Pomieszczenie</th>
                    <th scope="col">Urządzenie</th>
                    <th scope="col">Usterka</th>
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
                    $obj = new Zgloszenie($row['id'], $row['created_by'], $row['czas_wprowadzenie'], $row['dzial'], $row['poziom'], $row['pomieszczenie'], $row['status'], $row['usterka'], $row['usterka_manual'], $row['device_file'], $row['device'], $row['dzial_zglaszajacy'], $row['rejected_reason']);

                    echo "<tr id='main-row-" . $obj->get_id() . "'>";
                    echo "<th scope='col'>" . $obj->get_id() . "</th>";
                    echo "<td>" . $obj->get_czas_wprowadzenie() . "</td>";
                    echo "<td>" . $obj->getCreateByDisplayName() . "</td>";
                    echo "<td>" . $obj->get_dzial_zglaszajacy() . "</td>";
                    echo "<td>" . $obj->get_dzial() . "</td>";
                    echo "<td>" . $obj->get_poziom() . "</td>";
                    echo "<td>" . $obj->get_pomieszczenie() . "</td>";
                    echo "<td>" . $obj->get_device() . "</td>";
                    echo "<td>" . $obj->getUsterkaDisplayName() . "</td>";
                    echo "<td><span class='status-stamp'>" . $obj->getStatusDisplayName() . "</span></td>";
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

    <!-- JS scripts -->
    <script src="js/script.js"></script>
    <script src="js/modal_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>