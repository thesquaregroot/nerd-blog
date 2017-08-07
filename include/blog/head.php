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
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/css/blog/blog.css" />
<!-- Google Fonts -->
<link href="//fonts.googleapis.com/css?family=Roboto|Roboto+Mono" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jQuery -->
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- JS -->
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
