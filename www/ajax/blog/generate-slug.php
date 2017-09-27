<?php
    include("../../../include/blog/config.php");
    include("../../../include/blog/session.php");
    include("../../../include/blog/mysql.php");

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
