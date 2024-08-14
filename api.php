<?php

if (isset($_POST['action'])) {
    $action  = $_POST['action'];

    switch($action){
        case 'apitest':
            echo json_encode(array('error' => 'false', 'message' => 'API TEST SUCCESSFUL'));
            break;
        case 'signup_user':
            echo user_signup($_POST['username'], $_POST['password'], $_POST['phone'], $_POST['email'] ?? '', $_POST['address'], $_POST['role']);
            break;
        case 'login_user':
            echo user_login($_POST['phone'], $_POST['password']);
            break;
        default:
            echo json_encode(array('error' => 'true', 'message' => 'Invalid action request'));
            break;
    }
}
