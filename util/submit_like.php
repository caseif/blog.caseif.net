<?php
require($_SERVER['DOCUMENT_ROOT'].'/util/connect.php');
$link = getDbConnection();
$id = $_GET['id'];
if ($_GET['unlike'] == 1)
	mysql_query("DELETE FROM likes WHERE post = '".$id."' && ip = '".$_SERVER['REMOTE_ADDR']."'");
else {
	// check that user hasn't already liked this post
	$numrows = mysql_num_rows(mysql_query("SELECT * FROM likes WHERE post = '".$id."' && ip = '".$_SERVER['REMOTE_ADDR']."'")); 
	if ($numrows == 0)
		mysql_query("INSERT INTO likes (ip, post) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$id."')");
}
mysql_close();
?>