<?php
    $ADMIN=1;

    include("../../include/blog/config.php");
    include("../../include/blog/session.php");
    include("../../include/blog/authenticate.php");
    include("../../include/blog/mysql.php");

    header('Content-type: text/xml');

    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $author = $_POST['author'];
    $contents = $_POST['contents'];
    if (!$title || !$slug || !$author || !$contents) {
        die("<root><error>Incomplete data posted.</error></root>");
    }
?>
<root>
<?php
    // add post
    query("INSERT INTO posts (title, slug, author, contents, time_posted) VALUES ('%s', '%s', '%s', '%s', NOW())",
        $title,
        $slug,
        $author,
        $contents);
    $post_id = insert_id();

    // add categories
    $r = query("SELECT * FROM categories");
    while ($cat = fetch_assoc($r)) {
        if (isset($_POST['category' . $cat['id']])) {
            query("INSERT INTO post_categories (post_id, category_id) VALUES ('%s', '%s')",
                $post_id,
                $cat['id']);
        }
    }

    echo "<postId>" . $post_id . "</postId>";
?>
</root>
