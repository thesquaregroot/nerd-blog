<?php
    require_once("config.php");

    if (isset($ADMIN)) {
        if ($ADMIN_FORCE_HTTPS) {
            // force https
            require_once("ssl.php");
        }
        // authenticate
        require_once("authenticate.php");
    }

    // prevent other websites putting page in iframe
    header("X-Frame-Options: SAMEORIGIN");
    header("Content-type: text/html;charset=UTF-8");
    require_once("session.php");
    require_once("mysql.php");
    require_once("head.php");
    require_once("visual_top.php");
?>
