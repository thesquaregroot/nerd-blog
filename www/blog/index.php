<?php
    require_once("../../include/blog/top.php");

    if (isset($_GET['post'])) {
        // display selected post
        $post = fetch_assoc(query("SELECT title FROM posts WHERE id = '%s'", $_GET['post']));
    }
    if (isset($_GET['slug'])) {
        $post = fetch_assoc(query("SELECT id, title FROM posts WHERE slug = '%s'", $_GET['slug']));
        $_GET['post'] = $post['id'];
    }
?>

<?php
    if (isset($_GET['post'])) {
        // display selected post
        $post_id = $_GET['post'];
        $prev_id = intval($post_id) - 1;
        $next_id = intval($post_id) + 1;
        $GET_POST_QUERY = "SELECT title, slug FROM posts WHERE id = '%s'";
        echo "<div class=\"blog-navigation\">";
        if ($prev_id > 0) {
            $prev_post = fetch_assoc(query($GET_POST_QUERY, $prev_id));
            echo "<a class=\"button\" href=\"/blog/" . $prev_post['slug'] . "\" title=\"" . htmlspecialchars($prev_post['title']) . "\">&lt; Prev</a>";
        }
        echo "<a class=\"button\" href=\"/blog/\">All</a>";
        $next_post = fetch_assoc(query($GET_POST_QUERY, $next_id));
        if ($next_post) {
            echo "<a class=\"button\" href=\"/blog/" . $next_post['slug'] . "\" title=\"" . htmlspecialchars($next_post['title']) . "\">Next &gt;</a>";
        }
        $post = fetch_assoc(query("SELECT *, DATE_FORMAT(time_posted, '%M %D, %Y at %r') AS formatted_time FROM posts WHERE id = '%s'", $post_id));
        echo "</div>";
        echo "<div id=\"post-with-title\">";
        echo "<div id=\"post-timestamp\">{$post['formatted_time']}</div>";
        echo "<div id=\"post-title\">{$post['title']}</div>";
        echo "<div id=\"post-contents\">";
        // not sanitizing because we are allowing HTML in posts
        echo $post['contents'];
        echo "</div>";

        if ($ALLOW_COMMENTS) {
            echo "<div class=\"comment-area\">";
            echo "<h3>Comments</h3>";

            // pre-existing comments
            echo "<div class=\"comments\">";
            echo "</div>";

            // post a new comment
            echo "<form id=\"comment-form\">";
                echo "<div class=\"post-comment\">";
                    echo "<textarea id=\"comment-text\" required=\"required\" placeholder=\"Enter a comment here...\">";
                    echo "</textarea>";

                    echo "<input type=\"text\" id=\"alias\" required=\"required\" class=\"extra-input\" placeholder=\"Your name.\"/>";

                    echo "<input type=\"submit\" id=\"submit-comment\" value=\"Post\"/>";
                echo "</div>"; // comment box
            echo "</form>";
            echo "</div>"; // comment area

        }

        echo "</div>";
    }
    else {
        // display list of posts
        echo "<div id=\"category_selectors\">";
        echo "<button onclick=\"select('all', this);\">All Posts</button>";
        echo "<button onclick=\"select('Blog Entry', this);\">Blog Entries</button>";
        echo "<button onclick=\"select('Other', this);\">Other</button>";
        echo "</div>";
        echo "<div class=\"posts\" style=\"text-align: left;\">";
        $posts = getPosts();
        while ($post = fetch_assoc($posts)) {
            echo "<div class=post>";
            echo "<a class=\"title\" href=\"/blog/" . $post['slug'] . "\">" . $post['title'] . "</a>";
            echo "<span class=timestamp>" . $post['formatted_time'] . "</span>";
            $categories = getCategories($post['id']);
            while ($category = fetch_assoc($categories)) {
                echo "<small>[" . $category['category'] . "]</small> ";
            }
            echo "</div>";
        }
        echo "</div>";
    }
?>

<script type="text/javascript">
    $(function() {
        let postId = 0;
        <?php
            if (isset($_GET['post'])) {
                echo "postId = '", $_GET['post'], "';";
            }
        ?>
        // fill in comment space
        loadComments(postId);
        // post comment event
        $('#comment-form').submit(function (e) {
            e.preventDefault();
            postComment(postId, $('#alias').val(), $('#comment-text').val(), function(success) {
                if (success) {
                    $('#comment-text').val('');
                    $('#alias').val('');
                    loadComments(postId);
                }
            });
        });
    });
</script>

<?php
    require_once("../../include/blog/bottom.php");
?>
