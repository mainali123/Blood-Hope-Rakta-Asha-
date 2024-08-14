<?php

if (!isset($_POST['action'])) {
    echo 'Nothing to see here';
    die();
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'dbconnect.php';
    include 'functions.php';
    include 'api.php';
}
