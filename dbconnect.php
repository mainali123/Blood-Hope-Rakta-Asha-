<?php

$host = 'localhost';
$database = 'blood';
$username = 'root';
$password = 'Admin123###';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Connect Error');
} else {
    // echo 'Connection OK';
}
