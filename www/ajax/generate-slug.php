<?php
    include("../../include/config.php");
    include("../../include/session.php");
    include("../../include/mysql.php");

    header('Content-type: text/xml');

    if (!isset($_GET['title'])) {
        die("<root><error>A title is required</error><root>");
    }
?>
<root>
<?php
    $slug = generateSlug($_GET['title']);
    echo "<slug>" . $slug . "</slug>";
?>
</root>
