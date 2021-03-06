<?php

//checks for existing users returns false if user exists
function check_user($userEmail, $db)
{
    $user_check_query = "SELECT * FROM users WHERE email='$userEmail' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        return false;
    }
    return true;
}

//adds user to database
function add_user($fullname, $phone, $email, $password_1, $db)
{

    $password = md5($password_1); //encrypt the password before saving in the database

    $query = "INSERT INTO users (fullname, phone, email, password, role) 
                VALUES('$fullname', '$phone',  '$email', '$password', 'user')";
    mysqli_query($db, $query);
    $_SESSION['success'] = "Account Creation Successful";
}

//checks and returns true if user email and password matches, else returns false
function login_user($email, $password, $db)
{

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
        return $results;
    }
    return false;
}

//selects all user information ready for display
function showProfile($db)
{
    $profile_query = "select * from users where email='" . $_SESSION['email'] . "'";
    $presult = mysqli_query($db, $profile_query);
    if (mysqli_num_rows($presult) == 1) {
        $user = mysqli_fetch_array($presult);
        return $user;
    }
    return false;
}

//get all users that are not admin
function getAllUsers($db)
{
    $query = "SELECT * FROM users where role='user'";

    $allUsers = mysqli_query($db, $query);
    $users = [];
    if (mysqli_num_rows($allUsers) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($allUsers)) {
            $users[$count] = $row;
            $count++;
        }
    }
    return $users;
}

//set user as an admin role
function giveAdmin($account, $db)
{
    $query = "UPDATE users 
					SET role = 'admin'
					WHERE id = '$account'";

    mysqli_query($db, $query);
    $_SESSION['success'] = "Admin Add Successful";
}


//get users by id
function getUserByID($id, $db)
{
    $query = "select * from users where id='" . $id . "'";
    $presult = mysqli_query($db, $query);
    if (mysqli_num_rows($presult) == 1) {
        $user = mysqli_fetch_array($presult);
        return $user;
    }
    return null;
}
