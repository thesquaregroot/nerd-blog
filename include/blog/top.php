<?php
    require_once("config.php");

    header("X-Frame-Options: SAMEORIGIN");
    header("Content-type: text/html;charset=UTF-8");

    if (isset($ADMIN)) {
        if ($ADMIN_FORCE_HTTPS) {
            // force https
            require_once("ssl.php");
        }
        // authenticate
        require_once("authenticate.php");
    }

    // prevent other websites putting page in iframe
    require_once("session.php");
    require_once("mysql.php");

    $HTML_FILE = realpath(dirname(__FILE__) . "/html/top.html");
    if ($HTML_FILE) {
        echo file_get_contents($HTML_FILE);
    }

?>
