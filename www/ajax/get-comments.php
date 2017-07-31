<?php
    include("../../include/config.php");
    include("../../include/mysql.php");

    header('Content-type: text/xml');
?>
<root>
<?php
    $q = "SELECT *, DATE_FORMAT(time_posted, '%M %e, %Y at %l:%i %p') AS formatted_timestamp FROM post_comments";
    if (isset($_GET['post'])) {
        $q .= " WHERE post_id = '" . real_escape_string($_GET['post']) . "'";
    }
    $q .= " ORDER BY time_posted ASC";
    $comments = query($q);
    while ($comment = fetch_assoc($comments)) {
        echo "<comment>";
            echo "<id>", $comment['id'], "</id>";
            echo "<post_id>", $comment['post_id'], "</post_id>";
            echo "<ip_addr>", $comment['ip_addr'], "</ip_addr>";
            // Need to use htmlspecialchars twice because we're returning XML and don't want to render HTML in comments.
            echo "<alias>", htmlspecialchars(htmlspecialchars($comment['user_name'])), "</alias>";
            echo "<contents>", htmlspecialchars(htmlspecialchars($comment['contents'])), "</contents>";
            echo "<timestamp>", $comment['formatted_timestamp'], "</timestamp>";
        echo "</comment>";
    }
?>
</root>
