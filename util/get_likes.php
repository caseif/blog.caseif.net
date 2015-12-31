<?php
require($_SERVER['DOCUMENT_ROOT']."/util/connect.php");
$link = getDbConnection();
echo mysql_num_rows(mysql_query("SELECT * FROM likes WHERE post = '".$_GET['id']."'"));
mysql_close();
?>