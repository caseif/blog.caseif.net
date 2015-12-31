<?php
function getDbConnection() {
    $link = mysqli_connect('localhost', 'site', file_get_contents('/etc/sql.secret'));
    $link->select_db('blog');
    return $link;
}
?>