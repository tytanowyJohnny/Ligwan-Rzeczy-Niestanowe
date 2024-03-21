<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/model/user.php';

if (!isset($_SESSION)) {
    session_start();
    $user = unserialize($_SESSION['user_object']);

    $user->logout();
}

header('Location: /login.php');

?>