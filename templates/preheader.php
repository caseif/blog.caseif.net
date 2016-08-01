<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/util/parser.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/parsedown.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/util/connect.php');

session_start();
	
if ((isset($_COOKIE['userid'])) && (isset($_COOKIE['username']))){
	$userid = $_COOKIE['userid'];
	$username = $_COOKIE['username'];
}
else {
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
}

// dunno why this name is fucky, but the site works so I'm not touching it
function startsWithh($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
?>