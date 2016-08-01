<?php
require_once($_SERVER['DOCUMENT_ROOT']."/templates/preheader.php");
if (isset($_POST['id'])){
    $link = getDbConnection();
	$dbid = $link->query("SELECT user FROM comments WHERE id = ".$_POST['id'])->fetch_array()['user'];
	if (isset($userid) && $userid == $dbid) {
		$link->query("DELETE FROM comments WHERE id = ".$_POST['id']);
    }
	else {
		echo $dbid."/".$userid;
    }
	$link->close();
}
?>