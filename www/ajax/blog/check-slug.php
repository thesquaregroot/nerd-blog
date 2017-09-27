<?php
    include("../../include/blog/config.php");
    include("../../include/blog/session.php");
    include("../../include/blog/mysql.php");

    header('Content-type: text/xml');

    if (!isset($_GET['slug'])) {
        die("<root><error>A slug is required</error><root>");
    }
?>
<root>
<?php
    $slug = $_GET['slug'];
    $post_id = $_GET['post_id'];
    echo "<slug>" . $slug . "</slug>";

    $result = query("SELECT 1 FROM posts WHERE slug = '%s' and id != '%s'", $slug, $post_id);
    $exists = num_rows($result) > 0;
    echo "<exists>" . $exists . "</exists>";
?>
</root>
