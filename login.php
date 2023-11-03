<?php

include_once('db/db.php');
include('includes/model/user.php');

if (!isset($_SESSION)) {
    session_start();
    
    if(isset($_SESSION['user_object']))
        header('Location: /index.php');
}

if(isset($_POST['username']) && isset($_POST['password'])) {

    // echo "TEST";

    $user = new UserService($_POST['username'], $_POST['password']);
    $loginResult = $user->login();

    // echo $loginResult;

    if($loginResult) {
        $_SESSION['user_object'] = serialize($user);
        header('Location: /index.php');
    }

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

</head>

<body>

    <div class="container pt-5">


        <div class="row mb-3">
            <div class="col-sm-5"></div>
            <div class="col-sm-2 text-center">
                <p class="h1">Logowanie</p>
            </div>
            <div class="col-sm-5"></div>
        </div>

        <div class="row">

            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form action="login.php" method="POST" class="p-3 needs-validation form-background" novalidate>

                    <div class="input-group has-validation mb-3">
                        <input name="username" type="text" class="form-control" placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" autofocus required>
                        <div class="invalid-feedback">
                            Wprowadź nazwę użytkownika
                        </div>
                    </div>

                    <div class="input-group has-validation mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Hasło" aria-label="Hasło" required>
                        <div class="invalid-feedback">
                            Wprowadź hasło
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">Zaloguj</button>
                    </div>

                </form>
            </div>
            <div class="col-sm-4"></div>

        </div>

    </div>
    <!-- JS scripts -->
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>