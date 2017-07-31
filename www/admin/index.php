<?php
    $ADMIN=1;
    include('../../include/top.php');
?>

<a name="notification"></a>
<div id="notification-area"></div>

<form id="post_form" method="post" action="#">
    <div class="buttonset">
        <input type="radio" id="int1" name="post_interaction" value="create_post" checked="checked" /><label for="int1">Create a Post</label>
        <input type="radio" id="int2" name="post_interaction" value="edit_post" /><label for="int2">Edit a Post</label>
    </div>

    <div id="post_selector">
        <!-- hidden initially -->
        <select name="post_to_edit" id="post_to_edit">
            <option value="">Select a Post</option>
            <?php
                $r = query("SELECT * FROM posts ORDER BY time_posted DESC");
                while ($post = fetch_assoc($r)) {
                    echo "<option value=\"{$post['id']}\">{$post['id']} - {$post['title']}</option>";
                }
            ?>
        </select>
    </div>

    <input type="text" name="title" id="title" size=50 required="required" placeholder="Title"/>
    <input type="text" name="slug" id="slug" size=50 required="required" placeholder="Slug"/>
    <input type="text" name="author" id="author" size=50 required="required" placeholder="Author"/>
    <div id="categories" class="buttonset">
        <?php
            $r = query("SELECT * FROM categories");
            while ($cat = fetch_assoc($r)) {
                echo "<input type=\"checkbox\" id=\"category{$cat['id']}\" name=\"category{$cat['id']}\"/><label for=\"category{$cat['id']}\">{$cat['category']}</label>";
            }
        ?>
    </div>
    <a name=edit></a>
    <textarea class="ui-widget" name="contents" id="contents" required="required" placeholder="Enter post body here..."></textarea><br/>
    <a name=preview></a>
    <div id="preview_area">
        <h3 id="title_area"></h3>
        <hr/>
        <div id="contents_area">
        </div>
    </div>
    <input id="preview_button" class="button" type="button" value="Preview"/>
    <input id="submit_button" class="button" type="submit" value="Post"/>
</form>

<?php
    include('../../include/bottom.php');
?>
