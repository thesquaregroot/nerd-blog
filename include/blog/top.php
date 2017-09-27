<?php
    require_once("config.php");

    // prevent other websites putting page in iframe
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

    require_once("session.php");
    require_once("mysql.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php
            if (isset($SUBTITLE)) {
                echo "<title>$SUBTITLE - $TITLE</title>";
            } else {
                echo "<title>$TITLE</title>";
            }
        ?>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width"/>


        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto|Roboto+Mono">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>

        <link rel="stylesheet" type="text/css" href="/css/blog/blog.css" />
        <script src="/js/blog/blog.js"></script>
        <?php
            if (isset($ADMIN)) {
                ?><link rel="stylesheet" type="text/css" href="/css/blog/admin.css"/><?php
                ?><script src="/js/blog/admin.js"></script><?php
            }
            if ($FAVICON) {
                ?><link rel="icon"          type="image/x-icon" href="/img/favicon.ico" /><?php
                ?><link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" /><?php
            }
        ?>
    </head>
    <body>
        <?php
            print_top();
        ?>
        <div class="content">

