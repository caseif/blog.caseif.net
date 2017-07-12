<?php
ob_start();

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/util/parser.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/parsedown.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/util/connect.php');

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

if ((isset ($_COOKIE['userid'])) && (isset ($_COOKIE['username']))){
	$userid = $_COOKIE['userid'];
	$username = $_COOKIE['username'];
}
else {
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
}
if (isset($_GET['id'])){
	$id = $_GET['id'];
    $preview = 180;
    $dots = false;
    while (substr($description, $preview, 1) != " " && strlen($description) > $preview) {
        $preview += 1;
    }
    if (strlen($description) > $preview){
        $description = substr($description, 0, $preview);
        $dots = true;
    }
    if ($dots) {
        $description = $description.". . .";
    }
}

function ie(){
	if (preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])){
		return true;
	}
	else
		return false;
}

function randStr($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/lib/prism/styles.css">
	<link rel="icon" type="image/png" href="/images/icon.png">

	<meta property="og:type" content="summary">

	<meta property="fb:admins" content="100000997811607">

	<?php
	echo "<meta property='og:image' content='https://".$_SERVER['HTTP_HOST']."/images/icon.png'>";
	if (isset($pagetitle)){
		echo "<title>".$pagetitle."</title>";
		echo "<meta property='og:url' content='https://".$_SERVER['HTTP_HOST']."/post.php?id=".$id."'>";
		echo '<meta property="og:title" content="'.$pagetitle.'">';
		$description = str_replace("'", "%27", $description);
		echo "<meta property='og:description' content='".strip_tags($description)."'>";
	} else {
		echo "<title>caseif.net</title>";
	}

	?>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="/js/snow.js"></script>
	<script src="/lib/prism/core.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<?php
	if (substr($_SERVER['HTTP_HOST'], 0, 4) !== "test") {
	?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-101944034-2', 'auto');
			ga('send', 'pageview');
		</script>
	<?php
	}
	?>

	<script>
	var snow = false;

	function delay(time) {
		var d1 = new Date();
		var d2 = new Date();
		while (d2.valueOf() < d1.valueOf() + time) {
			d2 = new Date();
		}
	}

	var nextPage = 2;
	function loadComments(page){
		$(document).ready(function(){
			$.get('/comments.php?p=' + page, function(data){
				$('#comments').append(data);
			});
		});
		$('.loadmore').html($('.loadmore').html().replace('loadComments([0-9])', 'loadComments(' + nextPage + ')'));
		nextPage += 1;
	}

	function like(id){
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}
		else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET", "util/submit_like.php?id=" + id + "&unlike=0");
		xmlhttp.send();
		document.getElementById("likeAnchor").href = document.getElementById("likeAnchor").href.replace("like", "unlike");
		document.getElementById("likeImage").src = document.getElementById("likeImage").src.replace("like.jpg", "unlike.jpg");
		delay(50);
		$('#likeCount').load('/util/get_likes.php?id=' + id, function(){
			console.log('Refreshed like count');
		});
	}

	function unlike(id){
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}
		else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET", "util/submit_like.php?id=" + id + "&unlike=1");
		xmlhttp.send();
		document.getElementById("likeAnchor").href = document.getElementById("likeAnchor").href.replace("unlike", "like");
		document.getElementById("likeImage").src = document.getElementById("likeImage").src.replace("unlike.jpg", "like.jpg");
		delay(50);
		$('#likeCount').load('/util/get_likes.php?id=' + id, function(){
			console.log('Refreshed like count');
		});
	}

	function getCookie(c_name){
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1){
			c_start = c_value.indexOf(c_name + "=");
		}
		if (c_start == -1){
			c_value = null;
		}
		else {
			c_start = c_value.indexOf("=", c_start)+ 1;
			var c_end = c_value.indexOf(";", c_start);
			if (c_end == -1){
				c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	}

	function htmlDecode(input){
		var e = document.createElement('div');
		e.innerHTML = input;
		return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
	}

	function confirmDeleteComment(id){
		if (confirm('Are you sure you want to delete this comment?')){
			$.ajax({
				url: "util/delete_comment.php",
				type: "POST",
				data: {id : id},
				dataType: "html",
				success: function() {
					$('#comment_' + id).fadeOut(1000, function(){
						$('#comment_' + id).remove();
					});
				}
			});
		}
	}

	function genMessage() {
		var messages = Array(
			"There are no real rules about posting.", // 8
			"If you enjoy any rival sites &mdash; DON'T.", // 10
			"Lurk moar &mdash; it's never enough.", // 12
			"Nothing is Sacred.", // 13
			"Do not argue with a troll &mdash; it means that they win.", // 14
			"One cat leads to another.", // 18
			"The more you hate it, the stronger it gets.", // 19
			"No real limits of any kind apply here &mdash; not even the sky.", // 30
			"CAPS LOCK IS CRUISE CONTROL FOR COOL.", // 31
			"If there isn't enough just ask for moar.", // 41
			"It will always need moar sauce.", // 48
			"The internet makes you stupid.", // 49
			"The internet is SERIOUS F***ING BUSINESS.", // 62
			"If you cannot understand it, it is machine code.", // 89
			"ZOMG NONE" // 100
		);
		var message = messages[Math.floor(Math.random() * messages.length)];
		$('#tagline').html(message);
	}

	$(document).ready(
		function() {
			genMessage();
			$('#nav-images').css('right', $('#nav-buttons').width()
					+ parseInt($('.navbutton').css('padding-left').replace('px', '')));
		}
	);
    
    function showAllRecent() {
        $('#all-recent').css('display', 'block');
        $('#show-hide-recent').html('Hide ' + $('#show-hide-recent').attr('data-addl') + ' more');
        $('#show-hide-recent').attr('href', 'javascript:hideAllRecent()');
    }
    
    function hideAllRecent() {
        $('#all-recent').css('display', 'none');
        $('#show-hide-recent').html('+' + $('#show-hide-recent').attr('data-addl') + ' more...');
        $('#show-hide-recent').attr('href', 'javascript:showAllRecent()');
    }
	</script>
</head>
<body>
<div id="container" class="container">
<div id="navbar">
	<span id="title">
		<a href="/">caseif's blog</a>
	</span>
	<span id="tagline"></span>
	<div id="nav-buttons">
		<span id="nav-images">
			<a class="navbutton" href="https://twitter.com/case_if" target="_blank">
				<img src="/images/twitter.svg" alt="Twitter" width=36 height=36>
			</a>
		</span>
		<a class="navbutton" href="/about.php">About</a>
	</div>
</div>
<div id="snowToggle"></div>
<div id="main-content">
