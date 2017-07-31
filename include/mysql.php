<?php
    require_once("config.php");

    if (isset($ADMIN)) {
        $_mysqli = new mysqli($MYSQL_HOST, $MYSQL_USERNAME_ADMIN, $MYSQL_PASSWORD_ADMIN, $MYSQL_SCHEMA);
    } else {
        $_mysqli = new mysqli($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_SCHEMA);
    }
    $_mysqli->set_charset("utf8mb4");

    function query($q) {
        global $_mysqli;
        $argv = func_get_args();
        $argc = func_num_args();

        $argv[0] = str_replace('%', '%%', $argv[0]);
        $argv[0] = str_replace('%%s', '%s', $argv[0]);

        for ($i=1; $i<$argc; $i++) {
            $argv[$i] = $_mysqli->real_escape_string($argv[$i]);
        }
        $q = call_user_func_array('sprintf', $argv);

        $r = $_mysqli->query($q) OR print($_mysqli->error);
        return $r;
    }
    function fetch_assoc($r) {
        return $r->fetch_assoc();
    }
    function fetch_array($r) {
        return $r->fetch_array($r);
    }
    function num_rows($r) {
        return $r->num_rows;
    }
    function insert_id() {
        global $_mysqli;
        return $_mysqli->insert_id;
    }
    function real_escape_string($str) {
        global $_mysqli;
        return $_mysqli->real_escape_string($str);
    }
    function sql_error() {
        global $_mysqli;
        return $_mysqli->error;
    }

    function print_sql_status($task) {
        if (sql_error()) {
            echo "<p class=bad>$task: Failed.</p>";
        } else {
            echo "<p class=good>$task: Successful.</p>";
        }
    }

    // database specific funcitons
    function getPosts() {
        return query("SELECT *, DATE_FORMAT(time_posted, '%M %e, %Y at %l:%i %p') AS formatted_time FROM posts ORDER BY time_posted DESC");
    }

    function getCategories($id) {
        return query("SELECT post_categories.*, categories.category
                      FROM post_categories
                        INNER JOIN categories
                          ON post_categories.category_id = categories.id
                      WHERE post_categories.post_id = '%s'", $id);
    }

    function generateSlug($title) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }
?>

