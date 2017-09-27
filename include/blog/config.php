<?php
    // Website
    $TITLE = "My Nerdy Blog";
    $BASE_URL = "http://localhost:8080";
    $ALLOW_COMMENTS = true;
    $ALLOW_HEARTS = true;
    $FAVICON = false;

    // Admin
    // default username/password: 'admin'/'admin'
    $ADMIN_LOGIN_USERNAME = "admin";
    $ADMIN_LOGIN_PASSWORD = hash('sha256', 'admin');
    $ADMIN_FORCE_HTTPS = false; // true -> redirect admin page requests to HTTPS

    // MySQL
    $MYSQL_HOST = "localhost";
    $MYSQL_SCHEMA = "nerdblog";

    $MYSQL_USERNAME = "test";
    $MYSQL_PASSWORD = "test";

    $MYSQL_USERNAME_ADMIN = "admin";
    $MYSQL_PASSWORD_ADMIN = "admin";

    // Email
    $EMAIL_ENABLED = false;
    $EMAIL_RECIPIENT = "";
    $EMAIL_SENDER = "";
    $EMAIL_REPLY_TO = "";

    function print_top() {
        global $TITLE;
        ?><div class="top"><a href="/blog/"><?php echo $TITLE; ?></a></div><?php
    }
?>
