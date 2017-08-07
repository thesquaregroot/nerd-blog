<?php
    
    $HTML_FILE = realpath(dirname(__FILE__) . "/html/bottom.html");
    if ($HTML_FILE) {
        echo file_get_contents($HTML_FILE);
    }

    $_mysqli->close();
?>
