<?php
    include("../../../include/blog/config.php");
    include("../../../include/blog/session.php");
    include("../../../include/blog/mysql.php");

    header('Content-type: text/xml');

    if (!$ALLOW_COMMENTS) {
        die("<root><error>Comments disabled.</error></root>");
    }
?>
<root>
    <?php
        if (isset($_POST['post_id']) && isset($_POST['contents'])) {
            $alias = isset($_POST['alias'])?$_POST['alias']:"";
            query("INSERT INTO post_comments (post_id, ip_addr, user_name, contents) VALUES ('%s', '%s', '%s', '%s')",
                $_POST['post_id'],
                $_SESSION['ip'],
                $alias,
                $_POST['contents']); // stored with <> and other html special chars.  CONVERT BEFORE PRINTING!
            if (!sql_error()) {
                echo "<success/>";

                // TODO: send mail
                if ($EMAIL_ENABLED) {
                    $post = fetch_assoc(query("SELECT * FROM posts WHERE id = '%s'", $_POST['post_id']));

                    $to = $EMAIL_RECIPIENT;
                    $subject = "New comment on \"{$post['title']}\"";

                    $message = $_SESSION['ip'] . " ({$alias}) commented on \"{$post['title']}\":";
                    $message .= "\r\n\r\n{$_POST['contents']}";
                    $message .= "\r\n\r\nURL to post: " . $BASE_URL . "/blog/{$post['slug']}";

                    $headers =  "FROM: " . $EMAIL_SENDER . "\r\n" .
                                "Reply-To: " . $EMAIL_REPLY_TO . "\r\n" .
                                "X-Mailer: PHP/" . phpversion();

                    mail($to, $subject, $message, $headers);
                }
            } else {
                echo "<error>", sql_error(), "</error>";
            }
        } else {
            echo "<error>Missing parameters.</error>";
        }
    ?>
</root>
