<?php
require('templates/preheader.php');
if (isset($_POST['id'])){
    require($_SERVER['DOCUMENT_ROOT']."/util/connect.php");
    $link = getDbConnection();
	$dbid = $link->query('SELECT user FROM comments WHERE id = '.$_POST['id'])->fetch_array()['user'];
	if (isset($userid) && $userid == $dbid)
		$link->query('DELETE FROM comments WHERE id = '.$_POST['id']);
	else
		echo $dbid.'/'.$userid;
	$link->close();
}
?>