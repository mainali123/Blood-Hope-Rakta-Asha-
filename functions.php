<?php

function user_signup($username, $password, $phone, $email, $address, $role)
{
    if (strlen((string)$phone) != 10) {
        return json_encode(array('error' => 'true', 'message' => 'Invalid phone number'));
    }

    global $conn;

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, password, phone_number, email, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    
    try {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $hashed_password, $phone, $email, $address, $role);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            mysqli_stmt_close($stmt);
            return json_encode(array('error' => 'false', 'message' => 'User registered successfully'));
        } else {
            mysqli_stmt_close($stmt);
            return json_encode(array('error' => 'true', 'message' => 'Unable to create user'));
        }

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Duplicate entry
            return json_encode(array('error' => 'true', 'message' => 'Phone number already exists'));
        } else {
            return json_encode(array('error' => 'true', 'message' => 'Internal server error'));
            // return json_encode(array('error' => 'true', 'message' => 'Database error: ' . $e->getMessage()));
        }
    }
}

function user_login($phone, $password)
{
    if (strlen((string)$phone) != 10) {
        return json_encode(array('error' => 'true', 'message' => 'Invalid phone number'));
    }
    
    global $conn;

    $query = "SELECT * FROM users WHERE phone_number = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $phone);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $dbpassword = $row['password'];

            if (password_verify($password, $dbpassword)) {
                mysqli_stmt_close($stmt);
                return json_encode(array('error' => 'false', 'message' => 'User loggedin successfully'));
            } else {
                mysqli_stmt_close($stmt);
                return json_encode(array('error' => 'true', 'message' => 'Invalid password'));
            }
        } else {
            mysqli_stmt_close($stmt);
            return json_encode(array('error' => 'true', 'message' => 'User doesn\'t exists'));
        }  
    } else {
        mysqli_stmt_close($stmt);
        return json_encode(array('error' => 'true', 'message' => 'Internal server error'));
    }
}
