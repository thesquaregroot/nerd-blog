<?php

    if (isset($ADMIN)) {
        ?>
        <link rel="stylesheet" type="text/css" href="/css/blog/admin.css"/>
        <script src="/js/blog/admin.js"></script>
        <?php
    }
    
    $HTML_FILE = realpath(dirname(__FILE__) . "/html/bottom.html");
    if ($HTML_FILE) {
        echo file_get_contents($HTML_FILE);
    }

    $_mysqli->close();
?>
