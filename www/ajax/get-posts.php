<?php
    include("../../include/config.php");
    include("../../include/mysql.php");

    header('Content-type: text/xml');
?>
<root>
<?php
    $query = "SELECT *, DATE_FORMAT(time_posted, '%M %e, %Y at %l:%i %p') AS formatted_time FROM posts";
    if (isset($_GET['id'])) {
        // get single post
        $query .= " WHERE id = " . real_escape_string($_GET['id']);
    } else {
        $query .= " ORDER BY time_posted DESC";
        if (isset($_GET['recent'])) {
            $query .= " LIMIT " . real_escape_string($_GET['recent']);
        }
    }
    $posts = query($query);
    while ($post = fetch_assoc($posts)) {
        echo "<post>";
        echo "<id>" . $post['id'] . "</id>";
        echo "<title>" . $post['title'] . "</title>";
        echo "<slug>" . $post['slug'] . "</slug>";
        echo "<author>" . $post['author'] . "</author>";
        echo "<contents>" . htmlspecialchars($post['contents']) . "</contents>";
        echo "<posted>" . $post['formatted_time'] . "</posted>";
        $categories = query("SELECT post_categories.*, categories.category FROM post_categories INNER JOIN categories ON post_categories.category_id = categories.id WHERE post_categories.post_id = '%s'", $post['id']);
        while ($category = fetch_assoc($categories)) {
            echo "<category id=\"" . $category['category_id'] . "\">" . $category['category'] . "</category>";
        }
        echo "</post>";
    }
?>
</root>
