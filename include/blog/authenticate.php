<?php
    // handle printing of login form
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="'.$ADMIN_REALM.'"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    } else {
        if (!($_SERVER['PHP_AUTH_USER'] == $ADMIN_LOGIN_USERNAME && hash('sha256', $_SERVER['PHP_AUTH_PW']) == $ADMIN_LOGIN_PASSWORD)) {
            die("Invalid credentials.");
        }
    }
?>
