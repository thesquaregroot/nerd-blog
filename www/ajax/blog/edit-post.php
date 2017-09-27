<?php
    $ADMIN=1;

    include("../../../include/blog/config.php");
    include("../../../include/blog/session.php");
    include("../../../include/blog/authenticate.php");
    include("../../../include/blog/mysql.php");

    header('Content-type: text/xml');

    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $author = $_POST['author'];
    $contents = $_POST['contents'];
    if (!$post_id || !$title || !$slug || !$author || !$contents) {
        die("<root><error>Incomplete data posted.</error></root>");
    }
?>
<root>
<?php
    // edit post
    query("UPDATE posts SET title = '%s', slug = '%s', author = '%s', contents = '%s', last_updated = NOW() WHERE id = '%s'",
        $title,
        $slug,
        $author,
        $contents,
        $post_id);
    // update categories
    // delete old ones first
    query("DELETE FROM post_categories WHERE post_id = '%s'", $post_id);
    // then add new ones
    $r = query("SELECT * FROM categories");
    while ($cat = fetch_assoc($r)) {
        if (isset($_POST['category' . $cat['id']])) {
            query("INSERT INTO post_categories (post_id, category_id) VALUES ('%s', '%s')",
                $post_id,
                $cat['id']);
        }
    }

    echo "<success>true</success>";
?>
</root>
