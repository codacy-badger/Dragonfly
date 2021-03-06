<?php

/**
 * Check if user is logged
 *
 * @return void
 */
function logged_in() {
    return isset($_SESSION['admin_id']);
}

/**
 * Redirect user to login page if not logged
 *
 * @return void
 */
function confirm_logged_in() {
    if (!logged_in()) {
        redirect_to("login.php");
    }
}

/**
 * Redirect to page url
 *
 * @param string $new_location
 * @return void
 */
function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}

/**
 * Attempt to login user in database
 *
 * @param string $username
 * @param string $password
 * @return void
 */
function attempt_login($username, $password) {
    $user = find_user_by_username($username);
    if ($user) {
        if (password_check($password, $user["Password"])) {
            return $user;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * Find user by username in user tables
 *
 * @param string $username
 * @return void
 */
function find_user_by_username($username) {
    global $connection;
    $safe_username = mysqli_real_escape_string($connection, $username);
    
    $query  = "SELECT * ";
    $query .= "FROM MetaUser ";
    $query .= "WHERE Username = '{$safe_username}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);

    if($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

/**
 * Find user by id in user tables
 *
 * @param int $user_id
 * @return void
 */
function find_user_by_id($user_id) {
    global $connection;
    $safe_user_id = mysqli_real_escape_string($connection, $user_id);
    
    $query  = "SELECT * ";
    $query .= "FROM MetaUser ";
    $query .= "WHERE IDUser = {$safe_user_id} ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);

    confirm_query($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}